<?php
/**
 * @package modisv
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/miattachment.class.php');
class miAttachment_mysql extends miAttachment {}
?>