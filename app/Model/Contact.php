<?php
App::uses('AppModel', 'Model');
/**
 * Contact Model
 *
 */
class Contact extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => 'blank',
				'message' => 'ID can not be changed manually homeboy.',
				'on' => 'create',
			),
		),
		'name' => array(
			'rule' => array('notBlank'),
			'message' => 'Field is required'
		),
		'email' => array(
			'email' => array(
				'rule' => array('email', true),
				'message' => 'That email address does not seem to be valid.'
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'E-mail can not be empty.',
				'allowEmpty' => false
			),
		),
		'subject' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Subject can not be empty',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength' , 80),
				'message' => 'Subject can not be more then 80 characters long.',
			),
		),
		'message' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'message body can not be empty. Please write something.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 360),
				'message' => 'message can not be more then 80 characters long.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_read' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * Saves a contact into the contats table
 * @param  array  $data
 * @param  string $type The Contact type - usually the page type
 * @return boolean
 */
	public function saveContact($data = array(), $type = null) {
		if (!$data || !$type) {
			throw new NotFoundException(__('Invalid data or type'));
		}

		$data['Contact']['type'] = $type;

		$this->create();
		$result = $this->save($data);
		if (!$result) {
			throw new LogicException(__('There was a problem, please review the errors below and try again.'));
		}

		$optionsEmail = array(
			'viewVars' => array(
				'contact' => $result, 
				'siteName' => Configure::read('Website.name'),
			),
			'subject' => $result['Contact']['subject'],
			'content' => $result['Contact']['message'],
			'from'    => $result['Contact']['email'],
			'from_name' => $result['Contact']['name'],
		);

		parent::__sendMail(Configure::read('Website.email'), $optionsEmail);
		
		return true;
	}

}
