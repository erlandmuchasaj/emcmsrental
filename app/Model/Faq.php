<?php
App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');
/**
 * Faq Model
 *
 */
class Faq extends AppModel {
/**
 * Model Name
 *
 * @var string
 */	
	public $name = 'Faq';

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
	public $displayField = 'question';

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
		'question' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Question can not be empty',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 256),
				'message' => 'Maximum length for a question is 256 characters.',
			),
		),
	);


	public function afterSave($created, $options = array()) {
		parent::afterSave($created, $options);
		// sent an email to the user after a property has been 
		// created
		if ($created === true) {
			// $ecentName, $eventSubject, $passedData
			$Event = new CakeEvent('Model.Faq.created', $this, [
				'id' => $this->id,
				'data' => $this->data[$this->alias]
			]);
			$this->getEventManager()->dispatch($Event);
		}
		return true;
	}

}