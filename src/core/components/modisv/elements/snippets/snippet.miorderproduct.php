<?php

// get modISV service
$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

// get properties
$tpl = $modx->getOption('tpl', $scriptProperties, 'miOrderProduct');
$productAlias = $modx->getOption('product', $scriptProperties, '');
$shoppingCartResourceId = (int) $modx->context->getOption('modisv.shopping_cart_page', 1);

// get the product
$product = $modx->getObject('miProduct', array('alias' => $productAlias));
if (!$product) {
    $modx->log(modX::LOG_LEVEL_ERROR, "[miOrderProduct] Product '{$productAlias}' not found.");
    return '';
}

// get the current release
$release = $product->getCurrentRelease();
if (!$release) {
    $modx->log(modX::LOG_LEVEL_ERROR, "[miOrderProduct] Product '{$productAlias}' has no releases.");
    return '';
}

// place holders
$phs = $product->toArray('product.');
$phs = array_merge($phs, $release->toArray('release.'));
$phs['editions_html'] = '';
$editionIndex = -1;
foreach ($release->getMany('Editions') as $edition) {
    $editionIndex++;
    $checked = $edition->get('id') == $_POST['edition'] || empty($_POST['edition']) && $editionIndex == 0  // selected or first edition
            ? 'checked="checked"'
            : '';
    $phs['editions_html'] .= "<input id=\"edition_{$edition->get('id')}\" name=\"edition\" type=\"radio\" value=\"{$edition->get('id')}\" {$checked}>";
    $phs['editions_html'] .= "<label for=\"edition_{$edition->get('id')}\">{$edition->get('name')} - \${$edition->get('price')}</label><br />";
}
$phs['subscriptions_html'] = '<select id="subscription" name="subscription"><option value="">None</option>';
foreach ($release->getMany('Subscriptions') as $subscription) {
    $selected = $subscription->get('id') == $_POST['$subscription'] ? 'selected="selected"' : '';
    $phs['subscriptions_html'] .= "<option value=\"{$subscription->get('id')}\" {$selected}>{$subscription->get('name')} (+{$subscription->get('price')}%)</option>";
}
$phs['subscriptions_html'] .= '</select>';

// process post-back
if (!empty($_POST)) {
    $errors = array();

    $edition = $modx->getObject('miEdition', $_POST['edition']);
    if (!$edition)
        $errors['edition'] = 'Please specify an edition.';
    if (empty($_POST['quantity']) || $_POST['quantity'] <= 0)
        $errors['quantity'] = 'Please specify a quantity.';

    if (empty($errors)) {
        $item = array();
        $item['name'] = $edition->getFullName();
        $discount = $_POST['quantity'] >= 21 ? 0.3 : ($_POST['quantity'] >= 11 ? 0.2 : ($_POST['quantity'] >= 6 ? 0.15 : ($_POST['quantity'] >= 2 ? 0.1 : 0)));
        $item['unit_price'] = round($edition->get('price') * (1 - $discount), 2);
        $item['quantity'] = $_POST['quantity'];
        $item['action'] = 'license';
        $item['edition'] = $edition->get('id');
        $item['license_type'] = $edition->getOne('Release')->getDefaultLicenseType();
        if (!empty($_POST['subscription']) && $subscription = $modx->getObject('miSubscription', $_POST['subscription'])) {
            $item['subscription_months'] = $subscription->get('months');
            $item['name'] .= ' with ' . $subscription->get('name');
            $item['unit_price'] += round($subscription->get('price') * $item['unit_price'] / 100, 2);
        }
        $modisv->shoppingCart()->addItem($item);
        return $modx->sendRedirect($modx->makeUrl($shoppingCartResourceId));
    }

    // set error messages
    foreach ($errors as $k => $v)
        $phs['error.' . $k] = $v;

    // set post values
    $phs = array_merge($phs, $_POST);
}

return $modisv->getChunk($tpl, $phs);
