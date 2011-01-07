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
 * Properties for the miLicense snippet.
 *
 * @package modisv
 * @subpackage build
 */


$properties = array(
    array(
        'name' => 'listTpl',
        'desc' => 'The chunk that will be used to display the license list.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseList',
    ),
    array(
        'name' => 'listItemTpl',
        'desc' => 'The chunk that will be used to display an item in the license list.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseListItem',
    ),
    array(
        'name' => 'detailsTpl',
        'desc' => 'The chunk that will be used to display the details of a license.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseDetails',
    ),
    array(
        'name' => 'renewTpl',
        'desc' => 'The chunk that will be used to display the renew license form.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseRenew',
    ),
    array(
        'name' => 'renewSpecialTpl',
        'desc' => 'The chunk that will be displayed when user is to renew a special license.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseRenewSpecial',
    ),
    array(
        'name' => 'renewPriceFactor',
        'desc' => 'The factor of the renew price, a percentage value.',
        'type' => 'textfield',
        'options' => '',
        'value' => '40',
    ),
    array(
        'name' => 'upgradeTpl',
        'desc' => 'The chunk that will be used to display the license upgrade form.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseUpgrade',
    ),
    array(
        'name' => 'upgradeSpecialTpl',
        'desc' => 'The chunk that will be displayed when user is to upgrade a special license.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseUpgradeSpecial',
    ),
    array(
        'name' => 'upgradeSuccessTpl',
        'desc' => 'The chunk that will be displayed when upgrade is successful.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'miLicenseUpgradeSuccess',
    ),
    array(
        'name' => 'upgradePriceFactor',
        'desc' => 'The factor of the upgrade price, a percentage value.',
        'type' => 'textfield',
        'options' => '',
        'value' => '70',
    ),
);

return $properties;