<?php
App::uses('AppModel', 'Model');
/**
 * AccommodationType Model
 *
 * @property AccommodationType $AccommodationType
 * @property Language $Language
 * @property AccommodationType $AccommodationType
 * @property Property $Property
 */
class AccommodationType extends AppModel {

/**
 * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
 *
 * @var string
 */
	public $displayField = 'accommodation_type_name';

/**
 * Custom database table name, or null/false if no table association is desired.
 *
 * @var string|false
 */
	public $useTable = 'accommodation_types';

/**
 * The name of the primary key field for this model.
 *
 * @var string
 */
	public $primaryKey = 'id';

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
		'accommodation_type_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Accommodation name can not be empty',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Accommodation name can not have more than 160 characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		// 'Parent' => array(
		// 	'className' => 'AccommodationType',
		// 	'foreignKey' => 'accommodation_type_id',
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => ''
		// ),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		// 'Children' => array(
		// 	'className' => 'AccommodationType',
		// 	'foreignKey' => 'accommodation_type_id',
		// 	'dependent' => false,
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => '',
		// 	'limit' => '',
		// 	'offset' => '',
		// 	'exclusive' => '',
		// 	'finderQuery' => '',
		// 	'counterQuery' => ''
		// )
	);

/*****************************************************
* 				Find next Available ID
******************************************************/
	public function nextAvailableId() {
		$result = $this->find('first', array('fields' => array('MAX(AccommodationType.accommodation_type_id) as accommodation_type_id'), 'recursive' => -1,
			'callbacks' => false, 'limit'=>1));

		if (!isset($result[0]['accommodation_type_id'])) {
			return 1;
		}

		$nextId = $result[0]['accommodation_type_id']+1;
		return (int) $nextId;
	}

}