<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Article $Article
 */
class Category extends AppModel {

/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Category';

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
				'message' => 'You can not directlly modify this attribute',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter the value for Category Name.',
				'allowEmpty' => false
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Category with the same name allredy exists.',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'category name can not have more then 160 characters.',
			),
		),
		'description' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 240),
				'message' => 'category name can not have more then 240 characters.',
				'allowEmpty' => true,
			),
		),
		'slug' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'Slug can not have more then 160 characters.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Slug should be unique',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Slug can not be empty.',
				'allowEmpty' => false
			),
        ),
        'meta_title' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 60),
        		'message' => 'Meta title can not have more then 60 characters.',
        		'allowEmpty' => true
        	),
        ),
        'meta_description' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 160),
        		'message' => 'Meta description can not have more then 160 characters.',
        		'allowEmpty' => true
        	),
        )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'category_id',
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
		'Experience' => array(
			'className' => 'Experience',
			'foreignKey' => 'category_id',
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
		'Service' => array(
			'className' => 'Service',
			'foreignKey' => 'category_id',
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
	);
}