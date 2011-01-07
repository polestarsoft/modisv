<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/milicense.class.php');
class miLicense_mysql extends miLicense {}
?>