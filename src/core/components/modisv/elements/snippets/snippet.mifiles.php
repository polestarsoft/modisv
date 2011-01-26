<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miReleaseFiles');
$fileTpl = $modx->getOption('fileTpl', $scriptProperties, 'miFile');
$productAlias = $modx->getOption('product', $scriptProperties, '');
$showOldVersions = (bool) $modx->getOption('showOldVersions', $scriptProperties, false);
$customersOnly = (bool) $modx->getOption('customersOnly', $scriptProperties, false);
$downloadResourceId = (int) $modx->getOption('downloadResourceId', $scriptProperties, 1);

// verify authenticated status
$user = $modx->user;
if ($customersOnly && !$user->isAuthenticated($modx->context->get('key'))) {
    $modx->sendUnauthorizedPage();
}

// get product(s)
if (empty($productAlias)) {
    $products = $modx->getCollection('miProduct');
} else {
    $product = $modx->getObject('miProduct', array('alias' => $productAlias));
    if (!$product) {
        $modx->log(modX::LOG_LEVEL_ERROR, "[miFiles] Product '{$productAlias}' not found.");
        return '';
    }
    $products = array($product);
}

// get releases
$releases = array();
foreach ($products as $p) {
    if ($customersOnly) {
        foreach ($p->getMany('Releases') as $r) {
            if (miUser::holdLicenseOf($user, $r)) {
                $releases[] = $r;
            }
        }
    } else {
        if ($showOldVersions) {
            $releases = array_merge($releases, $p->getReleases());
        } else {
            $r = $p->getCurrentRelease();
            if ($r)
                $releases[] = $r;
        }
    }
}

$output = '';
foreach ($releases as $r) {
    $files = $r->getFiles($customersOnly);
    if (empty($files))
        continue;

    $wrapper = '';
    $i = 0;
    foreach ($files as $f) {
        $phs = $f->toArray();
        $phs['filename'] = $f->getFileName();
        $phs['download_url'] = $modx->makeUrl($downloadResourceId, '', array('file' => strtolower($f->get('guid'))));
        $phs['class'] = $i++ % 2 ? 'alt' : '';
        $wrapper .= $modisv->getChunk($fileTpl, $phs);
    }

    $phs = $r->toArray();
    $phs['fullname'] = $r->getFullName();
    $phs['wrapper'] = $wrapper;
    $output .= $modisv->getChunk($tpl, $phs);
}

return $output ? : 'There are no files to download at this time.';