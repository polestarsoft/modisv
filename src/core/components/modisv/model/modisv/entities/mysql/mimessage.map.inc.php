<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miMessage']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_messages',
  'fields' => 
  array (
    'ticket' => 0,
    'message_id' => '',
    'body' => '',
    'headers' => '',
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
    'message_id' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
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
    'headers' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
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
  ),
  'composites' => 
  array (
    'Attachments' => 
    array (
      'class' => 'miAttachment',
      'local' => 'id',
      'foreign' => 'message',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'message_id' => 
      array (
        'messageIdNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
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
