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
 * Loads system settings into build
 *
 * @package modisv
 * @subpackage build
 */
$settings = array();

$settings['modisv.account_page'] = $modx->newObject('modSystemSetting');
$settings['modisv.account_page']->fromArray(array(
    'key' => 'modisv.account_page',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'site'
), '', true, true);

$settings['modisv.shopping_cart_page'] = $modx->newObject('modSystemSetting');
$settings['modisv.shopping_cart_page']->fromArray(array(
    'key' => 'modisv.shopping_cart_page',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'site'
), '', true, true);

$settings['modisv.noreply_email'] = $modx->newObject('modSystemSetting');
$settings['modisv.noreply_email']->fromArray(array(
    'key' => 'modisv.noreply_email',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'site'
), '', true, true);

$settings['modisv.sales_email'] = $modx->newObject('modSystemSetting');
$settings['modisv.sales_email']->fromArray(array(
    'key' => 'modisv.sales_email',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'site'
), '', true, true);

$settings['modisv.support_email'] = $modx->newObject('modSystemSetting');
$settings['modisv.support_email']->fromArray(array(
    'key' => 'modisv.support_email',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'site'
), '', true, true);

$settings['modisv.user_group'] = $modx->newObject('modSystemSetting');
$settings['modisv.user_group']->fromArray(array(
    'key' => 'modisv.user_group',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'site'
), '', true, true);

$settings['modisv.paypal_business'] = $modx->newObject('modSystemSetting');
$settings['modisv.paypal_business']->fromArray(array(
    'key' => 'modisv.paypal_business',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'paypal'
), '', true, true);

$settings['modisv.paypal_currency'] = $modx->newObject('modSystemSetting');
$settings['modisv.paypal_currency']->fromArray(array(
    'key' => 'modisv.paypal_currency',
    'value' => 'USD',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'paypal'
), '', true, true);

$settings['modisv.paypal_sandbox'] = $modx->newObject('modSystemSetting');
$settings['modisv.paypal_sandbox']->fromArray(array(
    'key' => 'modisv.paypal_sandbox',
    'value' => '0',
    'xtype' => 'combo-boolean',
    'namespace' => 'modisv',
    'area' => 'paypal'
), '', true, true);

$settings['modisv.rsa1024_private_key'] = $modx->newObject('modSystemSetting');
$settings['modisv.rsa1024_private_key']->fromArray(array(
    'key' => 'modisv.rsa1024_private_key',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'keygen'
), '', true, true);

$settings['modisv.rsa1024_modulus'] = $modx->newObject('modSystemSetting');
$settings['modisv.rsa1024_modulus']->fromArray(array(
    'key' => 'modisv.rsa1024_modulus',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'keygen'
), '', true, true);

return $settings;