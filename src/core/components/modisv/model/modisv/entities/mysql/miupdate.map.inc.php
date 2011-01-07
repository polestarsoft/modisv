<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miUpdate']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_updates',
  'fields' => 
  array (
    'version' => '',
    'changes' => '',
    'createdon' => NULL,
    'release' => 0,
  ),
  'fieldMeta' => 
  array (
    'version' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'changes' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'release' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
  'aggregates' => 
  array (
    'Release' => 
    array (
      'class' => 'miRelease',
      'local' => 'release',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'version' => 
      array (
        'validVersion' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^\\d{1,2}\\.\\d{1,2}(\\.\\d{1,5}){0,2}$/',
          'message' => 'Invalid version.',
        ),
        'uniqueVersion' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miUniqueInParentRule',
          'parentField' => 'release',
        ),
      ),
      'release' => 
      array (
        'releaseExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
        ),
      ),
    ),
  ),
);
