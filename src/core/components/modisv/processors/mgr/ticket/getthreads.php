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
 * Gets a list of messages/responses of a specified ticket.
 *
 * @package modisv
 * @subpackage processors
 */
$ticket = $modx->getObject('miTicket', $scriptProperties['ticket']);
if ($ticket == null)
    return $modx->error->failure('Ticket not specified or not exists.');

$messages = $ticket->getMany('Messages');
$responses = $ticket->getMany('Responses');

$threads = array();
foreach ($messages as $message) {
    $item = $message->toArray();
    $item['response'] = false;
    $item['id'] = 'm' . $item['id'];
    $item['author_name'] = $ticket->get('author_name') ? : '';
    $item['author_email'] = $ticket->get('author_email');
    $threads[] = $item;

    foreach ($responses as $response) {
        if ($response->get('message') == $message->get('id')) {
            $item = $response->toArray();
            $item['id'] = 'r' . $item['id'];
            $item['response'] = true;
            $item['name'] = 'r' . $response->get('id');
            $item['author_name'] = 'Support Staff';
            $threads[] = $item;
        }
    }
}

$list = array();
$list['ticket'] = $ticket->toArray();
$list['threads'] = $threads;
return $modx->error->success('', $list);