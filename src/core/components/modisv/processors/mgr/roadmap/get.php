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
 * Gets a list of roadmaps.
 *
 * @package modisv
 * @subpackage processors
 */
$isLimit = !empty($scriptProperties['limit']);
$start = isset($scriptProperties['start']) ? $scriptProperties['start'] : 0;
$limit = isset($scriptProperties['limit']) ? $scriptProperties['limit'] : 20;

// search
$c = $modx->newQuery('miTicket');
$c->select("target_version as name, COUNT(target_version) as total, SUM(status = 'open') as opened");
$c->groupby('target_version', "DESC");
$c->prepare();
$c->stmt->execute();
$roadmaps = $c->stmt->fetchAll();
$c->stmt->closeCursor();

$count = count($roadmaps);
if ($isLimit)
    $roadmaps = array_slice(roadmaps, 0, $limit);

$list = array();
foreach ($roadmaps as $roadmap) {
    $item = $roadmap;

    $item['menu'][] = '-';
    $item['menu'][] = array(
        'text' => 'View Roadmap',
        'handler' => 'this.viewRoadmap',
    );

    $list[] = $item;
}
return $this->outputArray($list, $count);