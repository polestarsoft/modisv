<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, '');
$sortby = $modx->getOption('sortBy', $scriptProperties, 'sort_order');
$dir = $modx->getOption('sortDir', $scriptProperties, 'ASC');

// get all products
$c = $modx->newQuery('miProduct');
$c->sortby($sortby, $dir);
$products = $modx->getCollection('miProduct', $c);

// generate output
$output = '';
$i = -1;
foreach ($products as $product) {
    $i++;
    $properties = $product->toArray('product.');
    $properties['product.class'] = (($i % 2) ? 'alt ' : '') . 'i' . $i;
    $output .= $modisv->getChunk($tpl, $properties);
}

return $output;

