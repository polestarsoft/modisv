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
 * Creates a product.
 *
 * @package modisv
 * @subpackage processors
 */
$product = $modx->newObject('miProduct');
if(empty($scriptProperties['alias']))
  $scriptProperties['alias'] = strtolower(preg_replace ('/[^a-zA-Z0-9-]/', '-', $scriptProperties['name']));
if(empty($scriptProperties['overview_url']))
  $scriptProperties['overview_url'] = 'products/' . $scriptProperties['alias'];
if(empty($scriptProperties['download_url']))
  $scriptProperties['download_url'] = 'download/' . $scriptProperties['alias'];
if(empty($scriptProperties['order_url']))
  $scriptProperties['order_url'] = 'store/' . $scriptProperties['alias'];
$product->fromArray($scriptProperties);
if (!$product->save()) {
    $modx->error->checkValidation(array($product));
    return $modx->error->failure('An error occurred while trying to save the product.');
}

return $modx->error->success('', $product);
