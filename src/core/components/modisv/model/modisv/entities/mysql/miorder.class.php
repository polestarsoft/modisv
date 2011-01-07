<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miorder.class.php');
class miOrder_mysql extends miOrder {}
?>