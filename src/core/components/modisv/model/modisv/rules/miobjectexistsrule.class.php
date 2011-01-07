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
 * The value of the field being validated indicates a pk of an object, and the object must be valid or null (if the allownull attribute is set to true).
 *
 * @package modisv
 */
require_once MODX_CORE_PATH . 'xpdo/validation/xpdovalidator.class.php';

class miObjectExistsRule extends xPDOValidationRule {

    public function __construct(& $validator, $field, $name) {
        parent::__construct($validator, $field, $name, 'The specified object does not exist.');
    }

    public function isValid($value, array $options = array()) {
        $xpdo = & $this->validator->object->xpdo;
        $obj = & $this->validator->object;

        $class = $options['class'];
        if (empty($class)) { // find the class name in aggregates if not specified
            $aggregates = $xpdo->getAggregates($obj->_class);
            foreach (array_values($aggregates) as $a) {
                if ($a['local'] == $this->field) {
                    $class = $a['class'];
                    break;
                }
            }

            if (empty($class)) { // still not found
                $this->validator->addMessage($this->field, $this->name, 'Class not specified for the validation rule.');
                return false;
            }
        }

        $allowNull = isset($options['allownull']) && $options['allownull'] == 'true';
        if ($allowNull && $value === 0)
            return true;

        if (!$xpdo->getObject($class, $value)) {
            $this->validator->addMessage($this->field, $this->name, $this->message);
            return false;
        }
        return true;
    }

}
