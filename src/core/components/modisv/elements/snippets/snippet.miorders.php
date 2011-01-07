<?php

// get modISV service
$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// verify authenticated status
$user = $modx->user;
if (!$user->isAuthenticated($modx->context->get('key'))) {
    $modx->sendUnauthorizedPage();
}

// get properties
$listTpl = $modx->getOption('listTpl', $scriptProperties, 'miOrderList');
$listItemTpl = $modx->getOption('listItemTpl', $scriptProperties, 'miOrderListItem');
$detailsTpl = $modx->getOption('detailsTpl', $scriptProperties, 'miOrderDetails');
$itemTpl = $modx->getOption('itemTpl', $scriptProperties, 'miOrderItem');

// process according to the action
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
switch ($action) {
    case 'index':
        $orders = $modx->getCollection('miOrder', array('user' => $modx->user->get('id'), 'status' => 'complete'));
        if (empty($orders))
            return 'You have not placed any orders.';

        $wrapper = '';
        $i = 0;
        foreach ($orders as $o) {
            $phs = $o->toArray();
            $phs['total'] = $o->getTotal();
            $phs['class'] = $i++ % 2 ? "alt i{$i}" : "i{$i}";
            $phs['details_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'details', 'order' => $o->get('guid')));
            $wrapper .= $modisv->getChunk($listItemTpl, $phs);
        }
        return $modisv->getChunk($listTpl, array('wrapper' => $wrapper));

    case 'details':
        $order = $modx->getObject('miOrder', array('user' => $user->get('id'), 'guid' => $_REQUEST['order']));
        if (!$order)
            return "Order '{$_REQUEST['order']}' not found.";

        $wrapper = '';
        foreach ($order->getMany('Items') as $oi) {
            $phs = $oi->toArray();
            $phs['total'] = $oi->getTotal();
            $wrapper .= $modisv->getChunk($itemTpl, $phs);
        }

        $phs = $order->toArray();
        $phs['total'] = $order->getTotal();
        $phs['discount'] = $order->getCouponDiscount();
        $phs['coupon'] = $order->getCouponName();
        $phs['wrapper'] = $wrapper;
        return $modisv->getChunk($detailsTpl, $phs);

    default:
        $modx->log(modX::LOG_LEVEL_ERROR, "[miOrder] Invalid action '{$action}'.");
        return '';
}
