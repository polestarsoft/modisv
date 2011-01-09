<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miticket.class.php');
class miTicket_mysql extends miTicket {}
?>