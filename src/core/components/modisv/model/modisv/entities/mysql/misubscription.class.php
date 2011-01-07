<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/misubscription.class.php');
class miSubscription_mysql extends miSubscription {}
?>