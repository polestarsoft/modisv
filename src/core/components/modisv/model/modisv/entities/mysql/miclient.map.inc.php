<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miClient']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_clients',
  'fields' => 
  array (
    'name' => '',
    'sort_order' => 100,
    'category' => 'company',
    'logo_path' => '',
    'website' => '',
    'testimonial' => '',
    'product' => 0,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
      'index' => 'index',
    ),
    'sort_order' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'default' => 100,
    ),
    'category' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'company\',\'university\',\'organization\',\'personal\',\'other\'',
      'phptype' => 'string',
      'default' => 'company',
    ),
    'logo_path' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'website' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'testimonial' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
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
          'rule' => 'miUniqueRule',
        ),
      ),
      'logo_path' => 
      array (
        'logoExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miFileExistsRule',
        ),
      ),
      'category' => 
      array (
        'validCategory' => 
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
        ),
      ),
    ),
  ),
);
