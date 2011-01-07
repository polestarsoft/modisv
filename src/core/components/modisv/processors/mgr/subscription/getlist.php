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
 * Gets a list of subscriptions.
 *
 * @package modisv
 * @subpackage processors
 */
$isLimit = !empty($scriptProperties['limit']);
$start = isset($scriptProperties['start']) ? $scriptProperties['start'] : 0;
$limit = isset($scriptProperties['limit']) ? $scriptProperties['limit'] : 20;

if (empty($scriptProperties['release']))
    return $modx->error->failure('Release not specified.');

$c = $modx->newQuery('miSubscription');
$c->where(array('release' => $scriptProperties['release']));
$count = $modx->getCount('miSubscription', $c);
if ($isLimit)
    $c->limit($limit, $start);
$c->sortby('name');
$subscriptions = $modx->getCollection('miSubscription', $c);

$list = array();
foreach ($subscriptions as $subscription) {
    $item = $subscription->toArray();

    $item['menu'] = array();
    $item['menu'][] = array(
        'text' => 'Update Subscription',
        'handler' => 'this.updateSubscription',
    );
    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'Remove Subscription',
        'handler' => 'this.removeSubscription',
    );
    $list[] = $item;
}
return $this->outputArray($list, $count);
