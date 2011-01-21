<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miTicketFetch']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_ticket_fetches',
  'fields' => 
  array (
    'name' => '',
    'last_fetch' => NULL,
    'last_error' => NULL,
    'errors' => '0',
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'last_fetch' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'last_error' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'errors' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '0',
    ),
  ),
);
