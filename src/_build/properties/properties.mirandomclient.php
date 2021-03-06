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
        'desc' => 'The chunk that will be used to display the random client.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miRandomClient',
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
        'desc' => 'The number of top clients to select a random client from. 0 indicates no limit.',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
    ),
);

return $properties;