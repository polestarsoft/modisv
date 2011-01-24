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
 * Add chunks to build
 * 
 * @package modisv
 * @subpackage build
 */
$chunks = array();

$chunks['miFile'] = $modx->newObject('modChunk');
$chunks['miFile']->fromArray(array(
    'name' => 'miFile',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mifile.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseDetails'] = $modx->newObject('modChunk');
$chunks['miLicenseDetails']->fromArray(array(
    'name' => 'miLicenseDetails',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicensedetails.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseList'] = $modx->newObject('modChunk');
$chunks['miLicenseList']->fromArray(array(
    'name' => 'miLicenseList',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicenselist.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseListItem'] = $modx->newObject('modChunk');
$chunks['miLicenseListItem']->fromArray(array(
    'name' => 'miLicenseListItem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicenselistitem.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miOrderDetails'] = $modx->newObject('modChunk');
$chunks['miOrderDetails']->fromArray(array(
    'name' => 'miOrderDetails',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miorderdetails.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miOrderItem'] = $modx->newObject('modChunk');
$chunks['miOrderItem']->fromArray(array(
    'name' => 'miOrderItem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miorderitem.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miOrderList'] = $modx->newObject('modChunk');
$chunks['miOrderList']->fromArray(array(
    'name' => 'miOrderList',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miorderlist.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miOrderListItem'] = $modx->newObject('modChunk');
$chunks['miOrderListItem']->fromArray(array(
    'name' => 'miOrderListItem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miorderlistitem.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseRenew'] = $modx->newObject('modChunk');
$chunks['miLicenseRenew']->fromArray(array(
    'name' => 'miLicenseRenew',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicenserenew.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseRenewSpecial'] = $modx->newObject('modChunk');
$chunks['miLicenseRenewSpecial']->fromArray(array(
    'name' => 'miLicenseRenewSpecial',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicenserenewspecial.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseUpgrade'] = $modx->newObject('modChunk');
$chunks['miLicenseUpgrade']->fromArray(array(
    'name' => 'miLicenseUpgrade',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicenseupgrade.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseUpgradeSpecial'] = $modx->newObject('modChunk');
$chunks['miLicenseUpgradeSpecial']->fromArray(array(
    'name' => 'miLicenseUpgradeSpecial',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicenseupgradespecial.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miLicenseUpgradeSuccess'] = $modx->newObject('modChunk');
$chunks['miLicenseUpgradeSuccess']->fromArray(array(
    'name' => 'miLicenseUpgradeSuccess',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/milicenseupgradesuccess.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miOrderProduct'] = $modx->newObject('modChunk');
$chunks['miOrderProduct']->fromArray(array(
    'name' => 'miOrderProduct',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miorderproduct.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miReleaseFiles'] = $modx->newObject('modChunk');
$chunks['miReleaseFiles']->fromArray(array(
    'name' => 'miReleaseFiles',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mireleasefiles.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miShoppingCart'] = $modx->newObject('modChunk');
$chunks['miShoppingCart']->fromArray(array(
    'name' => 'miShoppingCart',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mishoppingcart.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miShoppingCartEmpty'] = $modx->newObject('modChunk');
$chunks['miShoppingCartEmpty']->fromArray(array(
    'name' => 'miShoppingCartEmpty',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mishoppingcartempty.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miShoppingCartItem'] = $modx->newObject('modChunk');
$chunks['miShoppingCartItem']->fromArray(array(
    'name' => 'miShoppingCartItem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mishoppingcartitem.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miOrderNotification'] = $modx->newObject('modChunk');
$chunks['miOrderNotification']->fromArray(array(
    'name' => 'miOrderNotification',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miordernotification.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miVersionHistory'] = $modx->newObject('modChunk');
$chunks['miVersionHistory']->fromArray(array(
    'name' => 'miVersionHistory',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miversionhistory.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miVersionHistoryItem'] = $modx->newObject('modChunk');
$chunks['miVersionHistoryItem']->fromArray(array(
    'name' => 'miVersionHistoryItem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miversionhistoryitem.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miClient'] = $modx->newObject('modChunk');
$chunks['miClient']->fromArray(array(
    'name' => 'miClient',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miclient.chunk.tpl'),
    'properties' => '',
), '', true, true);

$chunks['miRandomClient'] = $modx->newObject('modChunk');
$chunks['miRandomClient']->fromArray(array(
    'name' => 'miRandomClient',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mirandomclient.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miTicketReply'] = $modx->newObject('modChunk');
$chunks['miTicketReply']->fromArray(array(
    'name' => 'miTicketReply',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miticketreply.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miTicketAutoresponse'] = $modx->newObject('modChunk');
$chunks['miTicketAutoresponse']->fromArray(array(
    'name' => 'miTicketAutoresponse',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miticketautoresponse.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miNewTicketNotification'] = $modx->newObject('modChunk');
$chunks['miNewTicketNotification']->fromArray(array(
    'name' => 'miNewTicketNotification',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/minewticketnotification.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miNewMessageNotification'] = $modx->newObject('modChunk');
$chunks['miNewMessageNotification']->fromArray(array(
    'name' => 'miNewMessageNotification',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/minewmessagenotification.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miTickets'] = $modx->newObject('modChunk');
$chunks['miTickets']->fromArray(array(
    'name' => 'miTickets',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mitickets.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miTicketsItem'] = $modx->newObject('modChunk');
$chunks['miTicketsItem']->fromArray(array(
    'name' => 'miTicketsItem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miticketsitem.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miViewTicket'] = $modx->newObject('modChunk');
$chunks['miViewTicket']->fromArray(array(
    'name' => 'miViewTicket',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miviewticket.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miMessage'] = $modx->newObject('modChunk');
$chunks['miMessage']->fromArray(array(
    'name' => 'miMessage',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/mimessage.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miAttachment'] = $modx->newObject('modChunk');
$chunks['miAttachment']->fromArray(array(
    'name' => 'miAttachment',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/miattachment.chunk.tpl'),
    'properties' => '',
), '', true, true);
$chunks['miNewTicket'] = $modx->newObject('modChunk');
$chunks['miNewTicket']->fromArray(array(
    'name' => 'miNewTicket',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/minewticket.chunk.tpl'),
    'properties' => '',
), '', true, true);

return $chunks;