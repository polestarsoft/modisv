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
 * The value of the field being validated must fall into the specified range.
 *
 * @package modisv
 */
require_once MODX_CORE_PATH . 'xpdo/validation/xpdovalidator.class.php';

class miRangeRule extends xPDOValidationRule {

    public function isValid($value, array $options = array()) {
        $from = isset($options['from']) ? intval($options['from']) : -2147483647;
        $to = isset($options['to']) ? intval($options['to']) : 2147483647;

        if(!is_numeric($value)) {
            $this->validator->addMessage($this->field, $this->name, 'This field should be a numeric value.');
            return false;
        }

        if ($value < $from || $value > $to) {
            if(!isset($options['from']))
                $this->validator->addMessage($this->field, $this->name, 'This field should be less than ' . $to . '.');
            else if(!isset($options['to']))
                $this->validator->addMessage($this->field, $this->name, 'This field should be greater than ' . $from . '.');
            else
                $this->validator->addMessage($this->field, $this->name, 'This field should be within ' . $from . '-' . $to . '.');
            return false;
        }
        return true;
    }
}
