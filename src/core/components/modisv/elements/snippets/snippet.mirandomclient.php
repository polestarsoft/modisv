<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miRandomClient');
$productAlias = $modx->getOption('product', $scriptProperties, '');
$limit = (int)$modx->getOption('limit', $scriptProperties, 0);

// get the clients
$c = $modx->newQuery('miClient');
$c->sortBy('sort_order');
if (!empty($productAlias)) {
    $product = $modx->getObject('miProduct', array('alias' => $productAlias));
    if (!$product) {
        $modx->log(modX::LOG_LEVEL_ERROR, "[miClients] Product '{$productAlias}' not found.");
        return '';
    }
    $c->where(array('product' => $product->get('id')));
}
if($limit !== 0) {
    $c->limit($limit);
}
$clients = $modx->getCollection('miClient', $c);
if(empty($clients)) {
    return '';
}

// select a client
$clients = array_values($clients);
$i = mt_rand(0, count($clients) - 1);
$client = $clients[$i];

// render
$phs = $client->toArray();
return $modisv->getChunk($tpl, $phs);

