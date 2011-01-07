<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/mihardwareid.class.php');
class miHardwareID_mysql extends miHardwareID {}
?>