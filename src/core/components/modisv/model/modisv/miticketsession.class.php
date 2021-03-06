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
class miTicketSession {

    public $email;
    public $name;

    public function __construct() {
        global $modx;

        // get email
        if ($modx->user && $modx->user->isAuthenticated($modx->context->get('key'))) {
            // try to get modx username
            $this->email = $modx->user->get('username');
        } else if (!empty($_SESSION['modisv.ticket_session_email'])) {
            // try to get email from session
            $this->email = $_SESSION['modisv.ticket_session_email'];
        } else if (!empty($_REQUEST['id']) && !empty($_REQUEST['anon_token'])) {
            // try to get email by comparing anon_token and email hashes
            $ticket = $modx->getObject('miTicket', $_REQUEST['id']);
            if ($ticket) {
                $emails = array_filter(array_map('trim', explode(',', $ticket->get('watchers'))));  // watchers
                $emails[] = $ticket->get('author_email'); // author
                $emails = array_merge($emails, array_filter(array_map('trim', explode(',', $modx->getOption('modisv.ticket_staffs'))))); // staffs
                foreach ($emails as $e) {
                    if (self::validateAnonToken($e, $_REQUEST['anon_token'])) {
                        $this->email = $e;
                        break;
                    }
                }
            }
        }

        // get name
        if ($modx->user && $modx->user->isAuthenticated($modx->context->get('key')) && $modx->user->getOne('Profile')) {
            // then try to get fullname from modx user profile
            return $modx->user->getOne('Profile')->get('fullname');
        } else if (!empty($_SESSION['modisv.ticket_session_name'])) {
            // try to get name from session
            $this->name = $_SESSION['modisv.ticket_session_name'];
        } else if ($this->email) {
            // try get author_name if current user is the ticket author
            $ticket = $modx->getObject('miTicket', $_REQUEST['id']);
            if ($ticket && $this->email == $ticket->get('author_email'))
                $this->name = $ticket->get('author_name');
        }

        // store user info in session variables
        $this->storeUserInfo($this->name, $this->email);
    }

    public function canRead($ticket = null) {
        global $modx;

        if (!$ticket)
            $ticket = $modx->getObject('miTicket', $_REQUEST['id']);

        if ($this->email && $ticket && $ticket->isAuthorWatcherOrStaff($this->email)) {
            return true;
        }

        return false;
    }

    public function canWrite($ticket = null) {
        // for now, ticket author, watchers and all staffs can perform both read & write operation
        return $this->canRead($ticket);
    }

    public function storeUserInfo($name, $email) {
        $_SESSION['modisv.ticket_session_email'] = $email ? : '';
        $_SESSION['modisv.ticket_session_name'] = $name ? : '';
    }

    public static function generateAnonToken($email) {
        global $modx;
        $salt = $modx->getOption('modisv.ticket_auth_salt');
        return substr(md5($email . $salt), 0, 8);
    }

    public static function validateAnonToken($email, $anonToken) {
        return strcasecmp(self::generateAnonToken($email), trim($anonToken)) === 0;
    }

}

?>
