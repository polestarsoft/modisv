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
 * Gets a ticket.
 *
 * @package modisv
 * @subpackage processors
 */
$isLimit = !empty($scriptProperties['limit']);
$start = isset($scriptProperties['start']) ? $scriptProperties['start'] : 0;
$limit = isset($scriptProperties['limit']) ? $scriptProperties['limit'] : 20;

// search
$c = $modx->newQuery('miTicket');
$count = $modx->getCount('miTicket', $c);
if ($isLimit)
    $c->limit($limit, $start);

$c->where(array('target_version', $scriptProperties['name']));
$c->sortby('status', 'DESC');
$c->sortby('priority', 'DESC');
$tickets = $modx->getCollection('miTicket', $c);

$list = array();
foreach ($tickets as $ticket) {
    $item = $ticket->toArray();

    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'View Ticket',
        'handler' => 'this.viewTicket',
    );

    $list[] = $item;
}
return $this->outputArray($list, $count);









$ticket = $modx->getObject('miTicket', $scriptProperties['name']);
if ($ticket == null)
    return $modx->error->failure('Ticket not specified or not exists.');

$list = $ticket->toArray();
return $modx->error->success('', $list);