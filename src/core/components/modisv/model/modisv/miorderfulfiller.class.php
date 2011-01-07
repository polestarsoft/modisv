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
 * A class to fulfill orders.
 *
 * @package modisv
 */
class miOrderFulfiller {

    public function fulfillOrder(miOrder& $order, modUser $user, $sendEmail = true) {
        global $modx;

        foreach ($order->getMany('Items') as $item) {
            switch ($item->get('action')) {
                case 'license':
                    if (!$this->createLicense($item, $user))
                        return false;
                    break;
                case 'renew':
                    if (!$this->renewSubscription($item))
                        return false;
                    break;
                case 'upgrade':
                    if (!$this->upgradeLicense($item))
                        return false;
                    break;
            }
        }

        // send order fulfillment email to user
        if ($sendEmail) {
            $mail = $modx->getService('mail', 'mail.modPHPMailer');
            $phpMailer = $mail->mailer;
            $builder = new miOrderMessageBuilder();
            $builder->build($phpMailer, $order, $user);
            $mail->send();
            $mail->reset();
        }

        return true;
    }

    private function createLicense(miOrderItem &$item, modUser $user) {
        global $modx;

        $edition = $modx->getObject('miEdition', $item->get('edition'));
        if (!$edition) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The edition #{$item->get('edition')} specified in order item #{$item->get('id')} does not exist.");
            return false;
        }

        // create license
        $license = $modx->newObject('miLicense');
        $license->addOne($user);
        $license->set('type', $item->get('license_type'));
        $license->set('quantity', $item->get('quantity'));
        $license->set('edition', $item->get('edition'));
        $license->set('order', $item->get('order'));
        $subscription = $edition->getOne('Release')->get('initial_subscription') + $item->get('subscription_months');
        $expiry = new DateTime();
        $expiry->modify('+' . $subscription . 'months');
        $license->set('subscription_expiry', $expiry->format('Y-m-d H:i:s'), 'utc');
        $license->appendLog(sprintf('Created as a result of order #%d.', $item->getOne('Order')->get('id')));
        $license->save();  // save to get id
        $license->generateCode();
        if (!$license->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to save the license: ' . print_r($license->toArray(), true));
            return false;
        }

        // save order item
        $item->set('license', $license->get('id'));
        if (!$item->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] An error occured while trying to save the order item: #{$item->get('id')}");
            return false;
        }

        return $license;
    }

    private function renewSubscription(miOrderItem $item) {
        global $modx;

        $license = $modx->getObject('miLicense', $item->get('license'));
        if (!$license) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The license #{$item->get('license')} specified in order item #{$item->get('id')} does not exist.");
            return false;
        }

        $subscription = $item->get('subscription_months');
        if (!$license->renew($subscription)) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to renew the license: ' . print_r($license->toArray(), true));
            return false;
        }

        return $license;
    }

    private function upgradeLicense(miOrderItem $item) {
        global $modx;

        $license = $modx->getObject('miLicense', $item->get('license'));
        if (!$license) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The license #{$item->get('license')} specified in order item #{$item->get('id')} does not exist.");
            return false;
        }

        $edition = $modx->getObject('miEdition', $item->get('edition'));
        if (!$edition) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The edition #{$item->get('edition')} specified in order item #{$item->get('id')} does not exist.");
            return false;
        }

        if (!$license->upgrade($edition)) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to upgrade the license: ' . print_r($license->toArray(), true));
            return false;
        }

        return $license;
    }

}
