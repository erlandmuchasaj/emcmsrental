<?php
App::uses('AppModel', 'Model');
/**
 * State Model
 *
 * @property Country $Country
 * @property Zone $Zone
 */
class State extends AppModel {

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
				'message' => 'ID can not be changed manually',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'country_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Country id can not be empty.',
				'allowEmpty' => false
			),
		),
		'zone_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Zone id can not be empty.',
				'allowEmpty' => false
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'name can not be empty.',
				'allowEmpty' => false
			),
		),
		'iso_code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'ISO code can not be empty.',
				'allowEmpty' => false
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
		'Zone' => array(
			'className' => 'Zone',
			'foreignKey' => 'zone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
