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

$settings['modisv.captcha_qas'] = $modx->newObject('modSystemSetting');
$settings['modisv.captcha_qas']->fromArray(array(
    'key' => 'modisv.captcha_qas',
    'value' => "What number comes after 8? 9,nine\nWhat number comes after 3? 4,four\nWhat number comes after 11? 12,twelve\nWhat number comes before 6? 5,five\nWhat number comes before 12? 11,eleven\nThe name of David is? david\nThe name of Holly is? holly\nWhat is the name of Mike? mike\nWhat is the name of John? john\nThe green shark is what colour? green\nThe brown duck is what colour? brown\nTwo add four is what? 6,six\nWhat is one plus one? 2,two\nWhat is six add three? 9,nine\nFour plus one = ? 5,five\nOne plus two = ? 3,three\n3 add 8 = ? 11,eleven\nFive times two is what? 10,ten\nTwo times three is what? 6,six\nWhat is the 2nd digit in 12345? 2,two\nWhat is the last digit in 56789? 9,nine\nWhat is the first digit in 54321? 5,five\nWhat is the opposite of cold? hot,warm\nWhat is the opposite of bad? good\nWhat is the opposite of north? south\nWhat is the opposite of true? false\nWhat day comes after Monday? tuesday\nWhat day comes after Thursday? friday\nWhat day comes after Saturday? sunday\nIs ice hot or cold? cold\n",
    'xtype' => 'textarea',
    'namespace' => 'modisv',
    'area' => 'captcha'
), '', true, true);

$settings['modisv.ticket_reply_separator'] = $modx->newObject('modSystemSetting');
$settings['modisv.ticket_reply_separator']->fromArray(array(
    'key' => 'modisv.ticket_reply_separator',
    'value' => '----------reply above this line-----------',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'ticket'
), '', true, true);

$settings['modisv.view_ticket_page'] = $modx->newObject('modSystemSetting');
$settings['modisv.view_ticket_page']->fromArray(array(
    'key' => 'modisv.view_ticket_page',
    'value' => '1',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'ticket'
), '', true, true);

$settings['modisv.ticket_attachments_dir'] = $modx->newObject('modSystemSetting');
$settings['modisv.ticket_attachments_dir']->fromArray(array(
    'key' => 'modisv.ticket_attachments_dir',
    'value' => 'assets/tickets',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'ticket'
), '', true, true);

$settings['modisv.ticket_staffs'] = $modx->newObject('modSystemSetting');
$settings['modisv.ticket_staffs']->fromArray(array(
    'key' => 'modisv.ticket_staffs',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'ticket'
), '', true, true);

$settings['modisv.ticket_auth_salt'] = $modx->newObject('modSystemSetting');
$settings['modisv.ticket_auth_salt']->fromArray(array(
    'key' => 'modisv.ticket_auth_salt',
    'value' => '#modisv#',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'ticket'
), '', true, true);

$settings['modisv.upload_max_size'] = $modx->newObject('modSystemSetting');
$settings['modisv.upload_max_size']->fromArray(array(
    'key' => 'modisv.upload_max_size',
    'value' => '4194304',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'ticket'
), '', true, true);

$settings['modisv.upload_max_files'] = $modx->newObject('modSystemSetting');
$settings['modisv.upload_max_files']->fromArray(array(
    'key' => 'modisv.upload_max_files',
    'value' => '10',
    'xtype' => 'textfield',
    'namespace' => 'modisv',
    'area' => 'ticket'
), '', true, true);

return $settings;