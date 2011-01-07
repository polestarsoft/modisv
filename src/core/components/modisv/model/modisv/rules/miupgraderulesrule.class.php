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
 * The value of the field being validated must be a valid upgrade rule.
 *
 * @package modisv
 */
require_once MODX_CORE_PATH . 'xpdo/validation/xpdovalidator.class.php';

class miUpgradeRulesRule extends xPDOValidationRule {

    public function isValid($value, array $options = array()) {
        $xpdo = & $this->validator->object->xpdo;
        $release = & $this->validator->object;

        $value = trim($value);
        if (empty($value))
            return true;

        if (!($release instanceof miRelease)) {
            $this->validator->addMessage($this->field, $this->name, 'miUpgradeRulesRule should only be applied to miRelease.');
            return false;
        }

        $prevRelease = $release->getPreviousRelease();
        if (!$prevRelease) {
            $this->validator->addMessage($this->field, $this->name, 'Upgrade rules need not be set for the first release of a product.');
            return false;
        }

        foreach (explode("\n", $value) as $rule) {
            if (!$this->isValidUpgradeRule(trim($rule), $release, $prevRelease))
                return false;
        }

        return true;
    }

    private function isValidUpgradeRule($rule, $release, $prevRelease) {
        $xpdo = & $this->validator->object->xpdo;

        $parts = explode('->', $rule);
        if (count($parts) != 2) {
            $this->validator->addMessage($this->field, $this->name, 'Invalid upgrade rule format.');
            return false;
        }

        $parts = array_map(create_function('$p', 'return trim($p);'), $parts);
        if (!$xpdo->getObject('miEdition', array('name' => $parts[0], 'release' => $prevRelease->get('id'))))  {
            $this->validator->addMessage($this->field, $this->name, "Source edition '{$parts[0]}' not found.");
            return false;
        }
        if (!$xpdo->getObject('miEdition', array('name' => $parts[1], 'release' => $release->get('id')))) {
            $this->validator->addMessage($this->field, $this->name, "Target edition '{$parts[1]}' not found.");
            return false;
        }

        return true;
    }

}
