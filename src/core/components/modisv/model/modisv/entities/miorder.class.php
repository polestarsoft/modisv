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
 * Represents an order.
 *
 * @package modisv
 */
class miOrder extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function save($cacheFlag = null) {
        $this->set('updatedon', time());
        if ($this->isNew()) {
            $this->set('createdon', time());
            miUtilities::setGuid($this);
        }

        return parent::save($cacheFlag);
    }

    public function remove(array $ancestors = array()) {
        $removed = parent :: remove($ancestors);

        // remove licenses
        $licenses = $this->xpdo->getCollection('miLicense', array('order' => $this->get('id')));
        foreach ($licenses as $license)
            $license->remove();

        return $removed;
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->getMany('Items') as $item)
            $total += $item->getTotal();
        $total -= $this->getCouponDiscount();

        // we won't like to pay our customer
        if ($total < 0)
            $total = 0;

        return round($total, 2);
    }

    public function applyCoupon($code) {
        $code = trim($code);
        if (empty($code)) { // clear coupon
            $this->set('coupon', null);
            $this->save();
            return true;
        }

        $coupon = $this->xpdo->getObject('miCoupon', array('code' => $code));
        if ($coupon && $coupon->isValid()) {
            $this->set('coupon', $code);
            $this->save();
            return true;
        }
        return false;
    }

    public function getCouponName() {
        $couponCode = $this->get('coupon');
        if (empty($couponCode))
            return null;
        $coupon = $this->xpdo->getObject('miCoupon', array('code' => $couponCode));
        if (!$coupon)
            return null;
        return $coupon->get('name');
    }

    public function getCouponDiscount() {
        $discount = 0;
        $couponCode = $this->get('coupon');
        if (!empty($couponCode)) {
            $coupon = $this->xpdo->getObject('miCoupon', array('code' => $couponCode));
            if ($coupon && $coupon->isValid()) {
                foreach ($this->getMany('Items') as $item) {
                    $discount += $coupon->getDiscount($item);
                }
            }
        }
        return round($discount, 2);
    }

}
