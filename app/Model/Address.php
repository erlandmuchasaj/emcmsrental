<?php
App::uses('AppModel', 'Model');
/**
 * Address Model
 *
 * @property Country $Country
 * @property State $State
 * @property User $User
 */
class Address extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'alias';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not directly access ID.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'country_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please select a country',
				'allowEmpty' => false,
			),
		),
		'alias' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter an address name',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			// 'isUnique' => array(
			// 	'rule' => 'isUnique',
			// 	'message' => 'It seems that this address alias alredy exists, please use enter another one.',
			// ),
		),
		'address1' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter primary address',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'city' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'City name can not be empty',
				'allowEmpty' => false,
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
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function limitDuplicates($check, $limit) {
	    // $check will have value: array('promotion_code' => 'some-value')
	    // $limit will have value: 25
	    $existingPromoCount = $this->find('count', array(
	        'conditions' => $check,
	        'recursive' => -1
	    ));
	    return $existingPromoCount < $limit;
	}

}
