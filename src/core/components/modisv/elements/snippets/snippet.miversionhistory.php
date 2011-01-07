<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miVersionHistory');
$itemTpl = $modx->getOption('itemTpl', $scriptProperties, 'miVersionHistoryItem');
$productAlias = $modx->getOption('product', $scriptProperties, '');

// get the product
$product = $modx->getObject('miProduct', array('alias' => $productAlias));
if (!$product) {
    $modx->log(modX::LOG_LEVEL_ERROR, "[miVersionHistory] Product '{$productAlias}' not found.");
    return '';
}

// get releases
$releases = $product->getReleases();
if (count($releases) == 0) {
    return 'The product has no version history.';
}

$output = '';
$i = 0;
foreach ($releases as $r) {
    $changesSets = array();
    foreach ($r->getUpdates() as $u) {
        $changesSets[$u->get('version')] = $u->get('changes');
    }
    $changesSets[$r->get('name') ? : $r->get('version')] = $r->get('changes');

    foreach ($changesSets as $version => $changes) {
        $wrapper = '';
        foreach(explode("\n", $changes) as $c) {
            $c = trim($c);
            if (!empty($c)) {
                $wrapper .= $modisv->getChunk($itemTpl, array('change' => $c));
            }
        }
        $phs['version'] = $version;
        $phs['class'] = $i++ % 2 ? 'alt' : '';
        $phs['wrapper'] = $wrapper;
        $output .= $modisv->getChunk($tpl, $phs);
    }
}

return $output;