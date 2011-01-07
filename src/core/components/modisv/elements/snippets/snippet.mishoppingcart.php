<?php

// get modISV service
$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miShoppingCart');
$itemTpl = $modx->getOption('itemTpl', $scriptProperties, 'miShoppingCartItem');
$emptyTpl = $modx->getOption('emptyTpl', $scriptProperties, 'miShoppingCartEmpty');
$returnResourceId = $modx->getOption('returnResourceId', $scriptProperties, 1);

// process according to the action
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
$cart = $modisv->shoppingCart();
switch ($action) {
    case 'checkout':
        if (isset($_REQUEST['order'])) {
            $order = $modx->getObject('miOrder', array('guid' => strtoupper($_REQUEST['order'])));
        } else {
            $order = $cart->getOrder();
        }
        
        if (!$order || $order->getTotal() < 0.01) {
            return "Can't check out empty cart.";
        }

        if($order->get('status') != 'pending') {
            return "Invalid order status.";
        }

        // load paypal class
        $paypal = new miPaypal();

        // generate paypal payment URL
        $xhtmlUrlSetting = $modx->config['xhtml_urls'];
        $modx->config['xhtml_urls'] = false;            // disable xhtml_urls temporarily
        $ipnUrl = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'ipn'), 'full');
        $returnUrl = $modx->makeUrl($returnResourceId, '', '', 'full');
        $modx->config['xhtml_urls'] = $xhtmlUrlSetting; // restore xhtml_urls
        $url = $paypal->getCheckoutUrl($order, $ipnUrl, $returnUrl);

        $modx->sendRedirect($url);
        break;

    case 'coupon':
        if ($cart->applyCoupon($_POST['coupon_code'])) {
            $modx->sendRedirect($modx->makeUrl($modx->resource->get('id')));
        } else {
            $phs['error.coupon_code'] = 'Invalid coupon code.';
        }
    case 'index':
        // get shopping cart items
        $items = $cart->getItems();
        if (empty($items))
            return $modisv->getChunk($emptyTpl);

        // get the items content
        $wrapper = '';
        $i = 0;
        foreach ($items as $item) {
            $itemPhs = $item->toArray();
            $itemPhs['total'] = $item->getTotal();
            $itemPhs['remove_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'remove', 'index' => $i++));
            $wrapper .= $modisv->getChunk($itemTpl, $itemPhs);
        }

        // place holders
        $phs['wrapper'] = $wrapper;
        $phs['total'] = $cart->getTotal();
        $phs['coupon_name'] = $cart->getCouponName();
        $phs['coupon_code'] = $cart->getCouponCode();
        $phs['coupon_discount'] = $cart->getCouponDiscount();
        $phs['coupon_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'coupon'));
        $phs['checkout_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'checkout'));
        return $modisv->getChunk($tpl, $phs);

    case 'ipn':
        // load paypal class
        $paypal = new miPaypal();
        $paypal->notify($_REQUEST);
        return '';

    case 'remove':
        $cart->removeItem($_REQUEST['index']);
        $modx->sendRedirect($modx->makeUrl($modx->resource->get('id')));
        break;

    default:
        $modx->log(modX::LOG_LEVEL_ERROR, "[miShoppingCart] Invalid action '{$action}'.");
        return '';
}
