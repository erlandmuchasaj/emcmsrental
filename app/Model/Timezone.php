<?php
App::uses('AppModel', 'Model');
/**
 * Timezone Model
 *
 * @property Property $Property
 * @property Reservation $Reservation
 */
class Timezone extends AppModel {

	/**
	 * Model Name
	 *
	 * @var string
	 */
	public $name = 'Timezone';

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
				'message' => 'You can not modify this attribute',
				'on' => 'create',
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Timezone name can not be empty',
				'allowEmpty' => false,
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This name allredy exists.',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 32),
				'message' => 'Max length of timezone name is 32 characters.',
			),
		),
	);

	/**
	 * Get Timezone different fields
	 * $this->Timezone->findTimezoneName(ID);
	 * @var Boolean
	 * @var String
	 */
	public function findTimezoneNameById($id) {
		return $this->field('name', array('id' => $id));
	}

	public function findTimezoneIdByName($name) {
		return $this->field('id', array('name' => $name));
	}

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	// public $hasMany = array(
	// 	'UserProfile' => array(
	// 		'className' => 'UserProfile',
	// 		'foreignKey' => 'timezone_id',
	// 		'dependent' => false,
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => '',
	// 		'limit' => '',
	// 		'offset' => '',
	// 		'exclusive' => '',
	// 		'finderQuery' => '',
	// 		'counterQuery' => ''
	// 	),
	// );

}
