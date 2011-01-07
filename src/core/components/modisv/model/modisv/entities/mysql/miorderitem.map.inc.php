<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miOrderItem']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_orderitems',
  'fields' => 
  array (
    'name' => '',
    'unit_price' => 0,
    'quantity' => 0,
    'action' => 'none',
    'subscription_months' => 0,
    'license_type' => '',
    'order' => 0,
    'license' => 0,
    'edition' => 0,
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
    'unit_price' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '5,2',
      'phptype' => 'float',
      'default' => 0,
    ),
    'quantity' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'action' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'none\',\'license\',\'upgrade\',\'renew\'',
      'phptype' => 'string',
      'default' => 'none',
    ),
    'subscription_months' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'license_type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
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
    'license' => 
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
    'Order' => 
    array (
      'class' => 'miOrder',
      'local' => 'order',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'License' => 
    array (
      'class' => 'miLicense',
      'local' => 'license',
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
      ),
      'unit_price' => 
      array (
        'validPrice' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^\\d{1,4}(\\.\\d{1,2})?$/',
          'message' => 'Invalid price.',
        ),
      ),
      'quantity' => 
      array (
        'validQuantity' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '1',
        ),
      ),
      'action' => 
      array (
        'validAction' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
        ),
      ),
      'subscription_months' => 
      array (
        'validSM' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '0',
        ),
      ),
      'license' => 
      array (
        'licenseExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
          'allownull' => 'true',
        ),
      ),
      'edition' => 
      array (
        'editionExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
          'allownull' => 'true',
        ),
      ),
      'order' => 
      array (
        'orderExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miObjectExistsRule',
        ),
      ),
    ),
  ),
);
