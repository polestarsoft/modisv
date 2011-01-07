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
 * A class to generate order messages.
 *
 * @package modisv
 */
class miOrderMessageBuilder {

    public function build(PHPMailer $mail, miOrder $order, modUser $user) {
        // setup
        global $modx;
        $this->modx = $modx;
        $this->mail = $mail;

        $this->order = $order;
        $this->user = $user;

        $this->newLicenses = array();
        $this->upgradeLicenses = array();
        $this->renewLicenses = array();
        foreach ($order->getMany('Items') as $item) {
            switch ($item->get('action')) {
                case 'license':
                    $this->newLicenses[] = $this->modx->getObject('miLicense', $item->get('license'));
                    break;
                case 'upgrade':
                    $this->upgradeLicenses[] = $this->modx->getObject('miLicense', $item->get('license'));
                    break;
                case 'renew':
                    $this->renewLicenses[] = $this->modx->getObject('miLicense', $item->get('license'));
                    break;
            }
        }

        // build
        $this->buildSubject();
        $this->buildAddress();
        $this->buildHeader();

        if (!empty($this->newLicenses)) {
            $this->buildLicenseInfo(false);
        } else if (!empty($this->upgradeLicenses)) {
            $this->buildLicenseInfo(true);
        } else if (!empty($this->renewLicenses)) {
            $this->buildRenewInfo();
        } else {
            $this->buildUnknownActionInfo();
        }

        $this->buildLoginInfo();
        $this->buildPaymentInfo();
        $this->buildFooter();
    }

    private function buildSubject() {
        $this->mail->Subject = sprintf('%s - Order Information', $this->modx->getOption('site_name'));
    }

    private function buildAddress() {
        $this->mail->AddAddress($this->user->get('username'));
        $this->mail->AddReplyTo($this->modx->context->getOption('modisv.sales_email'));
        $this->mail->From = $this->modx->context->getOption('modisv.sales_email');
        $this->mail->FromName = null;
        $this->mail->Sender = $this->modx->context->getOption('modisv.sales_email');
    }

    private function buildHeader() {
        $this->mail->Body .= sprintf("Dear %s,\n\n", miUser::get($this->user, 'fullname'));
    }

    private function buildLicenseInfo($upgrade) {
        $this->mail->Body .= $upgrade ? 'Thank you for your upgrade. ' : 'Thank you for purchasing our product. ';
        $licenses = $upgrade ? $this->upgradeLicenses : $this->newLicenses;
        $codeLicenses = array_filter($licenses, create_function('$l', 'return $l->getRelease()->get("licensing_method") != "file";'));
        $fileLicenses = array_filter($licenses, create_function('$l', 'return $l->getRelease()->get("licensing_method") == "file";'));

        // license code
        $licenseName = miUser::getLicenseName($this->user);
        if (count($codeLicenses) == 1) {
            $this->mail->Body .= "Provided below is important information about your license.\n\n";
            $this->mail->Body .= sprintf("Your license name is: %s\n", $licenseName);
            $license = reset($codeLicenses);
            $this->mail->Body .= sprintf("Your license code is: %s\n", $license->get('code'));
        } else if (count($codeLicenses) > 0) {
            $this->mail->Body .= "Provided below is important information about your licenses.\n\n";
            $this->mail->Body .= sprintf("Your license name is: %s\n", $licenseName);
            $this->mail->Body .= "Your license codes are:\n";
            foreach ($codeLicenses as $l) {
                $this->mail->Body .= sprintf("    %s (for %s)\n", $l->get('code'), $l->getOne('Edition')->getFullName());
            }
        }

        // license file
        if (count($fileLicenses) > 0) {
            $this->mail->Body .= "Attached to this email you'll find your license file, which you can use to convert the trial version of our product to full version.\n\n";
            $license = reset($fileLicenses);
            if ($license->getProduct()->get('desktop_application')) {
                $this->mail->Body .= "To register using the license file:\n";
                $this->mail->Body .= "1. Save the license file to your local hard drive.\n";
                $this->mail->Body .= "2. Open the trial version of our product.\n";
                $this->mail->Body .= "3. Click on the Help menu, and then on the Register menu item.\n";
                $this->mail->Body .= "4. On the dialog that pops up, browse to the license file.\n";
                $this->mail->Body .= "5. A message should be displayed showing that the product has been registered.\n";
            } else {
                $this->mail->Body .= "To register using the license file:\n";
                $this->mail->Body .= "1. Save the license file to your local hard drive.\n";
                $this->mail->Body .= "2. Copy the license file (license.xml) into the application installation folder.\n";
            }

            // create attachment
            foreach ($fileLicenses as $l) {
                $filename = $l->getProduct()->get('alias') . '.lic';
                $this->mail->AddStringAttachment($l->get('code'), $filename, 'base64', 'text/plain');
            }
        }
    }

