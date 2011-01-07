<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miclient.class.php');
class miClient_mysql extends miClient {}
?>