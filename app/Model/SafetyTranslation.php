<?php
App::uses('AppModel', 'Model');
/**
 * SafetyTranslation Model
 *
 * @property Safety $Safety
 * @property Language $Language
 */
class SafetyTranslation extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'safety_name';

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
		'safety_name' => array(	
			'maxLength' => array(
				'rule' => array('maxLength', 140),
				'message' => 'Safety name can be less then 140 characters long',
				'allowEmpty' => true,
				'required' => false,
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Safeties name can not be empty',
				'allowEmpty' => true,
				'required' => false,
			),
		),
	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Safety' => array(
			'className' => 'Safety',
			'foreignKey' => 'safety_id',
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

	/**
	 * Called before each save operation, after validation. Return a non-true result
	 * to halt the save.
	 *
	 * @param array $options Options passed from Model::save().
	 * @return bool True if the operation should continue, false if it should abort
	 * @link https://book.cakephp.org/2.0/en/models/callback-methods.html#beforesave
	 * @see Model::save()
	 */
	public function beforeSave($options = array()) {
		return parent::beforeSave($options);
	}

	/**
	 * Called after save operation.
	 *
	 * @param bool $created True if this save created a new record
	 * @param array $options Options passed from Model::save().
	 * @return void
	 * @see Model::save()
	 */
	public function afterSave($created, $options = array()) {
		parent::afterSave($created, $options);
		return true;
	}

}
