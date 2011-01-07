<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miOrder']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_orders',
  'fields' => 
  array (
    'status' => 'pending',
    'guid' => '',
    'coupon' => '',
    'createdon' => NULL,
    'updatedon' => NULL,
    'reference_number' => '',
    'payment_processor' => 'none',
    'test_mode' => 0,
    'payment_method' => '',
    'user' => 0,
  ),
  'fieldMeta' => 
  array (
    'status' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'pending\',\'complete\',\'refunded\',\'charged_back\'',
      'phptype' => 'string',
      'default' => 'pending',
    ),
    'guid' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
      'index' => 'index',
    ),
    'coupon' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
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
    'reference_number' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'payment_processor' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'none\',\'paypal\',\'plimus\',\'regnow\'',
      'phptype' => 'string',
      'default' => 'none',
    ),
    'test_mode' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'payment_method' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'user' => 
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
  'composites' => 
  array (
    'Items' => 
    array (
      'class' => 'miOrderItem',
      'local' => 'id',
      'foreign' => 'order',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'user',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'status' => 
      array (
        'validStatus' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
        ),
      ),
      'guid' => 
      array (
        'guidNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
        'uniqueGuid' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miUniqueRule',
        ),
      ),
      'payment_processor' => 
      array (
        'validPP' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
        ),
      ),
      'user' => 
      array (
        'userExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
          'allownull' => 'true',
        ),
      ),
    ),
  ),
);
