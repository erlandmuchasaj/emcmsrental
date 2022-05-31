<?php
App::uses('AppModel', 'Model');
/**
 * City Model
 *
 * @property CityPlace $CityPlace
 */
class City extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

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
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'City name can not be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 90),
				'message' => 'Slogan can be up to 90 characters long.',
				'allowEmpty' => true,
			),
		),
		'description' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'City description can not be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'around' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'known' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'image_path' => array(
			'fileExtension' => array(
				'rule' => array('fileExtension', array('png','jpg','jpeg')),
				'message' => 'Please supply a valid image (PNG , JPEG, JPG only).',
				'allowEmpty' => false,
				'on' => 'create',
			),
			'fileMaxSize' => array(
				'rule' => array('fileMaxSize', '8388608'),
				'message' => 'Max file size is exeeded.',
				'allowEmpty' => false,
				'on' => 'create',
			),
			'processMediaUpload' => array(
				'rule' => 'processMediaUpload',
				'message' => 'Unable to process image upload.',
				'allowEmpty' => false,
				'on' => 'create',
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * ActsAs
 *
 * @var array
 */
	public $actsAs = array(
		'Upload.Upload' => array(
			'fields' => array(
				'image_path' => ''
			),
			'use_thumbnails' => false
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CityPlace' => array(
			'className' => 'CityPlace',
			'foreignKey' => 'city_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => '',
			'conditions' => array(
				'Image.model_id' => 'City.id',
				'Image.model' => 'City'
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

}
