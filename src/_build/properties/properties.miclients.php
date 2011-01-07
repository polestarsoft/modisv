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
 * Properties for the miVersionHistory snippet.
 *
 * @package modisv
 * @subpackage build
 */

$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'The chunk that will be used to display a client.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miClient',
    ),
    array(
        'name' => 'product',
        'desc' => 'The alias of the product whose clients will be displayed.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'limit',
        'desc' => 'The number of top clients to select. 0 indicates no limit.',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'The field to sort by.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'sort_order',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'The direction to sort by.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'ASC',
    ),
    array(
        'name' => 'category',
        'desc' => 'The client category. If specified, only those client in the category will be displayed.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
);

return $properties;