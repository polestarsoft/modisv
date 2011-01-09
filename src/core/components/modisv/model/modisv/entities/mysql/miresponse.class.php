<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miresponse.class.php');
class miResponse_mysql extends miResponse {}
?>