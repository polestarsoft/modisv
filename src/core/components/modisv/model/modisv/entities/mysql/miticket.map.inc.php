<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miTicket']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_tickets',
  'fields' => 
  array (
    'guid' => '',
    'priority' => 3,
    'topic' => 'question',
    'product' => 0,
    'author_name' => '',
    'author_email' => '',
    'watchers' => '',
    'subject' => '[no subject]',
    'note' => '',
    'target_version' => 'unplanned',
    'status' => 'open',
    'source' => 'other',
    'ip' => '',
    'overdue' => 0,
    'answered' => 0,
    'dueon' => NULL,
    'reopenedon' => NULL,
    'closedon' => NULL,
    'lastmessageon' => NULL,
    'lastresponseon' => NULL,
    'createdon' => NULL,
    'updatedon' => NULL,
  ),
  'fieldMeta' => 
  array (
    'guid' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'priority' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 3,
      'index' => 'index',
    ),
    'topic' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'question\',\'problem\',\'suggestion\',\'task\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'question',
      'index' => 'index',
    ),
    'product' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'author_name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'author_email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'watchers' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'fulltext',
    ),
    'subject' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '[no subject]',
    ),
    'note' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'fulltext',
    ),
    'target_version' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => 'unplanned',
    ),
    'status' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'open\',\'closed\'',
      'phptype' => 'string',
      'null' => false,
      'default' => 'open',
      'index' => 'index',
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
    'overdue' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'answered' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'dueon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'index' => 'index',
    ),
    'reopenedon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'closedon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'index' => 'index',
    ),
    'lastmessageon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'lastresponseon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'index' => 'index',
    ),
    'updatedon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
  ),
  'indexes' => 
  array (
    'guid_email' => 
    array (
      'alias' => 'guid_email',
      'unique' => true,
      'columns' => 
      array (
        'guid' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
        'author_email' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Product' => 
    array (
      'class' => 'miProduct',
      'local' => 'product',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'composites' => 
  array (
    'Messages' => 
    array (
      'class' => 'miMessage',
      'local' => 'id',
      'foreign' => 'ticket',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'guid' => 
      array (
        'guidNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'priority' => 
      array (
        'validPriority' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '1',
          'to' => '5',
        ),
      ),
      'topic' => 
      array (
        'topicExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
        ),
      ),
      'product' => 
      array (
        'productExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
          'allownull' => 'true',
        ),
      ),
      'author_email' => 
      array (
        'authorEmailNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'target_version' => 
      array (
        'validTargetVersion' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^(\\d{1,2}\\.\\d{1,2}(\\.\\d{1,5})?|unplanned)$/',
          'message' => 'Invalid target version, must be a valid version number or \'unplanned\'.',
        ),
      ),
      'watchers' => 
      array (
        'validWatchers' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^([^@]+@[a-zA-Z0-9._-]+\\.[a-zA-Z]+(,[^@]+@[a-zA-Z0-9._-]+\\.[a-zA-Z]+)*)?$/',
          'message' => 'Invalid watchers.',
        ),
      ),
      'status' => 
      array (
        'validStatus' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
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
