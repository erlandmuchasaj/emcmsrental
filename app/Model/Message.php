<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property Property $Property
 * @property Reservation $Reservation
 * @property Converstation $Converstation
 */
class Message extends AppModel {

/* 
* $message['Message']['message_type']
* 1- 'Reservation Request', 'trips/request'			=> reservation_request
* 2- 'Conversation', 'trips/conversation'			=> conversation
* 3- 'Message', 'trips/conversation'				=> message
* 4- 'Review Request', 'trips/review_by_host'		=> review_by_host
* 5- 'Review Request', 'trips/review_by_traveller'  => review_by_traveller
* 6- 'Inquiry', 'trips/conversation' 				=> inquiry
* 7- 'Contacts Request', 'contacts/request'			=> contact_response
* 8- 'Contacts Response', 'contacts/response'		=> contact_response
* 9- 'Referrals', 'trips/conversation'				=> referrals
* 10- 'List Creation', 'trips/conversation'			=> list_creation
* 11- 'List Edited', 'trips/conversation'			=> list_edited
* 12- 'Request Sent', 'trips/request_sent'			=> request_sent
*/

/**
 * Model Name
 *
 * @var string
 */	
	public $name = 'Message';

/**
 * User Table
 *
 * @var string
 */	
	public $useTable = 'messages';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'subject';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'ID should be left empty on create',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_by' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'User by id can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_to' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'User to id can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'message' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'Message can not be longer than 512 characters.',
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
		'UserBy' => array(
			'className' => 'User',
			'foreignKey' => 'user_by',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => array(
                'messages_read' => array('Message.is_read' => 1),
                'messages_unread' => array('Message.is_read' => 0)
            )
		),
		'UserTo' => array(
			'className' => 'User',
			'foreignKey' => 'user_to',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => array(
                'messages_read' => array('Message.is_read' => 1),
                'messages_unread' => array('Message.is_read' => 0)
            )
		),
		'Reservation' => array(
			'className' => 'Reservation',
			'foreignKey' => 'reservation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Property' => array(
			'className' => 'Property',
			'foreignKey' => 'property_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);


	public function sentMessage($insertData=array(), $isCoversation = 0) {
		// If start a new converstation
		// set to 1 if you want a conversation
		if ($isCoversation != 0) {
			$userby  = $insertData[$this->alias]['user_by'];
			$userto  = $insertData[$this->alias]['user_to'];
			$query = $this->find('first', array(
				'conditions' => array(
					'OR' => array(
						array('AND' => array(
							array('Message.user_by'=> $userby),
							array('Message.user_to'=> $userto),
						)),
						array('AND' => array(
							array('Message.user_by'=> $userto),
							array('Message.user_to'=> $userby),
						)),
					),
				),
				'fields' => array('MAX(Message.conversation_id) AS conversation_id'),
				'recursive' => -1,
				'limit'=>1,
				'order' => array('Message.conversation_id' => 'DESC'),
			));			

			if (isset($query[0]['conversation_id']) && !empty($query[0]['conversation_id']) && $query[0]['conversation_id'] != 0) {
				// Continue Converstation
				$id = $query[0]['conversation_id'];
				$insertData[$this->alias]['conversation_id'] = strval($id);
			} else {	
				// Get next Available ID for NEW Converstation
				$nextId = $this->find('first' , array('fields' => array('MAX(conversation_id) as conversation_id'), 'recursive' => -1 , 'limit'=>1, 'order' => array('conversation_id' => 'DESC')));
				$nextId = $nextId[0]['conversation_id']+1;
				$insertData[$this->alias]['conversation_id'] = strval($nextId);
			}
		}
		// else  Update Converstation
		// tha twe allredy have by finding it.
		$this->create();
		$return = $this->save($insertData, false);
		$this->clear();

		return $return;
	}

	public function hasConversation($id){
		$message = $this->find('count', array('conditions' => array('Message.conversation_id' => $id),'recursive' => -1));
		if ($message) {
			return true;
		}
		return false;
	}

	public function getContactId($id){
		$message = $this->find('first', array(
			'conditions' => array(
				'Message.conversation_id' => $id,
			),
			'limit'=>1,
			'order' => array('Message.id' => 'DESC'),
		));		
		if (!$message) {
			return 0;
		}
		return $message['Message']['contact_id'];
	}

	public function travelerHasAccess($id){
		// find the message to which except request or payment rocess
		$message = $this->find('first', array('conditions' => array('Message.id' => $id),'recursive' => -1));
		$userID  = AuthComponent::user('id');
		if (isset($message['Message']['user_by']) && !empty($message['Message']['user_by']) && $message['Message']['user_by'] === $userID) {
			return true;
		}
		return false;
	}

	public function hostHasAccess($id){
		// find the message to which except request or payment rocess
		$message = $this->find('first', array('conditions' => array('Message.id' => $id),'recursive' => -1));
		$userID  = AuthComponent::user('id');
		if (isset($message['Message']['user_to']) && !empty($message['Message']['user_to']) && $message['Message']['user_to'] === $userID) {
			return true;
		}
		return false;
	}
}