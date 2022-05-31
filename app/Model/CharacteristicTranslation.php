<?php
App::uses('AppModel', 'Model');
/**
 * CharacteristicTranslation Model
 *
 * @property Characteristic $Characteristic
 * @property Language $Language
 */
class CharacteristicTranslation extends AppModel {
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
	public $displayField = 'characteristic_name';

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
		'characteristic_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Characteristic name can not be empty',
				'allowEmpty' => true,
				'required' => false,
			),
			'maxLength' => array(
				'rule' => array('maxLength' , 140),
				'message' => 'Characteristic name  can not be more then 140 characters.',
				'allowEmpty' => true,
				'required' => false,
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
		'Characteristic' => array(
			'className' => 'Characteristic',
			'foreignKey' => 'characteristic_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}