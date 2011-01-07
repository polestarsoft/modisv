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
$listTpl = $modx->getOption('listTpl', $scriptProperties, 'miLicenseList');
$listItemTpl = $modx->getOption('listItemTpl', $scriptProperties, 'miLicenseListItem');
$detailsTpl = $modx->getOption('detailsTpl', $scriptProperties, 'miLicenseDetails');
$renewTpl = $modx->getOption('renewTpl', $scriptProperties, 'miLicenseRenew');
$renewSpecialTpl = $modx->getOption('renewSpecialTpl', $scriptProperties, 'miLicenseRenewSpecial');
$renewPriceFactor = (int) $modx->getOption('renewPriceFactor', $scriptProperties, 40);
$upgradeTpl = $modx->getOption('upgradeTpl', $scriptProperties, 'miLicenseUpgrade');
$upgradeSpecialTpl = $modx->getOption('upgradeSpecialTpl', $scriptProperties, 'miLicenseUpgradeSpecial');
$upgradeSuccessTpl = $modx->getOption('upgradeSuccessTpl', $scriptProperties, 'miLicenseUpgradeSuccess');
$upgradePriceFactor = (int) $modx->getOption('upgradePriceFactor', $scriptProperties, 70);
$shoppingCartResourceId = (int) $modx->context->getOption('modisv.shopping_cart_page', 1);

