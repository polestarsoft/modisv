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
 * Properties for the miCaptcha snippet.
 *
 * @package modisv
 * @subpackage build
 */

$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'The template string of the captcha.',
        'type' => 'textfield',
        'options' => '',
        'value' => '[[+question]]<input type="text" name="captcha" /><input type="hidden" name="captcha_id" value="[[+id]]" />',
    ),
    array(
        'name' => 'skipMember',
        'desc' => 'Whether to hide captcha for authenticated members.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'promoteCount',
        'desc' => 'The number of correct answers after which the user will be prompted (thus no captcha any more). Set to zero to disable the feature.',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'maxAttempts',
        'desc' => 'The number of wrong answers after which the user will be limited.',
        'type' => 'textfield',
        'options' => '',
        'value' => '10',
    ),
    array(
        'name' => 'timeout',
        'desc' => 'The time out of a captcha session, in seconds.',
        'type' => 'textfield',
        'options' => '',
        'value' => '600',
    ),
    array(
        'name' => 'concurrentLimit',
        'desc' => 'The max concurrent captcha sessions allowed for a user.',
        'type' => 'textfield',
        'options' => '',
        'value' => '10',
    ),
);

return $properties;