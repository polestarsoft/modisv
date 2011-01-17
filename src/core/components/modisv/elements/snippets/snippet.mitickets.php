<?php

$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// verify authenticated status
$user = $modx->user;
if (!$user->isAuthenticated($modx->context->get('key'))) {
    $modx->sendUnauthorizedPage();
}

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miTickets');
$itemTpl = $modx->getOption('itemTpl', $scriptProperties, 'miTicketsItem');

$tickets = $modx->getCollection('miTicket', array('author_email' => $user->get('username')));
if (empty($tickets))
    return 'You have not created any tickets.';

$wrapper = '';
$i = 0;
foreach ($tickets as $t) {
    $phs = $t->toArray();
    $phs['view_url'] = $t->getUrl(false);
    $phs['class'] = $i++ % 2 ? "alt i{$i}" : "i{$i}";
    $wrapper .= $modisv->getChunk($itemTpl, $phs);
}
return $modisv->getChunk($tpl, array('wrapper' => $wrapper));