    private function buildRenewInfo() {
        $this->mail->Body .= "Thank you for renewing your subscription. Below is listed your current subscription status.\n\n";
        $i = 1;
        foreach ($this->renewLicenses as $l) {
            if (count($this->renewLicenses) > 1)
                $this->mail->Body .= sprintf("------------------------Maintainance Subscription #%d------------------------\n", $i);
            $this->mail->Body .= sprintf("License:         %s\n", $l->getName());
            $this->mail->Body .= sprintf("Quantity:        %d\n", $l->get('quantity'));
            $this->mail->Body .= sprintf("Start Date:      %s\n", $l->get('createdon', '%Y-%m-%d'));
            $this->mail->Body .= sprintf("Expiration Date: %s\n\n", $l->getSubsriptionExpiry());
            $i++;
        }
    }

    private function buildUnknownActionInfo() {
        $this->mail->Body .= "Thank you for your payment.\n\n";
    }

    private function buildLoginInfo() {
        $password = $this->user->get('cachepwd');
        $this->user->set('cachepwd', '');
        $this->user->save();

        $this->mail->Body .= "\nFor details on your licenses/subscriptions, please access your account.\n";
        $this->mail->Body .= sprintf("URL:         %s\n", $this->modx->makeUrl($this->modx->context->getOption('modisv.account_page'), '', '', 'full'));
        $this->mail->Body .= sprintf("Login Email: %s\n", $this->user->get('username'));
        if (!empty($password)) {    // new user
            $this->mail->Body .= sprintf("Password:    %s\n", $password);
            $this->mail->Body .= "We recommend changing this password after the first access to your account.\n";
        } else {
            $this->mail->Body .= "Password:    [******]\n";
        }
    }

    private function buildPaymentInfo() {
        $this->mail->Body .= sprintf("\nThe payment details of your order (#%s) are listed below.\n\n", $this->order->get('guid'));
        $items = $this->order->getMany('Items');
        $itemLen = array_reduce($items, create_function('$m,$i', 'return $m >= strlen($i->get("name")) ? $m : strlen($i->get("name"));'), 36);
        $quantityLen = 7;
        $priceLen = 14;
        $totalLen = 13;

        $this->mail->Body .= $this->orderItemRow(array('Item', 'Qty', 'Unit Price', 'Sub-Total'), array($itemLen, $quantityLen, $priceLen, $totalLen));
        $this->mail->Body .= str_repeat('-', $itemLen + $quantityLen + $priceLen + $totalLen) . "\n";
        foreach ($items as $i) {
            $this->mail->Body .= $this->orderItemRow(array($i->get('name'), $i->get('quantity'), '$' . $i->get('unit_price'), '$' . $i->getTotal()), array($itemLen, $quantityLen, $priceLen, $totalLen));
        }
        if ($this->order->getCouponDiscount() > 0)
            $this->mail->Body .= $this->orderItemRow(array($this->order->getCouponName(), '', '', -$this->order->getCouponDiscount()), array($itemLen, $quantityLen, $priceLen, $totalLen));
        $this->mail->Body .= str_repeat('-', $itemLen + $quantityLen + $priceLen + $totalLen) . "\n";
        $this->mail->Body .= $this->orderItemRow(array('', '', 'Total:', '$' . $this->order->getTotal()), array($itemLen, $quantityLen, $priceLen, $totalLen));
    }

    private function orderItemRow($cols, $lens) {
        return str_pad($cols[0], $lens[0]) . str_pad($cols[1], $lens[1], ' ', STR_PAD_LEFT) . str_pad($cols[2], $lens[2], ' ', STR_PAD_LEFT) . str_pad($cols[3], $lens[3], ' ', STR_PAD_LEFT) . "\n";
    }

    private function buildFooter() {
        $this->mail->Body .= sprintf("\nIf you have any questions, please don't hesitate to contact us at: %s\n\n", $this->modx->context->getOption('modisv.support_email'));
        $this->mail->Body .= "Best regards,\n";
        $this->mail->Body .= sprintf("The %s Team\n", $this->modx->getOption('site_name'));
        $this->mail->Body .= sprintf("%s\n\n\n", $this->modx->getOption('site_url'));
    }

}
