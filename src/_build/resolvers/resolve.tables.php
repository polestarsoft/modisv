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
 * Resolve creating db tables
 *
 * @package modisv
 * @subpackage build
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx = & $object->xpdo;
            $modelPath = $modx->getOption('modisv.core_path', null, $modx->getOption('core_path') . 'components/modisv/') . 'model/';
            $modx->addPackage('modisv.entities', $modelPath);

            $manager = $modx->getManager();

            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            $manager->createObjectContainer('miClient');
            $manager->createObjectContainer('miCoupon');
            $manager->createObjectContainer('miEdition');
            $manager->createObjectContainer('miFile');
            $manager->createObjectContainer('miHardwareID');
            $manager->createObjectContainer('miLicense');
            $manager->createObjectContainer('miOrder');
            $manager->createObjectContainer('miOrderItem');
            $manager->createObjectContainer('miProduct');
            $manager->createObjectContainer('miRelease');
            $manager->createObjectContainer('miSubscription');
            $manager->createObjectContainer('miUpdate');
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;