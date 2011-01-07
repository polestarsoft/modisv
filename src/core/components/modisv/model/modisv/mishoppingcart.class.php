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
 * Represents the shopping cart.
 *
 * @package modisv
 */
class miShoppingCart {

    public function getOrder() {
        global $modx;

        $orderID = $_SESSION['modisv.shoppingcart'];
        if (empty($orderID))
            return null;
        return $modx->getObject('miOrder', array('id' => $orderID, 'status' => 'pending'));
    }

    public function addItem($item) {
        global $modx;

        $order = $this->getOrder();
        if (!$order) {
            $order = $modx->newObject('miOrder');
            $order->set('status', 'pending');
            // set user if authenticated
            if ($modx->user->isAuthenticated($modx->context->get('key'))) {
                $order->addOne($modx->user);
            }
            $newOrder = true;
        }
        $orderItem = $modx->newObject('miOrderItem');
        $orderItem->fromArray($item);
        $order->addMany($orderItem);
        if (!$order->save()) {
            $modx->log(modX::LOG_LEVEL_ERROR, '[modISV] An error occured while trying to add the order item to cart: ' . print_r($item, true));
        }

        if ($newOrder) {
            $_SESSION['modisv.shoppingcart'] = $order->get('id'); // save cart order id to session
        }
    }

    public function removeItem($index) {
        $order = $this->getOrder();
        if ($order) {
            $items = array_values($order->getMany('Items'));
            $item = $items[$index];
            if ($item)
                $item->remove();
        }
    }

    public function applyCoupon($code) {
        $order = $this->getOrder();
        if (!$order) {
            return false;
        }
        return $order->applyCoupon($code);
    }

    public function getCouponName() {
        $order = $this->getOrder();
        return $order ? $order->getCouponName() : null;
    }

    public function getCouponCode() {
        $order = $this->getOrder();
        return $order ? $order->get('coupon') : null;
    }

    public function getCouponDiscount() {
        $order = $this->getOrder();
        return $order ? $order->getCouponDiscount() : null;
    }

    public function getItems() {
        $items = array();
        $order = $this->getOrder();
        if (!$order) {
            return array();
        }
        return array_values($order->getMany('Items'));
    }

    public function getTotal() {
        $order = $this->getOrder();
        return $order ? $order->getTotal() : null;
    }

    public function getCheckoutForm() {
        $paypal = new miPaypal();
        return $paypal->getCheckoutForm($this->getOrder());
    }

}