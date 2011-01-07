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
 * A software license.
 *
 * @package modisv
 */
class miLicense extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function getUsed() {
        $c = $this->xpdo->newQuery('miHardwareID');
        $c->where(array('license' => $this->get('id')));
        $c->select("COUNT(DISTINCT name)");
        if ($c->prepare() && $c->stmt->execute()) {
            $rows = $c->stmt->fetchAll(PDO::FETCH_COLUMN);
            return (int)reset($rows);
        }
        return 0;
    }

    public function clearHardwareIDs() {
        $hids = $this->getMany('HardwareIDs');
        foreach ($hids as $hid) {
            $hid->remove();
        }
    }

    public function generateCode() {
        global $modx;

        $infos = array();
        $infos['product'] = $this->getProduct()->get('alias');
        $infos['version'] = $this->getRelease()->get('version');
        $infos['edition'] = $this->getOne('Edition')->get('name');
        $infos['type'] = $this->get('type');
        $infos['licensed_to'] = miUser::getLicenseName($this->getOne('User'));
        $infos['quantity'] = $this->get('quantity');
        $infos['license_id'] = $this->get('id');
        $infos['created_on'] = strftime('%Y-%m-%d', strtotime($this->get('createdon')));
        $infos['subscription'] = $this->getSubsriptionExpiry();

        $release = $this->getRelease();
        $product = $this->getProduct();
        $snippet = $modx->getObject('modSnippet', array('name' => $release->get('code_generator')));
        if(!$snippet) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] Code generator snippet '{$release->get('code_generator')}' does not exist.");
            return false;
        }
        $code = $snippet->process($infos);

        // add comment string for license file
        if ($method == 'file') {
            $comment = "#\r\n";
            $comment .= sprintf("# This is a license file for %s\r\n", $release->getFullName());
            $comment .= "#\r\n";

            if ($product->get('desktop_application')) {
                $comment .= "# To register the license, please \r\n";
                $comment .= "#\r\n";
                $comment .= sprintf("# 1. Save this text to a file named %s.lic.\r\n", $product->get('alias'));
                $comment .= sprintf("# 2. Open the trial version of %s.\r\n", $product->get('name'));
                $comment .= "# 3. Click on the Help menu, and then on the Register menu item.\r\n";
                $comment .= "# 4. On the dialog that pops up, browse to the license file.\r\n";
                $comment .= "#\r\n";
            } else {
                $comment .= sprintf("# Please save this text to a file named %s.lic \r\n", $product->get('alias'));
                $comment .= sprintf("# and copy it into %s installation directory \r\n", $product->get('name'));
                $comment .= "# to register the license. \r\n";
                $comment .= "#\r\n";
            }
            $comment .= "# You can download the setup program from:\r\n";
            $comment .= "#\r\n";
            $comment .= sprintf("# %s \r\n", $modx->getOption('site_url'));
            $comment .= "#\r\n";

            $code = $comment . $code;
        }

        $this->set('code', $code);
        return $code;
    }

    public function getName() {
        return sprintf("%s %s, %s", $this->getProduct()->get('name'), $this->getOne('Edition')->get('name'), $this->get('type'));
    }

    public function getRelease() {
        return $this->getOne('Edition')->getOne('Release');
    }

    public function getProduct() {
        return $this->getOne('Edition')->getOne('Release')->getOne('Product');
    }

    public function getSubsriptionExpiry() {
        $expiry = $this->get('subscription_expiry');
        return $this->hasLifetimeSubscription() ? '---' : strftime('%Y-%m-%d', strtotime($expiry));
    }

    public function isSubscriptionExpired() {
        $expiry = new DateTime($this->get('subscription_expiry'));
        return $expiry < new DateTime();
    }

    public function hasLifetimeSubscription() {
        $expiry = new DateTime($this->get('subscription_expiry'));
        return $expiry >= new DateTime('2050-1-1');
    }

    public function save($cacheFlag = null) {
        if ($this->isNew())
            $this->set('createdon', time());

        // add log
        try {
            $updated = '';
            if ($this->isDirty('type'))
                $updated .= 'type=' . $this->get('type') . '; ';
            if ($this->isDirty('quantity'))
                $updated .= 'quantity=' . $this->get('quantity') . '; ';
            if ($this->isDirty('subscription_expiry'))
                $updated .= 'subscription=' . $this->get('subscription_expiry') . '; ';
            if ($this->isDirty('edition')) {
                $edition = $this->getOne('Edition');
                if ($edition)
                    $updated .= 'edition=' . $edition->getFullName() . '; ';
            }
            if ($this->isDirty('user')) {
                $user = $this->getOne('User');
                if ($user)
                    $updated .= 'user=' . $user->get('username') . '; ';
            }
            if (!empty($updated)) { // append log only when there is really something modified
                $this->appendLog('Updated: ' . $updated);
            }
        } catch (Exception $e) {
        }

        return parent::save($cacheFlag);
    }

    public function renew($months) {
        if (!isset($months) || $months <= 0)
            return false;

        $expiry = new DateTime($this->get('subscription_expiry'));
        $expiry->modify('+' . $months . 'months');
        $this->set('subscription_expiry', $expiry->format('Y-m-d H:i:s'), 'utc');
        $this->appendLog(sprintf('Subscription renewed for %d months', $months));
        return $this->save();
    }

    public function upgrade(miEdition $edition) {
        if (empty($edition))
            return false;

        $oldEdition = $this->getOne('Edition');
        $this->addOne($edition);
        $this->generateCode();
        $this->clearHardwareIDs();
        $this->appendLog(sprintf('Upgraded from %s to %s', $oldEdition->getFullName(), $edition->getFullName()));
        return $this->save();
    }

    public function appendLog($text) {
        $log = $this->get('log');
        if (!empty($log) && substr($log, -1) != "\n")
            $log .= "\n";
        $log .= '[' . strftime('%Y-%m-%d %H:%M') . '] ' . $text;
        $this->set('log', $log);
    }

}
