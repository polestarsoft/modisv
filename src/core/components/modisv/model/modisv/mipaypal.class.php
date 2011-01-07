<?php

/**
 * modISV
 *
 * Copyright 2010 by Weqiang Wang <wenqiang@polestarsoft.com>
 *
 * modISV is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * modISV is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * modISV; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package modisv
 */

/**
 * A class to handle paypal transactions.
 *
 * @package modisv
 */
class miPaypal {

    private function sandboxMode() {
        global $modx;
        return (bool) $modx->context->getOption('modisv.paypal_sandbox', false);
    }

    public function getCheckoutUrl($order, $ipnUrl, $returnUrl) {
        global $modx;

        $paypalBusiness = $modx->context->getOption('modisv.paypal_business');
        if (empty($paypalBusiness)) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] Paypal business not spcified.');
            return '';
        }

        // the payment url
        $url = $this->sandboxMode() ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

        // general parameters
        $url .= '?cmd=_cart';
        $url .= '&upload=1';
        $url .= '&business=' . $paypalBusiness;
        $url .= '&currency_code=' . $modx->context->getOption('modisv.paypal_currency', 'USD');
        $url .= '&address_override=0';
        $url .= '&invoice=' . $order->get('guid');
        $url .= '&discount_amount_cart=' . $order->getCouponDiscount();
        $url .= '&notify_url=' . urlencode($ipnUrl);
        $url .= '&return=' . urlencode($returnUrl);

        // user contact parameters
        $user = $modx->user;
        if ($user->isAuthenticated($modx->context->get('key')) && $user->getOne('Profile')) {
            $url .= '&address1=' . urlencode(miUser::get($user, 'address'));
            $url .= '&city=' . urlencode(miUser::get($user, 'city'));
            $url .= '&country=' . urlencode(miUser::get($user, 'country'));
            $url .= '&email=' . urlencode(miUser::get($user, 'email'));
            $names = explode(' ', miUser::get($user, 'fullname'), 2);
            if (count($names) == 2) {
                $url .= '&first_name=' . urlencode($names[0]);
                $url .= '&last_name=' . urlencode($names[1]);
            }
            $url .= '&zip=' . urlencode(miUser::get($user, 'zip'));
            $url .= '&state=' . urlencode(miUser::get($user, 'state'));
            $phone = preg_replace('/\D/', '', miUser::get($user, 'phone'));
            if (miUser::get($user, 'country') == 'US') {
                $url .= '&night_phone_a=' . urlencode(substr($phone, 0, 3));
                $url .= '&night_phone_b=' . urlencode(substr($phone, 3, 3));
                $url .= '&night_phone_c=' . urlencode(substr($phone, 6, 4));
            } else {
                //TODO: there should be more elegant processing method about the phone number
                $url .= '&night_phone_b=' . $phone;
            }
        }

        // items parameters
        $i = 1;
        foreach ($order->getMany('Items') as $item) {
            $url .= '&item_name_' . $i . '=' . urlencode($item->get('name'));
            $url .= '&amount_' . $i . '=' . urlencode($item->get('unit_price'));
            $url .= '&quantity_' . $i . '=' . urlencode($item->get('quantity'));
            $i++;
        }

        return $url;
    }

    public function notify($params) {
        global $modx;

        // validate the ipn
        $req = 'cmd=_notify-validate';
        foreach ($params as $key => $value) {
            $value = urlencode($value);
            $req .= '&' . $key . '=' . $value;
        }
        $host = $this->sandboxMode() ? 'ssl://www.sandbox.paypal.com' : 'ssl://www.paypal.com';
        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen($host, 443, $errno, $errstr, 30);
        if (!$fp) {
            return false;
        }
        fputs($fp, $header . $req);
        $res = '';
        while (!feof($fp)) {
            $res = fgets($fp);
        }
        fclose($fp);

        // invalid ipn
        if ($res != "VERIFIED") {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] Paypal ipn validation failed: ' . print_r($params, true));
            return false;
        }

        if ($params['business'] != $modx->context->getOption('modisv.paypal_business')) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The ipn message is not for us. Business: '{$params['business']}'.");
            return false;
        }

        // validate the transaction
        if ($params['payment_status'] == 'Completed') {
            return $this->notifyCompleted($params);
        } else {
            // TODO: we need to handle Refunded/Reversed too.
            return false;
        }
    }

    private function notifyCompleted($params) {
        global $modx;

        // validate the order
        $order = $modx->getObject('miOrder', array('guid' => $params['invoice']));
        if (!$order) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The order #{$params['invoice']} not found.");
            return false;
        }
        if ($order->get('status') != 'pending') {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The order #{$params['invoice']} already processed.");
            return false;
        }
        if ($order->get('status') != 'pending') {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The amounts do not match. Order ID: #{$params['invoice']}.");
            return false;
        }

        // create user account
        $user = $modx->getObject('modUser', array('username' => $params['payer_email']));
        if (!$user) {
            // create user
            $user = $modx->newObject('modUser');
            $user->set('username', $params['payer_email']);
            $user->set('active', 1);
            $password = $user->generatePassword();
            $user->set('password', md5($password));
            $user->set('cachepwd', $password);
            if (!$user->save()) {
                $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to save the user ' . print_r($user->toArray(), true));
                return false;
            }

            $profile = $modx->newObject('modUserProfile');
            $profile->set('internalKey', $user->get('id'));
            $profile->set('fullname', $params['first_name'] . ' ' . $params['last_name']);
            $profile->set('email', $params['payer_email']);
            $profile->set('phone', $params['contact_phone'] ? : '');
            $profile->set('address', $params['address_street']);
            $profile->set('country', $params['address_country_code']);
            $profile->set('city', $params['address_city']);
            $profile->set('state', $params['address_state']);
            $profile->set('zip', $params['address_zip']);
            if (isset($params['payer_business_name'])) {
                $profile->set('extended', array('company' => $params['payer_business_name']));
            }
            if (!$profile->save()) {
                $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to save the profile ' . print_r($profile->toArray(), true));
                return false;
            }
        }

        // set usergroup
        $usergroup = $modx->context->getOption('modisv.user_group');
        if (!empty($usergroup) && !$user->isMember($usergroup)) {
            if (!$user->joinGroup($usergroup)) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] Can't add user '{$user->get('username')}' to group.");
                return false;
            }
        }

        // change order status
        $order->addOne($user);
        $order->set('status', 'complete');
        $order->set('payment_processor', 'paypal');
        $order->set('reference_number', $params['txn_id']);
        $order->set('test_mode', $params['test_ipn'] === '1');
        if (!$order->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occured while trying to save the order #{$order->get('id')}.");
            return false;
        }

        // fulfil order
        $fulfiller = new miOrderFulfiller();
        if ($fulfiller->fulfillOrder($order, $user)) {
            // send notification to sales
            $phs = $order->toArray();
            $phs['total'] = $order->getTotal();
            $phs['details_url'] = miUtilities::getManagerUrl('modisv', 'index', "&sa=order&id={$order->get('id')}");
            $phs['user'] = miUser::get($user, 'email');
            $phs['items'] = '';
            foreach ($order->getMany('Items') as $item) {
                $phs['items'] .= $item->get('name') . '  ($' . $item->get('unit_price') . ' x' . $item->get('quantity') . ')';
            }
            $modx->modisv->sendEmail(
                    $modx->context->getOption('modisv.sales_email'),
                    sprintf('New Order Received (ID: #%d, User: %s)', $order->get('id'), miUser::get($user, 'email')),
                    $modx->modisv->getChunk('miOrderNotification', $phs)
            );
            return true;
        }

        return false;
    }

}

