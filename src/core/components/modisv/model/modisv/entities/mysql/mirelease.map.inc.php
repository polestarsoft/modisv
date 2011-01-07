<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miRelease']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_releases',
  'fields' => 
  array (
    'name' => '',
    'version' => '',
    'beta' => 1,
    'changes' => '',
    'createdon' => NULL,
    'licensing_mode' => 'per_user',
    'licensing_method' => 'file',
    'code_generator' => 'miRsaSha1',
    'upgrade_rules' => '',
    'initial_subscription' => 0,
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
    ),
    'version' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'beta' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'default' => 1,
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
    'licensing_mode' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'per_user\',\'per_developer\',\'per_server\'',
      'phptype' => 'string',
      'default' => 'per_user',
    ),
    'licensing_method' => 
    array (
      'dbtype' => 'enum',
      'precision' => '\'file\',\'code\',\'activation\'',
      'phptype' => 'string',
      'default' => 'file',
    ),
    'code_generator' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => 'miRsaSha1',
    ),
    'upgrade_rules' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'initial_subscription' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
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
  'composites' => 
  array (
    'Updates' => 
    array (
      'class' => 'miUpdate',
      'local' => 'id',
      'foreign' => 'release',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Files' => 
    array (
      'class' => 'miFile',
      'local' => 'id',
      'foreign' => 'release',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Editions' => 
    array (
      'class' => 'miEdition',
      'local' => 'id',
      'foreign' => 'release',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Subscriptions' => 
    array (
      'class' => 'miSubscription',
      'local' => 'id',
      'foreign' => 'release',
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
          'rule' => 'miUniqueInParentRule',
          'parentField' => 'product',
        ),
      ),
      'version' => 
      array (
        'validVersion' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^\\d{1,2}\\.\\d{1,2}(\\.\\d{1,5})?$/',
          'message' => 'Invalid version.',
        ),
        'uniqueVersion' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miUniqueInParentRule',
          'parentField' => 'product',
        ),
      ),
      'licensing_mode' => 
      array (
        'validLMO' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
        ),
      ),
      'licensing_method' => 
      array (
        'validLME' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEnumExistsRule',
        ),
      ),
      'upgrade_rules' => 
      array (
        'emptyURWhenNew' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miEmptyRule',
          'when' => 'new',
        ),
        'validUR' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miUpgradeRulesRule',
        ),
      ),
      'initial_subscription' => 
      array (
        'validIS' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '0',
          'to' => '1200',
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
