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
 * Gets all the valid enum values of the specified field.
 *
 * @package modisv
 * @subpackage processors
 */
$class = $scriptProperties['class'];
$field = $scriptProperties['field'];

if(empty($class) || empty($field))
    return $modx->error->failure('Class or field not specified.');

$metas = $modx->getFieldMeta($class);
if(!isset($metas))
    return $modx->error->failure('Class meta not found.');

$meta = $metas[$field];
if(!$meta)
    return $modx->error->failure('Field meta not found.');

$list = array();
foreach (explode(',', $meta['precision']) as $method) {
    $method = trim($method, ' \'');
    $list[] = array(
        'value' => $method,
        'text' => $method,
    );
}
return $this->outputArray($list);