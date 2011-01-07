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
 * Adds modActions and modMenus into package
 *
 * @package modisv
 * @subpackage build
 */
$action = $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 1,
    'namespace' => 'modisv',
    'parent' => 0,
    'controller' => 'index',
    'haslayout' => 1,
    'lang_topics' => 'modisv:default',
    'assets' => '',
), '', true, true);

/* load action into menu */
$menus = array();
$menus['modISV'] = $modx->newObject('modMenu');
$menus['modISV']->fromArray(array(
    'text' => 'modISV',
    'parent' => 'components',
    'description' => 'Manage modISV Stuff',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
), '', true, true);

$menus['Products'] = $modx->newObject('modMenu');
$menus['Products']->fromArray(array(
    'text' => 'Products',
    'parent' => 'modISV',
    'description' => 'Manage Products',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 1,
    'params' => '&sa=products',
    'handler' => '',
), '', true, true);
$menus['Products']->addOne($action);

$menus['Orders'] = $modx->newObject('modMenu');
$menus['Orders']->fromArray(array(
    'text' => 'Orders',
    'parent' => 'modISV',
    'description' => 'Manage Orders',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 2,
    'params' => '&sa=orders',
    'handler' => '',
), '', true, true);
$menus['Orders']->addOne($action);

$menus['Licenses'] = $modx->newObject('modMenu');
$menus['Licenses']->fromArray(array(
    'text' => 'Licenses',
    'parent' => 'modISV',
    'description' => 'Manage Licenses',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 3,
    'params' => '&sa=licenses',
    'handler' => '',
), '', true, true);
$menus['Licenses']->addOne($action);

$menus['Coupons'] = $modx->newObject('modMenu');
$menus['Coupons']->fromArray(array(
    'text' => 'Coupons',
    'parent' => 'modISV',
    'description' => 'Manage Coupons',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 4,
    'params' => '&sa=coupons',
    'handler' => '',
), '', true, true);
$menus['Coupons']->addOne($action);

unset($action);

return $menus;