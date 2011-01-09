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
    'response' => 0,
    'path' => '',
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
    'response' => 
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
    'Response' => 
    array (
      'class' => 'miResponse',
      'local' => 'response',
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
      'response' => 
      array (
        'responseExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
          'allownull' => 'true',
        ),
      ),
      'path' => 
      array (
        'pathNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
    ),
  ),
);
