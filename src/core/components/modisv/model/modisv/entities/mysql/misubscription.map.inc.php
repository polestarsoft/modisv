<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miSubscription']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_subscriptions',
  'fields' => 
  array (
    'name' => '',
    'price' => 0,
    'months' => 0,
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
    'months' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
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
      'months' => 
      array (
        'validMonths' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '0',
          'to' => '1200',
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
