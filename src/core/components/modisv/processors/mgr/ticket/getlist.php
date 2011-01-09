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
    $c->where(array(
        'subject:LIKE' => '%' . trim($scriptProperties['text']) . '%',
        'OR:body:LIKE' => '%' . trim($scriptProperties['text']) . '%',
        'OR:note:LIKE' => '%' . trim($scriptProperties['text']) . '%'
    ));
}
if (!empty($scriptProperties['priority']))
    $c->andCondition(array('priority:>=' => trim($scriptProperties['priority'])));
$dateType = $scriptProperties['dateType'] ? : 'lastmessageon';
if (!empty($scriptProperties['dateFrom'])) {
    $c->andCondition(array("$dateType:>=" => trim($scriptProperties['dateFrom'])));
}
if (!empty($scriptProperties['dateTo'])) {
    $c->andCondition(array("$dateType:<=" => trim($scriptProperties['dateTo'])));
}

$c->sortby($dateType, "DESC");
$tickets = $modx->getCollection('miTicket', $c);

$list = array();
foreach ($tickets as $ticket) {
    $item = $ticket->toArray();
    $item['releases'] = implode(',', array_keys($ticket->getReleases()));

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

    $list[] = $item;
}
return $this->outputArray($list, $count);