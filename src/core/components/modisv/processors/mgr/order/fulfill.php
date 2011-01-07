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
 * Fulfills an order.
 *
 * @package modisv
 * @subpackage processors
 */
$order = $modx->getObject('miOrder', $scriptProperties['id']);
if (!$order) {
    return $modx->error->failure('Order not specified or not exists.');
}
if ($order->get('status') != 'pending') {
    return $modx->error->failure('Order not pending.');
}

// get or create the user
$user = $modx->getObject('modUser', array('username' => $scriptProperties['email']));
if (!$user) {
    if (!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $scriptProperties['email'])) {
        return $modx->error->failure('Invalid user email.');
    }
    if (empty($scriptProperties['fullname'])) {
        return $modx->error->failure('Full name is required.');
    }

    // create user
    $user = $modx->newObject('modUser');
    $user->set('username', $scriptProperties['email']);
    $user->set('active', 1);
    $password = $user->generatePassword();
    $user->set('password', md5($password));
    if ((bool) $scriptProperties['send_email']) {
        $user->set('cachepwd', $password);
    }
    if (!$user->save()) {
        return $modx->error->failure('An error occured while trying to save the user ' . print_r($user->toArray(), true));
    }
    
    $profile = $modx->newObject('modUserProfile');
    $profile->set('internalKey', $user->get('id'));
    $profile->set('fullname', $scriptProperties['fullname']);
    $profile->set('email', $scriptProperties['email']);
    $extended = array(
        'company' => $scriptProperties['company'],
        'license_name', $scriptProperties['license_name']);
    $profile->set('extended', $extended);
    if (!$profile->save()) {
        return $modx->error->failure('An error occured while trying to save the profile ' . print_r($profile->toArray(), true));
    }
}

// set usergroup
$usergroup = $modx->context->getOption('modisv.user_group');
if (!empty($usergroup) && !$user->isMember($usergroup)) {
    if (!$user->joinGroup($usergroup)) {
        return $modx->error->failure('Can\'t add user to group.');
    }
}

// fulfill the order
$fulfiller = new miOrderFulfiller();
if (!$fulfiller->fulfillOrder($order, $user, $scriptProperties['send_email'])) {
    return $modx->error->failure('An error occured while trying to fulfill the order.');
}

// change order status
$order->addOne($user);
$order->set('status', 'complete');
$order->set('payment_processor', 'none');
if (!$order->save()) {
    return $modx->error->failure('An error occured while trying to save the order.');
}

return $modx->error->success();
