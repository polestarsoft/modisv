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
 * Gets a list of tickets.
 *
 * @package modisv
 * @subpackage processors
 */
$isLimit = !empty($scriptProperties['limit']);
$start = isset($scriptProperties['start']) ? $scriptProperties['start'] : 0;
$limit = isset($scriptProperties['limit']) ? $scriptProperties['limit'] : 20;

$c = $modx->newQuery('miTicket');
$count = $modx->getCount('miTicket', $c);
if ($isLimit)
    $c->limit($limit, $start);

// search
if (!empty($scriptProperties['user'])) {
    $c->where(array(
        'author_name:LIKE' => '%' . trim($scriptProperties['user']) . '%',
        'OR:author_email:LIKE' => '%' . trim($scriptProperties['user']) . '%',
        'OR:watchers:LIKE' => '%' . trim($scriptProperties['user']) . '%'
    ));
}
if (!empty($scriptProperties['topic']))
    $c->andCondition(array('topic' => trim($scriptProperties['topic'])));
if (!empty($scriptProperties['status']))
    $c->andCondition(array('status' => trim($scriptProperties['status'])));
if (!empty($scriptProperties['product']))
    $c->andCondition(array('product' => trim($scriptProperties['product'])));
if (!empty($scriptProperties['text'])) {
    $c->leftJoin('miMessage', 'miMessage', 'miMessage.ticket = miTicket.id');
    $c->leftJoin('miResponse', 'miResponse', 'miResponse.ticket = miTicket.id');
    $c->where(array(
        'subject:LIKE' => '%' . trim($scriptProperties['text']) . '%',
        'OR:note:LIKE' => '%' . trim($scriptProperties['text']) . '%',
        'OR:miMessage.body:LIKE' => '%' . trim($scriptProperties['text']) . '%',
        'OR:miResponse.body:LIKE' => '%' . trim($scriptProperties['text']) . '%',
    ));
}
if (!empty($scriptProperties['priority']))
    $c->andCondition(array('priority:>=' => trim($scriptProperties['priority'])));
$dateType = $scriptProperties['dateType'] ? : 'createdon';
if (!empty($scriptProperties['dateFrom']))
    $c->andCondition(array("$dateType:>=" => trim($scriptProperties['dateFrom'])));
if (!empty($scriptProperties['dateTo']))
    $c->andCondition(array("$dateType:<=" => trim($scriptProperties['dateTo'])));
if (!empty($scriptProperties['target_version']))    // used when get tickets list in a milestone
    $c->andCondition(array('target_version' => trim($scriptProperties['target_version'])));

$c->sortby('status');
$c->sortby('priority', 'DESC');
$c->sortby('miTicket.' . $dateType);
$tickets = $modx->getCollection('miTicket', $c);

$list = array();
foreach ($tickets as $ticket) {
    $item = $ticket->toArray();

    // check if the author is our user
    $user = $modx->getObject('modUser', array('username' => $ticket->get('author_email')));
    if($user) {
        $item['author_id'] = $user->get('id');
    }
    if($ticket->get('product') && $ticket->getOne('Product')) {
        $item['product_name'] = $ticket->getOne('Product')->get('name');
    }

    $item['menu'] = array();
    $item['menu'][] = array(
        'text' => 'Update Ticket',
        'handler' => 'this.updateTicket',
    );
    
    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'Remove Ticket',
        'handler' => 'this.removeTicket',
    );

    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'View Ticket',
        'handler' => 'this.viewTicket',
    );
    $item['menu'][] = array(
        'text' => 'View Ticket in Frontend',
        'handler' => 'this.viewTicketInFrontEnd',
    );

    $list[] = $item;
}
return $this->outputArray($list, $count);