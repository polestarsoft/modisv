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
 * Handles removal of orders & licenses if a User is deleted.
 *
 * @package modisv
 */
$modisv = $modx->getService('modisv', 'modISV', $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/modisv/', $scriptProperties);
$modisv->initialize();

switch ($modx->event->name) {
    case 'OnUserRemove':
        $user = $scriptProperties['user'];
        // remove licenses
        $licenses = $modx->getCollection('miLicense', array('user' => $user->get('id')));
        foreach ($licenses as $l) {
            $l->remove();
        }
        // remove orders
        $orders = $modx->getCollection('miOrder', array('user' => $user->get('id')));
        foreach ($orders as $o) {
            $o->remove();
        }
        break;
}
return;