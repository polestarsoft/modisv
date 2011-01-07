<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miLicense']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_licenses',
  'fields' => 
  array (
    'type' => '',
    'quantity' => 0,
    'createdon' => NULL,
    'subscription_expiry' => NULL,
    'code' => '',
    'log' => '',
    'user' => 0,
    'order' => 0,
    'edition' => 0,
  ),
  'fieldMeta' => 
  array (
    'type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'quantity' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'subscription_expiry' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'code' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
      'index' => 'fulltext',
    ),
    'log' => 
    array (
      'dbtype' => 'text',
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
    'order' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'edition' => 
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
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'user',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Order' => 
    array (
      'class' => 'miOrder',
      'local' => 'order',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Edition' => 
    array (
      'class' => 'miEdition',
      'local' => 'edition',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'composites' => 
  array (
    'HardwareIDs' => 
    array (
      'class' => 'miHardwareID',
      'local' => 'id',
      'foreign' => 'license',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'type' => 
      array (
        'typeNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'quantity' => 
      array (
        'validSize' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '1',
        ),
      ),
      'user' => 
      array (
        'userExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
        ),
      ),
      'edition' => 
      array (
        'editionExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
        ),
      ),
      'order' => 
      array (
        'orderExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
          'allownull' => 'true',
        ),
      ),
    ),
  ),
);
