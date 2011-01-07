<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miProduct']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_products',
  'fields' => 
  array (
    'name' => '',
    'alias' => '',
    'logo_path' => '',
    'desktop_application' => 1,
    'short_description' => '',
    'description' => '',
    'overview_url' => '',
    'download_url' => '',
    'order_url' => '',
    'sort_order' => 0,
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
    'alias' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'logo_path' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'desktop_application' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'default' => 1,
    ),
    'short_description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'overview_url' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'download_url' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'order_url' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'sort_order' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'default' => 0,
    ),
  ),
  'composites' => 
  array (
    'Releases' => 
    array (
      'class' => 'miRelease',
      'local' => 'id',
      'foreign' => 'product',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Clients' => 
    array (
      'class' => 'miClient',
      'local' => 'id',
      'foreign' => 'product',
      'cardinality' => 'many',
      'owner' => 'local',
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
      'alias' => 
      array (
        'aliasNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
        'uniqueAlias' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miUniqueRule',
        ),
      ),
      'overview_url' => 
      array (
        'ovuNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'download_url' => 
      array (
        'duNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'order_url' => 
      array (
        'ouNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'short_description' => 
      array (
        'sdNotEmpty' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
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
    ),
  ),
);
