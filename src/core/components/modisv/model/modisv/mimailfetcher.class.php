<?php

/* * *******************************************************************
  class.mailfetch.php

  mail fetcher class. Uses IMAP ext for now.

  Peter Rotich <peter@osticket.com>
  Copyright (c)  2006-2010 osTicket (http://www.osticket.com)
  Further modifications (c) 2011 Wenqiang Wang (wenqiang@polestarsoft.com)

 * ******************************************************************** */
require_once dirname(dirname(__FILE__)) . '/html2text/html2text.php';

class miMailFetcher {

    private $hostname;
    private $username;
    private $password;
    private $port;
    private $protocol;
    private $encryption;
    private $mbox;
    private $charset = 'UTF-8';

    public function __construct($username, $password, $hostname, $port, $protocol, $encryption='') {
        if (!strcasecmp($protocol, 'pop')) //force pop3
            $protocol = 'pop3';

        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->protocol = strtolower($protocol);
        $this->port = $port;
        $this->encryption = $encryption;

        $this->serverstr = sprintf('{%s:%d/%s', $this->hostname, $this->port, strtolower($this->protocol));
        if (!strcasecmp($this->encryption, 'SSL')) {
            $this->serverstr.='/ssl';
        }
        $this->serverstr.='/novalidate-cert}INBOX'; //add other flags here as needed.
        // charset to convert the mail to.
        $this->charset = 'UTF-8';
        //Set timeouts 
        if (function_exists('imap_timeout')) {
            imap_timeout(1, 30); // open timeout
        }
    }

    public function connect() {
        return $this->open() ? true : false;
    }

    public function open() {
        if ($this->mbox && imap_ping($this->mbox))
            return $this->mbox;

        $this->mbox = @imap_open($this->serverstr, $this->username, $this->password, NIL, 1);
        return $this->mbox;
    }

    public function close() {
        imap_close($this->mbox, CL_EXPUNGE);
    }

    public function mailcount() {
        return count(imap_headers($this->mbox));
    }

    public function fetchTickets($max = 20, $deletemsgs = false) {
        $nummsgs = imap_num_msg($this->mbox);
        $msgs = $errors = 0;
        for ($i = $nummsgs; $i > 0; $i--) {
            //process messages in reverse. FILO.
            if ($this->createTicket($i)) {
                imap_setflag_full($this->mbox, imap_uid($this->mbox, $i), "\\Seen", ST_UID); //IMAP only??
                if ($deletemsgs)
                    imap_delete($this->mbox, $i);
                $msgs++;
                $errors = 0; // we are only interested in consecutive errors.
            } else {
                $errors++;
            }
            if (($max && $msgs >= $max) || $errors > 10) // hard coded
                break;
        }
        @imap_expunge($this->mbox);

        return $msgs;
    }

    public function getLastError() {
        return imap_last_error();
    }

    private static function decode($encoding, $text) {

        switch ($encoding) {
            case 1:
                $text = imap_8bit($text);
                break;
            case 2:
                $text = imap_binary($text);
                break;
            case 3:
                $text = imap_base64($text);
                break;
            case 4:
                $text = imap_qprint($text);
                break;
            case 5:
            default:
                $text = $text;
        }
        return $text;
    }

    //Convert text to desired encoding..defaults to utf8
    private static function mime_encode($text, $charset=null, $enc='utf-8') { //Thank in part to afterburner
        $encodings = array('UTF-8', 'WINDOWS-1251', 'ISO-8859-5', 'ISO-8859-1', 'KOI8-R');
        if (function_exists("iconv") and $text) {
            if ($charset)
                return iconv($charset, $enc . '//IGNORE', $text);
            elseif (function_exists("mb_detect_encoding"))
                return iconv(mb_detect_encoding($text, $encodings), $enc, $text);
        }

        return utf8_encode($text);
    }

    //Generic decoder - mirrors imap_utf8
    private static function mime_decode($text) {

        $a = imap_mime_header_decode($text);
        $str = '';
        foreach ($a as $k => $part)
            $str.= $part->text;

        return $str ? $str : imap_utf8($text);
    }

    private static function getMimeType($struct) {
        $mimeType = array('TEXT', 'MULTIPART', 'MESSAGE', 'APPLICATION', 'AUDIO', 'IMAGE', 'VIDEO', 'OTHER');
        if (!$struct || !$struct->subtype)
            return 'TEXT/PLAIN';

        return $mimeType[(int) $struct->type] . '/' . $struct->subtype;
    }

    private static function getIp($headers) {
        if (preg_match_all('/(?:^|\n)Received:.*from.*[^\d\.]((?:\d+\.){3}\d+)[^\d\.].*\n/', $headers, $matches)) {
            $m = end($matches);
            return $m[1];
        }
        return false;
    }

    private static function stripQuotes($message) {
        $final_message = '';
        foreach (split("\n", $message) as $num => $line) {
            if (preg_match('/^On[\s]/i', $line)) {
                $on_line = $num;
                $found_on = true;
            }

            if (strpos($line, $modx->getOption('modisv.ticket_reply_separator')) !== false) {
                $end_line = $num;
                break;
            }

            if ($found_on) {
                $message_on .= $line . "\n";
            } else {
                $final_message .= $line . "\n";
            }
        }

        if ((($end_line - $on_line) > 2) || !$end_line)
            $final_message .= $message_on;

        return trim($final_message);
    }

