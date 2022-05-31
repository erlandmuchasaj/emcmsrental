<?php
App::uses('AppModel', 'Model');
/**
 * Characteristic Model
 *
 * @property CharacteristicTranslation $CharacteristicTranslation
 * @property Property $Property
 */
class Characteristic extends AppModel {
/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Characteristic';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'icon_class';

/**
 * ActsAs
 *
 * @var array
 */
	public $actsAs = array(
		'Upload.Upload' => array(
			'fields' => array(
				'icon'=>'',
			)
		)
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not directly modify this attribute',
				'on' => 'create',
			),
		),
		'icon' => array(
			'fileExtension' => array(
				'rule' => array('fileExtension', array('png','jpg','jpeg')),
				'message' => 'Please supply a valid image (PNG , JPEG, JPG only).',
				'allowEmpty' => true,
				'required' => false,
			),
			'extension' => array(
				'rule' => array('extension', array('png','jpg','jpeg')),
				'message' => 'Please supply a valid image (PNG , JPEG, JPG only).',
				'allowEmpty' => true,
				'required' => false,
			),
			'fileSize' => array(
				'rule' => array('fileSize', '<=', '1MB'),
				'message' => 'Image must be less than 1MB',
				'allowEmpty' => true,
				'required' => false,
			),
			'mimeType' => array(
				'rule' => array('mimeType', array('image/jpeg', 'image/png')),
				'message' => 'Invalid mime type. Only PNG, JPEG, JPG and GIF format are allowed',
				'allowEmpty' => true,
				'required' => false,
			),
			'uploadError' => array(
				'rule' => array('uploadError'),
				'message' => 'Something went wrong with the upload.',
				'allowEmpty' => true,
				'required' => false,
			),
			'processMediaUpload' => array(
			  	'rule' => 'processMediaUpload',
			  	'message' => 'Unable to process cover image upload.',
				'required' => false,
				'allowEmpty' => true,
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CharacteristicTranslation' => array(
			'className' => 'CharacteristicTranslation',
			'foreignKey' => 'characteristic_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Property' => array(
			'className' => 'Property',
			'joinTable' => 'characteristics_properties',
			'foreignKey' => 'characteristic_id',
			'associationForeignKey' => 'property_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
