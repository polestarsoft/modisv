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
 * Add snippets to build
 * 
 * @package modisv
 * @subpackage build
 */
$snippets = array();

$snippets['miDownload'] = $modx->newObject('modSnippet');
$snippets['miDownload']->fromArray(array(
    'name' => 'miDownload',
    'description' => 'A snippet for downloading files.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.midownload.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.midownload.php';
$snippets['miDownload']->setProperties($properties);

$snippets['miFiles'] = $modx->newObject('modSnippet');
$snippets['miFiles']->fromArray(array(
    'name' => 'miFiles',
    'description' => 'A snippet for listing files of a product.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.mifiles.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.mifiles.php';
$snippets['miFiles']->setProperties($properties);

$snippets['miFileSize'] = $modx->newObject('modSnippet');
$snippets['miFileSize']->fromArray(array(
    'name' => 'miFileSize',
    'description' => 'A output filter that formats file size.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.mifilesize.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.mifilesize.php';
$snippets['miFileSize']->setProperties($properties);

$snippets['miLicenses'] = $modx->newObject('modSnippet');
$snippets['miLicenses']->fromArray(array(
    'name' => 'miLicenses',
    'description' => 'A snippet that can be used to list, dispay, download, renew and upgrade licenses.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.milicenses.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.milicenses.php';
$snippets['miLicenses']->setProperties($properties);

$snippets['miOrders'] = $modx->newObject('modSnippet');
$snippets['miOrders']->fromArray(array(
    'name' => 'miOrders',
    'description' => 'A snippet that can be used to list or dispay orders.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.miorders.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.miorders.php';
$snippets['miOrders']->setProperties($properties);

$snippets['miOrderProduct'] = $modx->newObject('modSnippet');
$snippets['miOrderProduct']->fromArray(array(
    'name' => 'miOrderProduct',
    'description' => 'A snippet for ordering a product.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.miorderproduct.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.miorderproduct.php';
$snippets['miOrderProduct']->setProperties($properties);

$snippets['miProducts'] = $modx->newObject('modSnippet');
$snippets['miProducts']->fromArray(array(
    'name' => 'miProducts',
    'description' => 'A snippet for listing products.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.miproducts.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.miproducts.php';
$snippets['miProducts']->setProperties($properties);

$snippets['miRsaSha1'] = $modx->newObject('modSnippet');
$snippets['miRsaSha1']->fromArray(array(
    'name' => 'miRsaSha1',
    'description' => 'A license code generator that uses RSA-1024 and SHA1.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.mirsasha1.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.mirsasha1.php';
$snippets['miRsaSha1']->setProperties($properties);

$snippets['miShoppingCart'] = $modx->newObject('modSnippet');
$snippets['miShoppingCart']->fromArray(array(
    'name' => 'miShoppingCart',
    'description' => 'A snippet that implements a shopping cart.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.mishoppingcart.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.mishoppingcart.php';
$snippets['miShoppingCart']->setProperties($properties);

$snippets['miVersionHistory'] = $modx->newObject('modSnippet');
$snippets['miVersionHistory']->fromArray(array(
    'name' => 'miVersionHistory',
    'description' => 'A snippet that lists version histories of a product.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.miversionhistory.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.miversionhistory.php';
$snippets['miVersionHistory']->setProperties($properties);

$snippets['miClients'] = $modx->newObject('modSnippet');
$snippets['miClients']->fromArray(array(
    'name' => 'miClients',
    'description' => 'A snippet that lists clients of a product or all products.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.miclients.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.miclients.php';
$snippets['miClients']->setProperties($properties);

$snippets['miRandomClient'] = $modx->newObject('modSnippet');
$snippets['miRandomClient']->fromArray(array(
    'name' => 'miRandomClient',
    'description' => 'A snippet that displays a random client.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.mirandomclient.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.mirandomclient.php';
$snippets['miRandomClient']->setProperties($properties);

$snippets['miNewTicket'] = $modx->newObject('modSnippet');
$snippets['miNewTicket']->fromArray(array(
    'name' => 'miNewTicket',
    'description' => 'A snippet used to create new ticket.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.minewticket.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.minewticket.php';
$snippets['miNewTicket']->setProperties($properties);

$snippets['miViewTicket'] = $modx->newObject('modSnippet');
$snippets['miViewTicket']->fromArray(array(
    'name' => 'miViewTicket',
    'description' => 'A snippet used view a ticket.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.miviewticket.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.miviewticket.php';
$snippets['miViewTicket']->setProperties($properties);

$snippets['miTickets'] = $modx->newObject('modSnippet');
$snippets['miTickets']->fromArray(array(
    'name' => 'miTickets',
    'description' => ' snippet for listing all tickets of the current user.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.mitickets.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.mitickets.php';
$snippets['miTickets']->setProperties($properties);

$snippets['miFetchTickets'] = $modx->newObject('modSnippet');
$snippets['miFetchTickets']->fromArray(array(
    'name' => 'miFetchTickets',
    'description' => 'A snippet used to fetch ticket from email boxes via pop3/imap.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.mifetchtickets.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.mifetchtickets.php';
$snippets['miFetchTickets']->setProperties($properties);

$snippets['miCaptcha'] = $modx->newObject('modSnippet');
$snippets['miCaptcha']->fromArray(array(
    'name' => 'miCaptcha',
    'description' => 'A snippet used to render simple captcha.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.micaptcha.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.micaptcha.php';
$snippets['miCaptcha']->setProperties($properties);

$snippets['miCaptchaValidate'] = $modx->newObject('modSnippet');
$snippets['miCaptchaValidate']->fromArray(array(
    'name' => 'miCaptchaValidate',
    'description' => 'A snippet used to validate captcha answer.',
    'snippet' => getSnippetContent($sources['source_core'] . '/elements/snippets/snippet.micaptchavalidate.php'),
        ), '', true, true);
$properties = include $sources['build'] . 'properties/properties.micaptchavalidate.php';
$snippets['miCaptchaValidate']->setProperties($properties);

return $snippets;