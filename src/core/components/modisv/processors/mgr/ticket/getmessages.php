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
 * Gets a list of messages of a specified ticket.
 *
 * @package modisv
 * @subpackage processors
 */
$ticket = $modx->getObject('miTicket', $scriptProperties['ticket']);
if ($ticket == null)
    return $modx->error->failure('Ticket not specified or not exists.');

// get messages
$c = $modx->newQuery('miMessage');
$c->where(array('ticket' => $ticket->get('id')));
$c->sortby('id');
$messages = $modx->getCollection('miMessage', $c);
$list = array();
foreach ($messages as $message) {
    $item = $message->toArray();
    $item['html'] = $message->getHtmlBody();
    
    // get attachments
    $item['attachments'] = array();
    foreach($message->getMany('Attachments') as $att) {
        $item['attachments'][] = array('id' => $att->get('id'), 'name' => $att->getFileName(), 'size' => $att->get('size'), 'url' => $att->getUrl());
    }
    $list[] = $item;
}

$result = array();
$result['messages'] = $list;

// get the ticket
$result['ticket'] = $ticket->toArray();
$user = $modx->getObject('modUser', array('username' => $ticket->get('author_email')));
if ($user) {
    $result['ticket']['author_id'] = $user->get('id');
}
if ($ticket->get('product') && $ticket->getOne('Product')) {
    $result['ticket']['product_name'] = $ticket->getOne('Product')->get('name');
}

return $modx->error->success('', $result);