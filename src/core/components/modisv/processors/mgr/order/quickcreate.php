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
 * Quick creates an order with an order item.
 *
 * @package modisv
 * @subpackage processors
 */
$action = $scriptProperties['_action'];
switch ($action) {
    case 'license':
        $edition = $modx->getObject('miEdition', $scriptProperties['edition']);
        if (!$edition)
            return $modx->error->failure('Please specify a valid edition.');
        if (empty($scriptProperties['license_type']))
            return $modx->error->failure('Please specify the license type.');
        $scriptProperties['name'] = $edition->getFullName();
        break;

    case 'upgrade':
        $edition = $modx->getObject('miEdition', $scriptProperties['edition']);
        if (!$edition)
            return $modx->error->failure('Please specify a valid upgrade edition.');
        $license = $modx->getObject('miLicense', $scriptProperties['license']);
        if (!$license)
            return $modx->error->failure('Please specify a valid license.');
        $scriptProperties['name'] = sprintf('%s %s-%s Upgrade', $license->getProduct()->get('name'), $license->getRelease()->get('name'), $edition->getOne('Release')->get('name'));
        $scriptProperties['quantity'] = $license->get('quantity');
        break;

    case 'renew':
        $license = $modx->getObject('miLicense', $scriptProperties['license']);
        if (!$license)
            return $modx->error->failure('Please specify a valid license.');
        if (empty($scriptProperties['subscription_months']))
            return $modx->error->failure('Please specify the subscription months.');
        $scriptProperties['name'] = $license->getRelease()->getFullName() . ' Subscription Renewal';
        $scriptProperties['quantity'] = $license->get('quantity');
        break;

    default:
        return $modx->error->failure('Invalid action.');
}

$order = $modx->newObject('miOrder');
$order->set('status', 'pending');
if (!$order->save()) {
    $modx->error->checkValidation(array($order));
    return $modx->error->failure('An error occurred while trying to save the order.');
}

$orderItem = $modx->newObject('miOrderItem');
$orderItem->fromArray($scriptProperties);
$orderItem->set('action', $action);
$orderItem->set('order', $order->get('id'));
if (!$orderItem->save()) {
    $modx->error->checkValidation(array($orderItem));
    return $modx->error->failure('An error occurred while trying to save the order item.');
}

$url = $modx->makeUrl($modx->getOption('modisv.shopping_cart_page'), '', array('action' => 'checkout', 'order' => strtolower($order->get('guid'))), 'full');
return $modx->error->success('', array('url' => $url));
