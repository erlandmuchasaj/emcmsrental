<?php
App::uses('AppModel', 'Model');
/**
 * RoomType Model
 *
 * @property RoomType $RoomType
 * @property Language $Language
 * @property Property $Property
 * @property RoomType $RoomType
 */
class RoomType extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'room_type_name';

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
		'room_type_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Room type name can not be empty',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 128),
				'message' => 'Max length 160 characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)	
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		// 'Parent' => array(
		// 	'className' => 'RoomType',
		// 	'foreignKey' => 'room_type_id',
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
		// 	'className' => 'RoomTypes',
		// 	'foreignKey' => 'room_type_id',
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
		$result = $this->find('first', array('fields' => array('MAX(RoomType.room_type_id) as room_type_id'), 'recursive' => -1, 'callbacks' => false, 'limit'=>1));
		
		if (!isset($result[0]['room_type_id'])) {
			return 1;
		}

		$nextId = $result[0]['room_type_id']+1;
		return (int) $nextId;
	}

}
