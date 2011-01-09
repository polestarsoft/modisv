<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/mimessage.class.php');
class miMessage_mysql extends miMessage {}
?>