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
 * Represents a software product.
 *
 * @package modisv
 */
class miProduct extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function getCurrentRelease() {
        $c = $this->xpdo->newQuery('miRelease');
        $c->where(array(
            'product' => $this->get('id'),
            'beta' => false,
        ));
        $c->sortby('version', 'DESC');
        $c->limit(1);
        return $this->xpdo->getObject('miRelease', $c);
    }

    public function getReleases() {
        $c = $this->xpdo->newQuery('miRelease');
        $c->where(array('product' => $this->get('id')));
        $c->sortby('version', 'DESC');
        return $this->xpdo->getCollection('miRelease', $c);
    }

}
