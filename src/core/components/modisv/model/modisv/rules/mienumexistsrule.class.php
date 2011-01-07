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
 * The dbtype of the field being validated must be enum and the value of the field must be a valid enum value.
 *
 * @package modisv
 */
require_once MODX_CORE_PATH . 'xpdo/validation/xpdovalidator.class.php';

class miEnumExistsRule extends xPDOValidationRule {

    public function __construct(& $validator, $field, $name) {
        parent::__construct($validator, $field, $name);
        $this->message = 'Invalid enum value.';
    }

    public function isValid($value, array $options = array()) {
        parent::isValid($value, $options);

        $xpdo = & $this->validator->object->xpdo;
        $obj = & $this->validator->object;
        $class = $obj->_class;  // the object's class name
        $meta = $xpdo->getFieldMeta($class);
        $precision = $meta[$this->field]['precision'];

        if ($meta[$this->field]['dbtype'] != 'enum') {
            $this->validator->addMessage($this->field, $this->name, 'mtEnumExistsRule should only be applied to enum fields.');
            return false;
        }

        if(strpos($precision, '\'' . $value . '\'') === false) {
            $this->validator->addMessage($this->field, $this->name, $this->message);
            return false;
        }
        return true;
    }

}
