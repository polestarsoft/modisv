<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miEdition']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_editions',
  'fields' => 
  array (
    'name' => '',
    'price' => 0,
    'description' => '',
    'release' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'price' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '5,2',
      'phptype' => 'float',
      'default' => 0,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
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
      'name' => 
      array (
        'nameNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
        'uniqueName' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miUniqueInParentRule',
          'parentField' => 'release',
        ),
      ),
      'price' => 
      array (
        'validPrice' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^\\d{1,4}(\\.\\d{1,2})?$/',
          'message' => 'Invalid price.',
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
