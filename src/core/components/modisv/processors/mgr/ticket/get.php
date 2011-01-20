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
 * Gets the ticket and a list of messages.
 *
 * @package modisv
 * @subpackage processors
 */
$ticket = $modx->getObject('miTicket', $scriptProperties['ticket']);
if ($ticket == null)
    return $modx->error->failure('Ticket not specified or not exists.');

// get messages
$list = array();
foreach ($ticket->getMessages() as $message) {
    $item = $message->toArraySanitized();
    // get attachments
    $item['attachments'] = array();
    foreach($message->getMany('Attachments') as $att) {
        $item['attachments'][] = $att->toArray();
    }
    $list[] = $item;
}

$result = array();
$result['messages'] = $list;

// get the ticket
$result['ticket'] = $ticket->toArraySanitized();
$user = $modx->getObject('modUser', array('username' => $ticket->get('author_email')));
if ($user) {
    $result['ticket']['author_id'] = $user->get('id');
}
if ($ticket->get('product') && $ticket->getOne('Product')) {
    $result['ticket']['product_name'] = $ticket->getOne('Product')->get('name');
}

return $modx->error->success('', $result);