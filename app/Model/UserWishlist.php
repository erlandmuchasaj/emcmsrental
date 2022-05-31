<?php
App::uses('AppModel', 'Model');
/**
 * UserWishlist Model
 *
 * @property User $User
 * @property Property $Property
 * @property Wishlist $Wishlist
 */
class UserWishlist extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'user_id';

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
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Only numeric values are allowed',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter the value for user ID'
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'model_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter the value for model_id'
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Only numeric values are allowed',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'wishlist_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter the value for wishlist_id'
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Only numeric values are allowed',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Property' => array(
		    'className' => 'Property',
		    'foreignKey' => 'model_id',
		    'conditions' => array(
		        'UserWishlist.model' => 'Property',
		    ),
		),
		'Experience' => array(
		    'className' => 'Experience',
		    'foreignKey' => 'model_id',
		    'conditions' => array(
		        'UserWishlist.model' => 'Experience',
		    ),
		),
		'Wishlist' => array(
			'className' => 'Wishlist',
			'foreignKey' => 'wishlist_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => 'count'
		)
	);
}
