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
 * Reply a ticket.
 *
 * @package modisv
 * @subpackage processors
 */
$ticket = $modx->getObject('miTicket', $scriptProperties['id']);
if ($ticket == null) {
    return $modx->error->failure('Ticket not specified or not exists.');
}

// check status
if ($ticket->get('status') != 'open') {
    return $modx->error->failure('Ticket already closed.');
}

// check input
if (empty($scriptProperties['body'])) {
    $modx->error->addField('body', 'Please enter the message.');
    return $modx->error->failure('');
}

// admin is not allowed to reply
if (!preg_match("/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/", $modx->user->get('username'))) {
    return $modx->error->failure('Current user\'s username must be a valid email address to reply tickets.');
}

// reply
$properties = array();
$properties['body'] = $scriptProperties['body'];
$properties['author_name'] = $modx->user->getOne('Profile')->get('fullname');
$properties['author_email'] = $modx->user->get('username');
$properties['staff_response'] = true;
$properties['source'] = 'web';
$properties['ip'] = $_SERVER['REMOTE_ADDR'];
$properties['files'] = $_FILES;
if (!$ticket->reply($properties)) {
    return $modx->error->failure('An error occurred while trying to reply the ticket.');
}

return $modx->error->success('', $message);
