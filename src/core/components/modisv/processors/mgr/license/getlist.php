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
 * Gets a list of licenses.
 *
 * @package modisv
 * @subpackage processors
 */
$isLimit = !empty($scriptProperties['limit']);
$start = isset($scriptProperties['start']) ? $scriptProperties['start'] : 0;
$limit = isset($scriptProperties['limit']) ? $scriptProperties['limit'] : 20;

// search
$c = $modx->newQuery('miLicense');
if (!empty($scriptProperties['user'])) {
    $c->innerJoin('modUser', 'User');
    $c->where(array('User.username:LIKE' => '%' . trim($scriptProperties['user']) . '%'));
}
if (!empty($scriptProperties['dateFrom']))
    $c->andCondition(array('createdon:>=' => trim($scriptProperties['dateFrom'])));
if (!empty($scriptProperties['dateTo']))
    $c->andCondition(array('createdon:<=' => trim($scriptProperties['dateTo'])));
if (!empty($scriptProperties['edition']))
    $c->andCondition(array('edition' => trim($scriptProperties['edition'])));

$count = $modx->getCount('miLicense', $c);
if ($isLimit)
    $c->limit($limit, $start);

$c->sortby('createdon', 'DESC');
$licenses = $modx->getCollection('miLicense', $c);

$list = array();
foreach ($licenses as $license) {
    $item = $license->toArray();
    $item['user_email'] = $license->getOne('User')->get('username');
    $item['edition_name'] = $license->getOne('Edition') ? $license->getOne('Edition')->getFullName() : '';

    $item['menu'] = array();
    $item['menu'][] = array(
        'text' => 'Update License',
        'handler' => 'this.updateLicense',
    );
    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'Remove License',
        'handler' => 'this.removeLicense',
    );

    $list[] = $item;
}
return $this->outputArray($list, $count);