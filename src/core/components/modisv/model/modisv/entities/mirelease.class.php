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
 * Represents a release of a software product, e.g. v1.0, v2.0.
 *
 * @package modisv
 */
class miRelease extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function getFullName() {
        return $this->getOne('Product')->get('name') . ' ' . $this->get('name');
    }

    public function getPreviousRelease() {
        $c = $this->xpdo->newQuery('miRelease');
        $c->where(array(
            'product' => $this->get('product'),
            'version:<' => $this->get('version'),
        ));
        $c->sortby('version', 'DESC');
        $c->limit(1);
        return $this->xpdo->getObject('miRelease', $c);
    }

    public function getNextRelease() {
        $c = $this->xpdo->newQuery('miRelease');
        $c->where(array(
            'product' => $this->get('product'),
            'version:>' => $this->get('version'),
        ));
        $c->sortby('version', 'ASC');
        $c->limit(1);
        return $this->xpdo->getObject('miRelease', $c);
    }

    public function getEdition($name) {
        $c = $this->xpdo->newQuery('miEdition');
        $c->where(array(
            'release' => $this->get('id'),
            'name' => $name,
        ));
        return $this->xpdo->getObject('miEdition', $c);
    }

    public function getFiles($customersOnly = false) {
        return $this->xpdo->getCollection('miFile', array('release' => $this->get('id'), 'customers_only' => $customersOnly));
    }

    public function getUpdates() {
        $c = $this->xpdo->newQuery('miUpdate');
        $c->where(array('release' => $this->get('id')));
        $c->sortby('version', 'DESC');
        return $this->xpdo->getCollection('miUpdate', $c);
    }

    public function isUpgradeAvailable() {
        $count = $this->xpdo->getCount('miRelease', array('product' => $this->get('product'), 'version:>' => $this->get('version'), 'beta' => false));
        return ($count > 0);
    }

    public function getDefaultLicenseType() {
        $t = $this->get('licensing_mode'); // per_user
        $t = substr($t, strlen('per_')); // user
        return 'Single ' . ucfirst($t) . ' License'; // Single User License
    }

    public function save($cacheFlag = null) {
        if ($this->isNew())
            $this->set('createdon', time());

        return parent::save($cacheFlag);
    }

}

