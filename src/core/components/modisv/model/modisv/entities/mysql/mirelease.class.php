<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/mirelease.class.php');
class miRelease_mysql extends miRelease {}
?>