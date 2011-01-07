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
 * Properties for the miShoppingCart snippet.
 *
 * @package modisv
 * @subpackage build
 */

$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'The chunk that will be used to display the shopping cart.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miShoppingCart',
    ),
    array(
        'name' => 'itemTpl',
        'desc' => 'The chunk that will be used to display shopping cart items.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miShoppingCartItem',
    ),
    array(
        'name' => 'emptyTpl',
        'desc' => 'The chunk that will be displayed when the shopping cart is empty.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miShoppingCartEmpty',
    ),
    array(
        'name' => 'returnResourceId',
        'desc' => 'The resource ID of the page that will be displayed when returned from payment processor.',
        'type' => 'textfield',
        'options' => '',
        'value' => '1',
    ),
);

return $properties;