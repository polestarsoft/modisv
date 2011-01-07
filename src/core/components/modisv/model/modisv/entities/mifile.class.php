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
 * A release file of software product.
 *
 * @package modisv
 */
class miFile extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function getFullPath() {
        return MODX_BASE_PATH . $this->get('path');
    }

    public function getFileName() {
        return basename($this->get('path'));
    }

    public function updateFileInfo() {
        $this->set('size', filesize($this->getFullPath()));
        $this->set('checksum', md5_file($this->getFullPath()));
    }

    public function isAvailableForUser(modUser $user) {
        global $modx;
        $authenticated = $user->isAuthenticated($modx->context->get('key'));
        if (!$authenticated) {
            if ($this->get('members_only') || $this->get('customers_only')) {
                return false;
            }
        }

        if ($this->get('customers_only') && !miUser::holdLicenseOf($user, $this->getOne('Release'))) {
            return false;
        }
        return true;
    }

    public function save($cacheFlag = null) {
        $this->set('updatedon', time());

        if ($this->isNew()) {
            $this->set('createdon', time());
            miUtilities::setGuid($this);
        }

        // update file info
        if ($this->isDirty('path'))
            $this->updateFileInfo();

        return parent::save($cacheFlag);
    }

}