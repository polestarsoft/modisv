<?php

$input = (int) $modx->getOption('input', $scriptProperties, 0);

$units = array('B', 'KB', 'MB', 'GB', 'TB');
$input = max($input, 0);
$pow = floor(($input ? log($input) : 0) / log(1024));
$pow = min($pow, count($units) - 1);
$input /= pow(1024, $pow);

return round($input, 2) . ' ' . $units[$pow];