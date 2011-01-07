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
 * A class that has static utilities functions.
 *
 * @package modisv
 */
class miUtilities {

    public static function sendDownload($file, $filename = '', $string = false) {
        global $modx;

        if ($string) {   // $file is text content
            $len = strlen($file);
            if (empty($filename)) {
                $filename = 'file';
            }
        } else {
            $file = MODX_BASE_PATH . $file;
            if (!file_exists($file)) {
                $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] The file to download '{$file}' does not exist.");
                return false;
            }
            $len = filesize($file);
            if (empty($filename)) {
                $filename = basename($file);
            }
        }

        //Begin writing headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $filename . ";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $len . ';');
        flush();

        if ($string) {
            echo $file;
        } else {
            @readfile($file);
        }
        exit;
    }

    public static function getManagerUrl($namespace, $controller, $args = '') {
        global $modx;

        $action = $modx->getObject('modAction', array('namespace' => $namespace, 'controller' => $controller));
        if (!$action) {
            $modx->log(modX::LOG_LEVEL_ERROR, "[modISV] Manager action {$namespace}:{$controller} not found");
            return false;
        }

        return $modx->getOption('site_url') . $modx->getOption('manager_url') . '?a=' . $action->get('id') . $args;
    }

    public static function generateRandomId($length = 8, $digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') {
        $id = '';
        for ($i = 0; $i < $length; $i++) {
            $id .= substr($digits, mt_rand(0, strlen($digits) - 1), 1);
        }
        return $id;
    }

    public static function setGuid(xPDOObject $object, $field = 'guid', $length = 8) {
        if (!$object)
            return false;

        $class = $object->_class;

        // ten chances to generate a unique guid
        for ($i = 0; $i < 10; $i++) {
            $guid = self::generateRandomId($length);
            if (!$object->xpdo->getObject($class, array($field => $guid))) {
                $object->set($field, $guid);
                return true;
            }
        }
        return false;
    }

}

?>
