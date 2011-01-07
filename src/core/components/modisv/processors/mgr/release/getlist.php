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
 * Get a list of releases.
 *
 * @package modisv
 * @subpackage processors
 */
$isLimit = !empty($scriptProperties['limit']);
$start = isset($scriptProperties['start']) ? $scriptProperties['start'] : 0;
$limit = isset($scriptProperties['limit']) ? $scriptProperties['limit'] : 20;

if (empty($scriptProperties['product']))
    return $modx->error->failure('Product not specified.');

$c = $modx->newQuery('miRelease');
$c->where(array('product' => $scriptProperties['product']));
$count = $modx->getCount('miRelease', $c);
if ($isLimit)
    $c->limit($limit, $start);
$c->sortby('version');
$releases = $modx->getCollection('miRelease', $c);

$list = array();
foreach ($releases as $release) {
    $item = $release->toArray();

    $item['menu'] = array();
    $item['menu'][] = array(
        'text' => 'Update Release',
        'handler' => 'this.updateRelease',
    );
    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'Remove Release',
        'handler' => 'this.removeRelease',
    );

    $list[] = $item;
}
return $this->outputArray($list, $count);
