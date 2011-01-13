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
 * Creates a ticket.
 *
 * @package modisv
 * @subpackage processors
 */

// create ticket
$ticket = $modx->newObject('miTicket');
$ticket->fromArray($scriptProperties);
$ticket->set('status', 'open');
$ticket->set('author_name', $modx->user->getOne('Profile')->get('fullname'));
$ticket->set('author_email', $modx->user->get('username'));
$ticket->set('source', 'web');
$ticket->set('ip', $_SERVER['REMOTE_ADDR']);

if (!$ticket->save()) {
    $modx->error->checkValidation(array($ticket));
    return $modx->error->failure('An error occurred while trying to save the ticket.');
}

// create message
$message = $modx->newObject('miMessage');
$message->set('body', $scriptProperties['body']);
$message->set('staff_response', true);
$message->set('author_name', $modx->user->getOne('Profile')->get('fullname'));
$message->set('author_email', $modx->user->get('username'));
$message->set('source', 'web');
$message->set('ip', $_SERVER['REMOTE_ADDR']);
$message->set('ticket', $ticket->get('id'));

// save the message
if (!$message->save()) {
    return $modx->error->failure('An error occurred while trying to save the new message.');
}

return $modx->error->success('', $ticket);
