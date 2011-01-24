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
 * Properties for the miFetchTickets snippet.
 *
 * @package modisv
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'username',
        'desc' => 'The username of the email box to fetch.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'password',
        'desc' => 'The password of the email box to fetch.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'hostname',
        'desc' => 'The hostname of the email server.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'port',
        'desc' => 'The port of the email server.',
        'type' => 'textfield',
        'options' => '',
        'value' => '110',
    ),
    array(
        'name' => 'protocol',
        'desc' => 'The protocol to use.',
        'type' => 'list',
        'options' => array(
            array('text' => 'pop3', 'value' => 'pop3'),
            array('text' => 'imap', 'value' => 'imap'),
        ),
        'value' => 'pop3',
    ),
    array(
        'name' => 'encryption',
        'desc' => 'The encryption method.',
        'type' => 'list',
        'options' => array(
            array('text' => 'ssl', 'value' => 'ssl'),
            array('text' => '(none)', 'value' => ''),
        ),
        'value' => '',
    ),
    array(
        'name' => 'deleteMsgs',
        'desc' => 'Wether to delete messages from server if tickets are succefully created.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'maxErrors',
        'desc' => 'The max number of connect errors after which the fetcher will sleep for a period of time specified in "errorsDelay".',
        'type' => 'textfield',
        'options' => '',
        'value' => '5',
    ),
    array(
        'name' => 'errorsDelay',
        'desc' => 'How many seconds to sleep if maxErrors number of errors occured.',
        'type' => 'textfield',
        'options' => '',
        'value' => '600',
    ),
    array(
        'name' => 'freq',
        'desc' => 'The fetch frequency, in secconds.',
        'type' => 'textfield',
        'options' => '',
        'value' => '60',
    ),
);

return $properties;