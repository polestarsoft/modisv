<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miupdate.class.php');
class miUpdate_mysql extends miUpdate {}
?>