// process according to the action
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
switch ($action) {
    case 'index':
        $licenses = miUser::getLicenses($modx->user);
        if (empty($licenses))
            return 'You have not purchased any licenses.';

        $wrapper = '';
        $i = 0;
        foreach ($licenses as $l) {
            $phs = $l->toArray();
            $phs['name'] = $l->getOne('Edition')->getFullName();
            $phs['class'] = $i++ % 2 ? "alt i{$i}" : "i{$i}";
            $phs['subsription_expiry'] = $l->getSubsriptionExpiry();
            $phs['details_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'details', 'license' => $l->get('id')));
            $wrapper .= $modisv->getChunk($listItemTpl, $phs);
        }
        return $modisv->getChunk($listTpl, array('wrapper' => $wrapper));

    case 'details':
        $license = $modx->getObject('miLicense', array('user' => $user->get('id'), 'id' => $_REQUEST['license']));
        if (!$license)
            return "License #{$_REQUEST['license']} not found.";

        $phs = $license->toArray();
        $phs['name'] = $license->getOne('Edition')->getFullName();
        $phs['license_name'] = miUser::getLicenseName($modx->user);
        $phs['licensing_method'] = $license->getRelease()->get('licensing_method');
        $phs['used'] = $license->getUsed();
        $phs['subscription_expiry'] = $license->getSubsriptionExpiry();
        $phs['download_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'download', 'license' => $license->get('id')));
        $phs['upgrade_available'] = $license->getRelease()->isUpgradeAvailable();
        $phs['upgrade_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'upgrade', 'license' => $license->get('id')));
        $phs['renew_available'] = !$license->isSubscriptionExpired() && !$license->hasLifetimeSubscription();
        $phs['renew_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'renew', 'license' => $license->get('id')));
        return $modisv->getChunk($detailsTpl, $phs);

    case 'download':
        $license = $modx->getObject('miLicense', array('user' => $user->get('id'), 'id' => $_REQUEST['license']));
        if (!$license)
            return "License #{$_REQUEST['license']} not found.";

        $filename = $license->getProduct()->get('alias') . '.lic';
        miUtilities::sendDownload($license->get('code'), $filename, true);
        break;

    case 'renew':
        // get license
        $license = $modx->getObject('miLicense', array('user' => $user->get('id'), 'id' => $_REQUEST['license']));
        if (!$license)
            return "License #{$_REQUEST['license']} not found.";

        // get renew related staff
        $edition = $license->getOne('Edition');
        $specialLicense = !in_array($license->get('type'), array('Single User License', 'Single Developer License', 'Single Server License'));
        $renewPrice = round($edition->get('price') * $renewPriceFactor / 100, 2);

        // check subscription
        if ($license->isSubscriptionExpired()) { // already expired
            return 'Renewal not available, subscription already expired.';
        } else if ($license->hasLifetimeSubscription()) {  // lifetime subscription
            return 'Renewal not available, you have already lifetime subscription.';
        }

        if (!empty($_POST)) {
            if ($specialLicense)
                return "Special license #{$license->get('id')} can't be renewed online.";

            $l = array();
            $l['name'] = $edition->getOne('Release')->getFullName() . ' Subscription Renewal';
            $l['unit_price'] = $renewPrice;
            $l['quantity'] = $license->get('quantity');
            $l['action'] = 'renew';
            $l['subscription_months'] = 12;
            $l['license'] = $license->get('id');
            $modisv->shoppingCart()->addItem($l);
            return $modx->sendRedirect($modx->makeUrl($shoppingCartResourceId));
        } else {
            // set place holders
            $phs = $license->toArray();
            if ($specialLicense) {
                return $modisv->getChunk($renewSpecialTpl, $phs);
            } else {
                $phs['name'] = $license->getOne('Edition')->getFullName();
                $phs['subscription_expiry'] = $license->getSubsriptionExpiry();
                $phs['new_subscription_expiry'] = strftime('%Y-%m-%d', strtotime('+1 year', strtotime($license->get('subscription_expiry'))));
                $phs['renew_price'] = $renewPrice;
                $phs['renew_price_factor'] = $renewPriceFactor;
                $phs['details_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'details', 'license' => $license->get('id')));
                return $modisv->getChunk($renewTpl, $phs);
            }
        }
        break;

    case 'upgrade':
        // get license
        $license = $modx->getObject('miLicense', array('user' => $user->get('id'), 'id' => $_REQUEST['license']));
        if (!$license)
            return "License #{$_REQUEST['license']} not found.";

        // get upgrade related staff
        $edition = $license->getOne('Edition');
        $upgradeEdition = $edition->getUpgradeEdition();
        if (!$upgradeEdition)
            return 'There are no upgrades available at this time.';

        $specialLicense = !in_array($license->get('type'), array('Single User License', 'Single Developer License', 'Single Server License'));
        $upgradePrice = round($upgradeEdition->get('price') * $upgradePriceFactor / 100, 2);

        if (!empty($_POST)) {
            if ($specialLicense)
                return "Special license #{$license->get('id')} can't be upgraded online.";

            if (!$license->isSubscriptionExpired()) {
                if (!$license->upgrade($upgradeEdition)) {
                    $modx->log(modX::LOG_LEVEL_ERROR, "[miLicense] An error occured while trying to upgrade the license: " . print_r($license->toArray(), true));
                    return "An error occured while trying to upgrade the license. Please contact our support team for help.";
                }
                $phs = $license->toArray();
                $phs['details_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'details', 'license' => $license->get('id')));
                return $modisv->getChunk($upgradeSuccessTpl, $phs);
            } else {
                $l = array();
                $l['name'] = sprintf('%s %s-%s  Upgrade', $license->getProduct()->get('name'), $license->getRelease()->get('name'), $upgradeEdition->getOne('Release')->get('name'));
                $l['unit_price'] = $upgradePrice;
                $l['quantity'] = $license->get('quantity');
                $l['action'] = 'upgrade';
                $l['license'] = $license->get('id');
                $l['edition'] = $upgradeEdition->get('id');
                $modisv->shoppingCart()->addItem($l);
                return $modx->sendRedirect($modx->makeUrl($shoppingCartResourceId));
            }
        } else {
            // set place holders
            $phs = $license->toArray();
            if ($specialLicense) {
                return $modisv->getChunk($upgradeSpecialTpl, $phs);
            } else {
                $phs['name'] = $license->getOne('Edition')->getFullName();
                $phs['subscription_expired'] = $license->isSubscriptionExpired();
                $phs['upgrade_price'] = $license->isSubscriptionExpired() ? $upgradePrice : 0;
                $phs['upgrade_price_factor'] = $upgradePriceFactor;
                $phs['upgrade_to'] = $upgradeEdition->getFullName();
                $phs['details_url'] = $modx->makeUrl($modx->resource->get('id'), '', array('action' => 'details', 'license' => $license->get('id')));
                return $modisv->getChunk($upgradeTpl, $phs);
            }
        }
        break;

    default:
        $modx->log(modX::LOG_LEVEL_ERROR, "[miLicense] Invalid action '{$action}'.");
        return '';
}
