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
 * Coupons that can be used in shopping cart.
 *
 * @package modisv
 */
class miCoupon extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function isValid() {
        $validFrom = $this->get('valid_from');
        $validTo = $this->get('valid_to');

        return ($this->get('enabled') &&
        $this->get('used') < $this->get('quantity') &&
        (empty($validFrom) || strtotime($validFrom) <= time()) &&
        (empty($validTo) || strtotime($validTo) >= time()));
    }

    public function getDiscount(miOrderItem $orderItem) {
        $discount = 0;
        if ($this->isValid()) {
            if ($this->isAppliable($orderItem)) {
                if ($this->get('discount_in_percent'))
                    $discount = $this->get('discount') / 100 * $orderItem->getTotal();
                else
                    $discount = $this->get('discount');
            }
        }
        return round(min($discount, $orderItem->getTotal()), 2);
    }

    public function isAppliable(miOrderItem $orderItem) {
        $editions = str_replace(' ', '', $this->get('editions'));
        $actions = str_replace(' ', '', $this->get('actions'));

        if (!empty($editions)) {
            if (!in_array($orderItem->get('edition'), explode(',', $editions))) {
                return false;
            }
        }

        if (!empty($actions)) {
            if (!in_array($orderItem->get('edition'), explode(',', $actions))) {
                return false;
            }
        }

        return true;
    }

}