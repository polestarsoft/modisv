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
 * Creates an order item.
 *
 * @package modisv
 * @subpackage processors
 */
$order = $modx->getObject('miOrder', $scriptProperties['_order']);
$orderItem = $modx->newObject('miOrderItem');

$scriptProperties['action'] = $scriptProperties['_action']; // to avoid overriding MODx.Window.action
$orderItem->fromArray($scriptProperties);
$orderItem->addOne($order);
if (!$orderItem->save())
{
    $modx->error->checkValidation(array($orderItem));
    return $modx->error->failure('An error occurred while trying to save the order item.');
}

return $modx->error->success('', $orderItem);

