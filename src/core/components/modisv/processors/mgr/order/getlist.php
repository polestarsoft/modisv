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
 * Gets a list of orders.
 *
 * @package modisv
 * @subpackage processors
 */
$isLimit = !empty($scriptProperties['limit']);
$start = isset($scriptProperties['start']) ? $scriptProperties['start'] : 0;
$limit = isset($scriptProperties['limit']) ? $scriptProperties['limit'] : 20;

$c = $modx->newQuery('miOrder');
$count = $modx->getCount('miOrder', $c);
if ($isLimit)
    $c->limit($limit, $start);

// search
if (!empty($scriptProperties['user'])) {
    $c->innerJoin('modUser', 'User');
    $c->where(array('User.username:LIKE' => '%' . trim($scriptProperties['user']) . '%'));
}
if (!empty($scriptProperties['guid']))
    $c->andCondition(array('guid:LIKE' => '%' . trim($scriptProperties['guid']) . '%'));
if (!empty($scriptProperties['refno']))
    $c->andCondition(array('reference_number:LIKE' => '%' . trim($scriptProperties['refno']) . '%'));
if (!empty($scriptProperties['dateFrom']))
    $c->andCondition(array('updatedon:>=' => trim($scriptProperties['dateFrom'])));
if (!empty($scriptProperties['dateTo']))
    $c->andCondition(array('updatedon:<=' => trim($scriptProperties['dateTo'])));
if (!empty($scriptProperties['status']))
    $c->andCondition(array('status' => trim($scriptProperties['status'])));
if (!empty($scriptProperties['processor']))
    $c->andCondition(array('payment_processor' => trim($scriptProperties['processor'])));

$c->sortby('updatedon', 'DESC');
$orders = $modx->getCollection('miOrder', $c);

$list = array();
foreach ($orders as $order) {
    $item = $order->toArray();
    $item['total'] = $order->getTotal();
    $item['user_email'] = $order->getOne('User') ? $order->getOne('User')->get('username') : '';

    $item['menu'] = array();
    $item['menu'][] = array(
        'text' => 'Update Order',
        'handler' => 'this.updateOrder',
    );
    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'Remove Order',
        'handler' => 'this.removeOrder',
    );
    if ($order->get('status') == 'pending') {
        $item['menu'][] = '-';
        $item['menu'][] = array(
            'text' => 'Fulfill Order',
            'handler' => 'this.fulfillOrder',
        );
    }

    $list[] = $item;
}
return $this->outputArray($list, $count);