    private function getMailInfo($mid) {
        $headerinfo = imap_headerinfo($this->mbox, $mid);
        $sender = $headerinfo->from[0];

        //Parse what we need...
        $header = array(
            'from' => array('name' => @$sender->personal, 'email' => strtolower($sender->mailbox) . '@' . $sender->host),
            'subject' => @$headerinfo->subject,
            'mid' => $headerinfo->message_id);
        return $header;
    }

    private function getHeader($mid) {
        return imap_fetchheader($this->mbox, $mid, FT_PREFETCHTEXT);
    }

    private function getBody($mid) {
        $body = '';
        if (!($body = $this->getPart($mid, 'TEXT/PLAIN', $this->charset))) {
            if (($body = $this->getPart($mid, 'TEXT/HTML', $this->charset))) {
                $body = convert_html_to_text($body);
            }
        }
        return $body;
    }

    //search for specific mime type parts....encoding is the desired encoding.
    private function getPart($mid, $mimeType, $encoding=false, $struct=null, $partNumber=false) {

        if (!$struct && $mid)
            $struct = @imap_fetchstructure($this->mbox, $mid);

        //match the mime type.
        if ($struct && !$struct->ifdparameters && strcasecmp($mimeType, self::getMimeType($struct)) == 0) {
            $partNumber = $partNumber ? $partNumber : 1;
            if (($text = imap_fetchbody($this->mbox, $mid, $partNumber))) {
                if ($struct->encoding == 3 or $struct->encoding == 4) //base64 and qp decode.
                    $text = self::decode($struct->encoding, $text);

                $charset = null;
                if ($encoding) { //Convert text to desired mime encoding...
                    if ($struct->ifparameters) {
                        if (!strcasecmp($struct->parameters[0]->attribute, 'CHARSET') && strcasecmp($struct->parameters[0]->value, 'US-ASCII'))
                            $charset = trim($struct->parameters[0]->value);
                    }
                    $text = self::mime_encode($text, $charset, $encoding);
                }
                return $text;
            }
        }
        // do recursive search
        $text = '';
        if ($struct && $struct->parts) {
            while (list($i, $substruct) = each($struct->parts)) {
                if ($partNumber)
                    $prefix = $partNumber . '.';
                if (($result = $this->getPart($mid, $mimeType, $encoding, $substruct, $prefix . ($i + 1))))
                    $text.=$result;
            }
        }
        return $text;
    }

    private function getAttachments($mid, $part, $index, $maxSize, $maxCount) {
        $files = array();

        if ($maxCount <= 0)
            return $files;

        if ($part && $part->ifdparameters && $part->dparameters[0]->value) { //attachment
            $index = $index ? : 1;
            if ($part->bytes <= $maxSize) {
                $file = array();
                $file['content'] = self::decode($part->encoding, imap_fetchbody($this->mbox, $mid, $index));
                $file['name'] = $part->dparameters[0]->value;
                $file['size'] = $part->bytes;
                $files[] = $file;
            }
        }

        // recursive attachment search!
        if ($part && $part->parts) {
            foreach ($part->parts as $k => $struct) {
                if ($index)
                    $prefix = $index . '.';
                $files = array_merge($files, $this->getAttachments($mid, $struct, $prefix . ($k + 1), $maxSize - $part->bytes, $maxCount - 1));
            }
        }

        return $files;
    }

    private function createTicket($mid) {
        global $modx;

        // get mail header infos
        $info = $this->getMailInfo($mid);

        // make sure the email is NOT one of the undeleted emails.
        if ($info['mid'] && $modx->getObject('miMessage', array('message_id' => $info['mid'], 'author_email' => $info['from']['email']))) {
            return false;
        }

        $var = array();
        $var['author_name'] = self::mime_decode($info['from']['name']);
        $var['author_email'] = $info['from']['email'];
        $var['subject'] = $info['subject'] ? self::mime_decode($info['subject']) : '[no subject]';
        $var['body'] = $this->getBody($mid);
        $var['message_id'] = $info['mid'];
        $var['headers'] = $this->getHeader($mid);
        $var['source'] = 'email';
        $var['ip'] = self::getIp($var['headers']);

        // get attachments
        if (($struct = imap_fetchstructure($this->mbox, $mid)) && $struct->parts) {
            $maxSize = $modx->getOption('modisv.upload_max_size', null, 4194304);
            $maxCount = $modx->getOption('modisv.upload_max_files', null, 10);
            $var['files'] = $this->getAttachments($mid, $struct, 0, $maxSize, $maxCount);
        }

        // check the subject line for possible ID.
        $ticket = null;
        if (preg_match("[#([0-9]{1,10})]", $var['subject'], $matches)) {
            $id = $matches[1];
            $ticket = $modx->getObject('miTicket', $id);
            if (!$ticket || !$ticket->isAuthorWatcherOrStaff($var['author_email']))
                $ticket = null;
        }

        if (!$ticket) {
            // new ticket
            $ticket = $modx->newObject('miTicket');
            if (!$ticket->createNew($var)) {
                return false;
            }
        } else {
            // ticket reply
            $var['body'] = self::stripQuotes($var['body']);
            if (!$ticket->reply($var)) {
                return false;
            }
        }

        return $ticket;
    }

}
