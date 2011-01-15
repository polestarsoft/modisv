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
        // check status
        if ($this->get('status') != 'open')
            return false;

        // create message
        $message = $this->xpdo->newObject('miMessage');
        $message->fromArray($properties);
        $message->set('ticket', $this->get('id'));

        // save the reply message
        if (!$message->save()) {
            $this->xpdo->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to save the reply message: ' . print_r($message->toArray(), true));
            return false;
        }

        // save the ticket
        $this->set('lastresponseon', time());
        $this->set('answered', true);
        if (!$this->save()) {
            $this->xpdo->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to save the ticket: ' . print_r($this->toArray(), true));
            return false;
        }

        // TODO: send notification to watchers
        
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