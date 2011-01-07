<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miCoupon']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_coupons',
  'fields' => 
  array (
    'name' => '',
    'code' => '',
    'discount' => 0,
    'discount_in_percent' => 1,
    'enabled' => 1,
    'quantity' => 0,
    'used' => 0,
    'editions' => '',
    'actions' => '',
    'valid_from' => NULL,
    'valid_to' => NULL,
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
    'code' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
      'index' => 'index',
    ),
    'discount' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '5,2',
      'phptype' => 'float',
      'default' => 0,
    ),
    'discount_in_percent' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'default' => 1,
    ),
    'enabled' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'default' => 1,
    ),
    'quantity' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'used' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'editions' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'actions' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'valid_from' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
    ),
    'valid_to' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
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
      'code' => 
      array (
        'codeNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
        'uniqueCode' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miUniqueRule',
        ),
      ),
      'discount' => 
      array (
        'validDiscount' => 
        array (
          'from' => '0',
          'to' => '100',
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
        ),
      ),
      'quantity' => 
      array (
        'validQuantity' => 
        array (
          'from' => '0',
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
        ),
      ),
      'used' => 
      array (
        'validUsed' => 
        array (
          'from' => '0',
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
        ),
      ),
    ),
  ),
);
