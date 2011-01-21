<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miticketfetch.class.php');
class miTicketFetch_mysql extends miTicketFetch {}
?>