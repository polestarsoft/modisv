<?php
/**
 * @package modisv
 */
$xpdo_meta_map['miFile']= array (
  'package' => 'modisv.entities',
  'table' => 'modisv_files',
  'fields' => 
  array (
    'name' => '',
    'subtitle' => '',
    'path' => '',
    'icon' => '',
    'guid' => NULL,
    'size' => 0,
    'download_count' => 0,
    'checksum' => '',
    'createdon' => NULL,
    'updatedon' => NULL,
    'requirements' => '',
    'description' => '',
    'members_only' => 1,
    'customers_only' => 1,
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
    'subtitle' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'path' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'default' => '',
    ),
    'icon' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'default' => '',
    ),
    'guid' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'index' => 'index',
    ),
    'size' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'download_count' => 
    array (
      'dbtype' => 'int',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'default' => 0,
    ),
    'checksum' => 
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
    'requirements' => 
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
    'members_only' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'default' => 1,
    ),
    'customers_only' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'attributes' => 'unsigned',
      'default' => 1,
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
      ),
      'path' => 
      array (
        'fileExists' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miFileExistsRule',
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
      'icon' => 
      array (
        'validIcon' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miNotEmptyRule',
        ),
      ),
      'size' => 
      array (
        'validSize' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '0',
        ),
      ),
      'download_count' => 
      array (
        'validDownloadCount' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'miRangeRule',
          'from' => '0',
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
