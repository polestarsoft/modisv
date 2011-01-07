<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miorderitem.class.php');
class miOrderItem_mysql extends miOrderItem {}
?>