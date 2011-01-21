<?php

/**
 * modISV
 *
 * Copyright 2010 by Weqiang Wang <wenqiang@polestarsoft.com>
 *
 * modISV is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * modISV is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * modISV; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package modisv
 */

/**
 * Represents a ticket.
 *
 * @package modisv
 */
class miTicket extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function save($cacheFlag = null) {
        $this->set('updatedon', time());
        if ($this->isNew()) {
            $this->set('createdon', time());
        }

        return parent::save($cacheFlag);
    }

    public function close() {
        if ($this->get('status') == 'closed') {
            return false;
        }
        $this->set('status', 'closed');
        $this->set('closedon', time());
        return $this->save();
    }

    public function reopen() {
        if ($this->get('status') == 'open') {
            return false;
        }
        $this->set('status', 'open');
        $this->set('reopenedon', time());
        return $this->save();
    }

    public function addWatcher($email) {
        $watchers = $this->get('watchers');
        if (!empty($watchers))
            $watchers .= ',';
        $watchers .= $email;
        $this->set('watchers', $watchers);
        return $this->save();
    }

    public function getUrl() {
        global $modx;
        $xhtmlUrlSetting = $modx->config['xhtml_urls'];
        $modx->config['xhtml_urls'] = false;            // disable xhtml_urls temporarily
        $url = $modx->makeUrl($modx->getOption('modisv.view_ticket_page'), '', array('id' => $this->get('id')), 'full');
        $modx->config['xhtml_urls'] = $xhtmlUrlSetting; // restore xhtml_urls
        return $url;
    }

    public function getMessages() {
        global $modx;
        $c = $modx->newQuery('miMessage');
        $c->where(array('ticket' => $this->get('id')));
        $c->sortby('id');
        return $modx->getCollection('miMessage', $c);
    }

    public function isAuthorWatcherOrStaff($email) {
        global $modx;
        
        if ($email === $this->get('author_email'))    // author
            return true;

        $watchers = array_filter(array_map('trim', explode(',', $this->get('watchers'))));
        if (in_array($email, $watchers)) // watcher
            return true;

        $staffs = array_filter(array_map('trim', explode(',', $modx->getOption('modisv.ticket_staffs'))));
        if (in_array($email, $staffs)) // staff
            return true;

        return false;
    }

    public function toArray($keyPrefix= '', $rawValues= false, $excludeLazy= false) {
        $result = parent::toArray($keyPrefix, $rawValues, $excludeLazy);

        // extra fields
        $result[$keyPrefix . 'url'] = $this->getUrl();

        return $result;
    }

    public function toArraySanitized($keyPrefix= '', $rawValues= false, $excludeLazy= false) {
        $result = $this->toArray($keyPrefix, $rawValues, $excludeLazy);

        $result[$keyPrefix . 'author_name'] = htmlspecialchars($result[$keyPrefix . 'author_name']);
        $result[$keyPrefix . 'author_email'] = htmlspecialchars($result[$keyPrefix . 'author_email']);
        $result[$keyPrefix . 'subject'] = htmlspecialchars($result[$keyPrefix . 'subject']);

        return $result;
    }

    public function createNew($properties) {
        global $modx;

        // check input
        if (empty($properties['body']))
            return false;
        if (!preg_match("/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", $properties['author_email']))
            return false;
        if (count($properties['files']) > $modx->getOption('modisv.upload_max_files', null, 10))
            return false;
        else if (array_reduce($properties['files'], create_function('$s,$f', 'return $s + $f["size"];')) > $modx->getOption('modisv.upload_max_size', null, 4194304))
            return false;

        // preprocess input
        if (empty($properties['subject']))
            $properties['subject'] = '[no subject]';

        // get staffs
        $staffs = array_filter(array_map('trim', explode(',', $modx->getOption('modisv.ticket_staffs'))));

        // create the ticket
        $this->fromArray($properties);
        if (!$this->get('watchers'))    // add the author as watcher in default
            $this->set('watchers', $this->get('author_email'));
        $this->set('lastmessageon', time());
        if (!$this->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to save the ticket: " . print_r($this->toArray(), true));
            return false;
        }

        // create the first message
        $message = $modx->newObject('miMessage');
        $message->fromArray($properties);
        $message->set('ticket', $this->get('id'));
        if (!$message->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to save the message:" . print_r($message->toArray(), true));
            return false;
        }

        // create attachments
        foreach ($properties['files'] as $file) {
            if ($file['error'] != 0 || empty($file['name']))
                continue;

            // create attachment
            $attachment = $modx->newObject('miAttachment');
            if (!$attachment->createNew($file, $message)) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to create the attachment '{$file['name']}'.");
                return false;
            }
            if (!$attachment->save()) {
                @unlink(MODX_BASE_PATH . $attachment->get('path'));  // delete file
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to save the attachment '{$file['name']}'.");
                return false;
            }
        }

        // send notification to staffs
        $phs = $this->toArray('ticket.');
        $phs = array_merge($phs, $message->toArray('message.'));
        foreach ($staffs as $staff) {
            $phs['ticket.url'] = $this->getUrl() . "&anon_token=" . miTicketSession::generateAnonToken($staff);
            $phs['ticket.backend_url'] = miUtilities::getManagerUrl('modisv', 'index', "&sa=ticket&id={$this->get('id')}");
            $phs['message.attachments'] = '';
            foreach ($message->getMany('Attachments') as $att) {
                $phs['message.attachments'] .= sprintf("- %s %s\n", $att->getFileName(), $att->getUrl() . "&anon_token=" . miTicketSession::generateAnonToken($staff));
            }
            if (!miUtilities::sendEmail(
                            $staff,
                            sprintf('%s [#%s]', $this->get('subject'), $this->get('id')),
                            $modx->modisv->getChunk('miNewTicketNotification', $phs))) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to send new ticket notification to staffs [#{$this->get('id')}].");
                return false;
            }
        }

        // send auto response
        $phs['ticket.url'] = $this->getUrl() . "&anon_token=" . miTicketSession::generateAnonToken($this->get('author_email'));
        if (!miUtilities::sendEmail(
                        $this->get('author_email'),
                        sprintf('%s - New Ticket Created [#%s]', $modx->getOption('site_name'), $this->get('id')),
                        $modx->modisv->getChunk('miTicketAutoresponse', $phs),
                        $modx->getOption('modisv.support_email'))) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to send ticket auto response to user [#{$this->get('id')}].");
            return false;
        }

        return true;
    }

    public function reply($properties) {
        global $modx;

        // check status
        if ($this->get('status') != 'open')
            return false;

        // check input
        if (empty($properties['body']))
            return false;
        if (!preg_match("/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", $properties['author_email']))
            return false;
        if (count($properties['files']) > $modx->getOption('modisv.upload_max_files', null, 10))
            return false;
        else if (array_reduce($properties['files'], create_function('$s,$f', 'return $s + $f["size"];')) > $modx->getOption('modisv.upload_max_size', null, 4194304))
            return false;

        // get staffs & watchers
        $staffs = array_filter(array_map('trim', explode(',', $modx->getOption('modisv.ticket_staffs'))));
        $watchers = array_filter(array_map('trim', explode(',', $this->get('watchers'))));

        // create message
        $message = $modx->newObject('miMessage');
        $message->fromArray($properties);
        $message->set('staff_response', in_array($message->get('author_email'), $staffs));
        $message->set('ticket', $this->get('id'));
        if (!$message->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to save the reply message:" . print_r($message->toArray(), true));
            return false;
        }

        // create attachments
        foreach ($properties['files'] as $file) {
            if ($file['error'] != 0 || empty($file['name']))
                continue;

            // create attachment
            $attachment = $modx->newObject('miAttachment');
            if (!$attachment->createNew($file, $message)) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to create the attachment '{$file['name']}'.");
                return false;
            }
            if (!$attachment->save()) {
                @unlink(MODX_BASE_PATH . $attachment->get('path'));  // delete file
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to save the attachment '{$file['name']}'.");
                return false;
            }
        }

        // save the ticket
        if ($message->get('staff_response')) {
            $this->set('answered', true);
            $this->set('lastresponseon', time());
        } else {
            $this->set('lastmessageon', time());
        }
        if (!$this->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to save the ticket #{$this->get('id')}.");
            return false;
        }

        // send notification to staffs
        $phs = $this->toArray('ticket.');
        $phs = array_merge($phs, $message->toArray('message.'));
        foreach ($staffs as $staff) {
            if ($staff === $message->get('author_email'))
                continue;

            $phs['ticket.url'] = $this->getUrl() . "&anon_token=" . miTicketSession::generateAnonToken($staff);
            $phs['ticket.backend_url'] = miUtilities::getManagerUrl('modisv', 'index', "&sa=ticket&id={$this->get('id')}");
            $phs['message.attachments'] = '';
            foreach ($message->getMany('Attachments') as $att) {
                $phs['message.attachments'] .= sprintf("- %s %s\n", $att->getFileName(), $att->getUrl() . "&anon_token=" . miTicketSession::generateAnonToken($staff));
            }
            if (!miUtilities::sendEmail(
                            $staff,
                            sprintf('RE: %s [#%s]', $this->get('subject'), $this->get('id')),
                            $modx->modisv->getChunk('miNewMessageNotification', $phs))) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to send new message notification to staffs [#{$this->get('id')}].");
                return false;
            }
        }

        // send notification to watchers
        foreach ($watchers as $watcher) {
            if ($watcher === $message->get('author_email'))
                continue;

            $phs['ticket.url'] = $this->getUrl() . "&anon_token=" . miTicketSession::generateAnonToken($watcher);
            $phs['message.attachments'] = '';
            foreach ($message->getMany('Attachments') as $att) {
                $phs['message.attachments'] .= sprintf("- %s %s\n", $att->getFileName(), $att->getUrl() . "&anon_token=" . miTicketSession::generateAnonToken($watcher));
            }
            if (!miUtilities::sendEmail(
                            $watcher,
                            sprintf('RE: %s [#%s]', $this->get('subject'), $this->get('id')),
                            $modx->modisv->getChunk('miTicketReply', $phs),
                            $modx->getOption('modisv.support_email'))) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occurred while trying to send new message notification to watcher {$watcher} [#{$this->get('id')}].");
                return false;
            }
        }

        return true;
    }

}