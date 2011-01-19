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
 * A utility class for ticket user authentication.
 *
 * @package modisv
 */
class miTicketAuth {

    public $anonToken;
    public $ticket;
    public $email;
    public $name;

    public function __construct() {
        global $modx;

        // get anonymous token
        $this->anonToken = $_REQUEST['anon_token'] ? : $_SESSION['modisv.ticket_auth_token'];

        // get ticket
        $this->ticket = $_REQUEST['guid'] ? $modx->getObject('miTicket', array('guid' => $_REQUEST['guid'])) : null;

        // get email
        if ($modx->user && $modx->user->isAuthenticated($modx->context->get('key'))) { // try to get modx username
            $this->email = $modx->user->get('username');
        } else if ($this->anonToken && $this->ticket) { // try to get email by comparing anon_token and email hashes
            $emails = array_filter(array_map('trim', explode(',', $this->ticket->get('watchers'))));
            $emails[] = $this->ticket->get('author_email');
            foreach ($emails as $e) {
                if (self::validateAnonToken($e, $this->anonToken)) {
                    $this->email = $e;
                    break;
                }
            }
        }

        // get name
        if ($modx->user && $modx->user->isAuthenticated($modx->context->get('key')) && $modx->user->getOne('Profile')) { // then try to get fullname from modx user profile
            return $modx->user->getOne('Profile')->get('fullname');
        } else if ($this->email && $this->ticket && $this->email == $this->ticket->get('author_email')) {    // try get author_name if current user is the ticket author
            $this->name = $this->ticket->get('author_name');
        }
    }

    public function canRead() {
        global $modx;

        if ($this->email && $this->ticket) {
            if ($this->email === $this->ticket->get('author_email'))    // author
                return true;

            $watchers = array_filter(array_map('trim', explode(',', $this->ticket->get('watchers'))));
            if (in_array($this->email, $watchers)) // watcher
                return true;
        }

        return false;
    }

    public function canWrite() {
        // currently ticket author and all watchers can read & write
        return $this->canRead();
    }

    public function storeAnonToken($email) {
        if (!$email && !$this->email)
            return false;
        $_SESSION['modisv.ticket_auth_token'] = self::generateAnonToken($email ? : $this->email);
    }

    public static function generateAnonToken($email) {
        global $modx;
        $salt = $modx->getOption('modisv.ticket_auth_salt');
        return substr(md5($email . $salt), 0, 8);
    }

    public static function validateAnonToken($email, $anonToken) {
        return self::generateAnonToken($email) === $anonToken;
    }

}

?>
