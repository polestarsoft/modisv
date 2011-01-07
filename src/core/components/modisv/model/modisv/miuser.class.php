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
 * A wrapper class of modUser, than provides functions to handle order/license stuff.
 *
 * @package modisv
 */
class miUser {

    public static function get(modUser $user, $k) {
        $v = $user->get($k); // get modUser property
        if (!isset($v) && $k != 'id' && $user->getOne('Profile')) {
            $v = $user->getOne('Profile')->get($k);   // get profile property
            if (!isset($v)) {
                $extended = $user->getOne('Profile')->get('extended');  // get extended property
                $v = $extended[$k];
            }
        }
        return $v;
    }

    public static function getLicenseName(modUser $user) {

        return self::get($user, 'license_name') ? : self::get($user, 'company') ? : self::get($user, 'fullname');
    }

    public static function getLicenses(modUser $user) {
        return $user->xpdo->getCollection('miLicense', array('user' => $user->get('id')));
    }

    public static function getOrders(modUser $user) {
        return $user->xpdo->getCollection('miOrder', array('user' => $user->get('id')));
    }

    public static function holdLicenseOf(modUser $user, miRelease $release) {
        $licenses  = self::getLicenses($user);
        foreach ($licenses as $l) {
            if ($l->getOne('Edition')->get('release') === $release->get('id')) {
                return true;
            }
        }
        return false;
    }

}
