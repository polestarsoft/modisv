<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miClient');
$productAlias = $modx->getOption('product', $scriptProperties, '');
$limit = (int)$modx->getOption('limit', $scriptProperties, 0);
$sortby = $modx->getOption('sortBy', $scriptProperties, 'sort_order');
$dir = $modx->getOption('sortDir', $scriptProperties, 'ASC');
$category = $modx->getOption('category', $scriptProperties, '');

// get the clients
$c = $modx->newQuery('miClient');
if(!empty($category))
    $c->where(array('category' => $category));
$c->sortBy($sortby, $dir);
if (!empty($productAlias)) {
    $product = $modx->getObject('miProduct', array('alias' => $productAlias));
    if (!$product) {
        $modx->log(modX::LOG_LEVEL_ERROR, "[miClients] Product '{$productAlias}' not found.");
        return '';
    }
    $c->andCondition(array('product' => $product->get('id')));
}
if($limit !== 0) {
    $c->limit($limit);
}
$clients = $modx->getCollection('miClient', $c);
if(empty($clients)) {
    return 'There are no clients at this time.';
}

// render
$output = '';
$i = -1;
foreach ($clients as $c) {
    $i++;
    $phs = $c->toArray();
    $phs['class'] = 'i' . $i . ' ' . ($i % 2 ? 'alt' : '');
    $output .= $modisv->getChunk($tpl, $phs);
}

return $output;