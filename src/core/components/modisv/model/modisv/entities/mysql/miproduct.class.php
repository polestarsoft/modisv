<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miproduct.class.php');
class miProduct_mysql extends miProduct {}
?>