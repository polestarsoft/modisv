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
 * An edition of a software release.
 *
 * @package modisv
 */
class miEdition extends xPDOSimpleObject {

    function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function getFullName() {
        return $this->getOne('Release')->getFullName() . ' ' . $this->get('name');
    }

    public function getUpgradeEdition() {
        $release = $this->getOne('Release');
        $currentRelease = $release->getOne('Product')->getCurrentRelease();
        if ($release->get('id') == $currentRelease->get('id')) // already lastest version?
            return null;

        $edition = $this;
        while ($release && $edition) {
            $edition = self::getCorrespondingEdtionInRelease($release, $edition->get('name'));
            $release = $release->getNextRelease();
        }

        return $edition ? $edition : reset($currentRelease->getMany('Editions'));          // fall back, use the first edition in current release
    }

    private static function getCorrespondingEdtionInRelease(miRelease $release, $editionName) {
        // find in upgrade rules
        $upgradeRules = $release->get('upgrade_rules');
        foreach (explode("\n", $upgradeRules) as $rule) {
            $parts = explode('->', $rule);
            if (count($parts) != 2 || $editionName != trim($parts[0]))
                continue;

            $e = $release->getEdition(trim($parts[1]));
            if ($e)
                return $e;
        }

        // searching editions with the same name
        foreach ($release->getMany('Editions') as $e) {
            if ($e->get('name') === $editionName)
                return $e;
        }

        return null;
    }

}