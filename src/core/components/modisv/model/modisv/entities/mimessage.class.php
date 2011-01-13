<?php

/**
 * @package modisv
 */
class miMessage extends xPDOSimpleObject {

    public function __construct(& $xpdo) {
        parent :: __construct($xpdo);
    }

    public function save($cacheFlag = null) {
        $this->set('updatedon', time());
        if ($this->isNew()) {
            $this->set('createdon', time());
        }

        return parent::save($cacheFlag);
    }

}