<?php

// we require imap ext to fetch emails via IMAP/POP3
if (!function_exists('imap_open')) {
    $modx->log(modX::LOG_LEVEL_ERROR, '[miFetchTickets] PHP must be compiled with IMAP extension enabled for IMAP/POP3 fetch to work!');
    return '';
}

// initialize modISV
$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$username = $modx->getOption('username', $scriptProperties, '');
$password = $modx->getOption('password', $scriptProperties, '');
$hostname = $modx->getOption('hostname', $scriptProperties, '');
$port = (int) $modx->getOption('port', $scriptProperties, '110');
$protocol = $modx->getOption('protocol', $scriptProperties, 'pop3');
$encryption = $modx->getOption('encryption', $scriptProperties, '');
$maxTickets = (int) $modx->getOption('maxTickets', $scriptProperties, '10');
$deleteMsgs = (bool) $modx->getOption('deleteMsgs', $scriptProperties, false);
$maxErrors = (int) $modx->getOption('maxErrors', $scriptProperties, 5);
$errorsDelay = (int) $modx->getOption('errorsDelay', $scriptProperties, 60 * 10); // 10 min
$freq = (int) $modx->getOption('freq', $scriptProperties, 60 * 1);

// check wether we can do fetch now
$fetchName = "{$protocol}://{$username}@{$hostname}:{$port}";
$fetchStat = $modx->getObject('miTicketFetch', array('name' => $fetchName));
if (!$fetchStat) {
    $fetchStat = $modx->newObject(miTicketFetch);
    $fetchStat->set('name', $fetchName);
}
if (time() - strtotime($fetchStat->get('last_fetch')) < $freq || // too frequent
        ($fetchStat->get('errors') >= $maxErrors && time() - strtotime($fetchStat->get('last_error')) < $errorsDelay))  // still within max errors delay
    return '';

// do it now
$fetcher = new miMailFetcher($username, $password, $hostname, $port, $protocol, $encryption);
if ($fetcher->connect()) {
    $fetcher->fetchTickets($maxTickets, $deleteMsgs);
    $fetcher->close();

    // save fetch stat
    $fetchStat->set('errors', 0);
    $fetchStat->set('last_fetch', time());
    $fetchStat->save();
} else {
    // save fetch stat
    $fetchStat->set('errors', $fetchStat->get('errors') + 1);
    $fetchStat->set('last_error', time());
    $fetchStat->save();

    if ($fetchStat->get('errors') >= $maxErrors) {
        $modx->log(modX::LOG_LEVEL_ERROR, "[miFetchTickets] {$maxErrors}  consecutive errors occured whil trying to fetching emails from {$fetchName}. Last error: {$fetcher->getLastError()}.");
    }
}

return '';

