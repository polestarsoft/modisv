<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miResponse']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_responses',
  'fields' => 
  array (
    'ticket' => 0,
    'message' => 0,
    'body' => '',
    'source' => 'other',
    'ip' => '',
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
    'body' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'fulltext',
    ),
    'source' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'web\',\'email\',\'other\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'other',
    ),
    'ip' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
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
  'composites' => 
  array (
    'Attachments' => 
    array (
      'class' => 'miAttachment',
      'local' => 'id',
      'foreign' => 'response',
      'cardinality' => 'many',
      'owner' => 'local',
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
        ),
      ),
      'body' => 
      array (
        'bodyNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'source' => 
      array (
        'validSource' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
        ),
      ),
    ),
  ),
);
