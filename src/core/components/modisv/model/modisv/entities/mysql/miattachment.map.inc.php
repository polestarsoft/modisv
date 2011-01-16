<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miAttachment']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_attachments',
  'fields' => 
  array (
    'ticket' => 0,
    'message' => 0,
    'path' => '',
    'name' => '',
    'size' => 0,
    'createdon' => NULL,
    'updatedon' => NULL,
  ),
  'fieldMeta' => 
  array (
    'ticket' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'message' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'path' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'name' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'size' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'updatedon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
  ),
  'aggregates' => 
  array (
    'Ticket' => 
    array (
      'class' => 'miTicket',
      'local' => 'ticket',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Message' => 
    array (
      'class' => 'miMessage',
      'local' => 'message',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'ticket' => 
      array (
        'ticketExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
        ),
      ),
      'message' => 
      array (
        'messageExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
          'allownull' => 'true',
        ),
      ),
      'path' => 
      array (
        'fileExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miFileExistsRule',
        ),
      ),
    ),
  ),
);
