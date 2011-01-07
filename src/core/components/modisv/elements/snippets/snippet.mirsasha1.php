<?php

// get modISV service
$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// include rsa functions
require_once $modisv->config['modelPath'] . 'rsa/rsa.php';

$p = array();
$p['LICENSE_ALG'] = 'RSA1024-SHA1';
$p['LICENSE_VER'] = '1.0';
foreach ($scriptProperties as $k => $v) {
    $p[strtoupper($k)] = $v;
}

$content = '';
foreach ($p as $k => $v) {
    $content .= $k . '=' . $v . '\n';
}

$D = (string)trim($modx->context->getOption('modisv.rsa1024_private_key'));
$N = (string)trim($modx->context->getOption('modisv.rsa1024_modulus'));
$sig = rsa_sign(sha1($content), $D, $N, 1024);
for ($i = 0; $i < 8; $i++) {
    $p['S' . ($i + 1)] = strtoupper(bin2hex(substr($sig, $i * 16, 16)));
}

$codes = '';
foreach ($p as $k => $v) {
    $codes .= $k . '=' . $v . "\r\n";
}
return $codes;