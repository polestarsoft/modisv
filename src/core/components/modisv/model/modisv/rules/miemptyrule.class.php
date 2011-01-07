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
 * The field being validated must be empty.
 *
 * @package modisv
 */
require_once MODX_CORE_PATH . 'xpdo/validation/xpdovalidator.class.php';

class miEmptyRule extends xPDOValidationRule {

    public function __construct(& $validator, $field, $name) {
        parent::__construct($validator, $field, $name, 'The field \'' . $field . '\' should be empty.');
    }

    public function isValid($value, array $options = array()) {
        $when = isset($options['when']) ? $options['when'] : 'all';
        if (!in_array($when, array('all', 'new', 'update'))) {
            $this->validator->addMessage($this->field, $this->name, 'Invalid condition.');
            return false;
        }

        $obj = & $this->validator->object;
        if (!empty($value)) {
            if ($obj->isNew() && $when != 'update' || !$obj->isNew() && $when != 'new') {
                $this->validator->addMessage($this->field, $this->name, $this->message);
                return false;
            }
        }
        return true;
    }

}
