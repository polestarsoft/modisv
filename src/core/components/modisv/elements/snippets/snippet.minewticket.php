<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// generate output
$output = 'a';

return $output;

