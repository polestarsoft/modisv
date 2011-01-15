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
            $this->set('lastmessageon', time());
            miUtilities::setGuid($this);
        }

        return parent::save($cacheFlag);
    }

    public function reply($properties) {
        global $modx;

        // check status
        if ($this->get('status') != 'open')
            return false;

        // create message
        $message = $modx->newObject('miMessage');
        $message->fromArray($properties);
        $message->set('ticket', $this->get('id'));
        $message->set('staff_response', true);
        $message->set('author_name', $modx->user->getOne('Profile')->get('fullname'));
        $message->set('author_email', $modx->user->get('username'));
        $message->set('source', 'web');
        $message->set('ip', $_SERVER['REMOTE_ADDR']);
        $message->set('ticket', $this->get('id'));

        // save the reply message
        if (!$message->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to save the reply message: ' . print_r($message->toArray(), true));
            return false;
        }

        // save the ticket
        $this->set('lastresponseon', time());
        $this->set('answered', true);
        if (!$this->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to save the ticket: ' . print_r($this->toArray(), true));
            return false;
        }

        // get view ticket url
        $xhtmlUrlSetting = $modx->config['xhtml_urls'];
        $modx->config['xhtml_urls'] = false;            // disable xhtml_urls temporarily
        $url = $modx->makeUrl($modx->context->getOption('modisv.view_ticket_page'), '', array('guid' => strtolower($this->get('guid')), 'email' => $this->get('author_email')), 'full');
        $url = str_replace('%40', '@', $url);
        $modx->config['xhtml_urls'] = $xhtmlUrlSetting; // restore xhtml_urls

        // send notification to watchers
        $phs = $this->toArray('ticket.');
        $phs = array_merge($phs, $message->toArray('message.'));
        $phs['ticket.url'] = $url;
        $phs['message.attchements'] = '';
        foreach ($message->getMany('Attachments') as $att) {
            $phs['message.attchements'] .= sprintf('- %s %s\n', $att->getFileName(), $att->getUrl());
        }
        $sent = $modx->modisv->sendEmail(
                $this->get('watchers'),
                sprintf('RE: %s [#%s]', $this->get('subject'), strtoupper($this->get('guid'))),
                $modx->modisv->getChunk('miTicketReply', $phs),
                $modx->context->getOption('modisv.support_email')
        );
        if(!$sent) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to send ticket reply email to user: ' . print_r($this->toArray(), true));
            return false;
        }
        return true;
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

}