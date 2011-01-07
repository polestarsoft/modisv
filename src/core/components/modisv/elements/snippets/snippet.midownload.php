<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get the file
if (!isset($_REQUEST['file'])) {
    return '';
}

$file = $modx->getObject('miFile', array('guid' => strtoupper($_REQUEST['file'])));
if (!$file) {
    $modx->sendErrorPage();
}

// verify authenticated status
$user = $modx->user;
if (!$file->isAvailableForUser($user)) {
    $modx->sendUnauthorizedPage();
}

// increase download count
$file->set('download_count', $file->get('download_count') + 1);
if(!$file->save()) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'An error occured while trying to save the file.');
}

$filename = $file->getFileName();
miUtilities::sendDownload($file->get('path'));