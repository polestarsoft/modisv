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

$staffs = array_filter(array_map('trim', explode(',', $modx->getOption('modisv.ticket_staffs'))));
if (!in_array($modx->user->get('username'), $staffs)) {
    return $modx->error->failure('You are not a support staff. Please use `modisv.ticket_staffs` settings to specify support staffs.');
}

// check input
if (empty($scriptProperties['body'])) {
    $modx->error->addField('body', 'Please enter the message.');
    return $modx->error->failure('');
}

if (strlen($scriptProperties['body']) < 20) {
    $modx->error->addField('body', 'Message too short.');
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

return $modx->error->success('');
