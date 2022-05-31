<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Messages Controller
 *
 * @property Message $Message
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MessagesController extends AppController {

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
 * Uses
 *
 * @var array
 */
	public $uses = array('Message','User');

/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler','Paginator', 'Session', 'Email');

/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('getNewMessages','getCount');
	}

/**
 * user authorization method
 *
 * @return void
 */
	public function isAuthorized($user = null) {
		return parent::isAuthorized($user);
	}
////////////////////////////////////////////////////////////////////////////////////

/**
 * getNewMessages method
 *
 * @return number of messages unread
 */
	public function getNewMessages() {
		$this->autoRender = false;
		$this->layout = null;
		$this->request->onlyAllow('ajax');

		$response = array();
		$response['messages'] = 0;

		$options = [
			'conditions' => [
				'Message.user_to' => $this->Auth->user('id'),
				'Message.is_read' => 0,
			],
			'recursive' => -1
		];

		// set php runtime to unlimited
		set_time_limit(0);
		while (true) {
			// if ajax request has send a timestamp, then $current_count = timestamp, else $current_count = null
			$current_count = isset($_GET['messages']) ? ((int)$_GET['messages']>0 ? (int)$_GET['messages']: 'null') : null;
			// PHP caches file data, like requesting the size of a file, by default. clearstatcache() clears that cache
			clearstatcache();
			// get content of mesages from db
			$messages = $this->Message->find('count', $options);
			// if no timestamp delivered via ajax or data.txt has been changed SINCE last ajax timestamp
			if ($current_count === null || $messages > $current_count) {
				// put content change into array
				$response['messages'] = $messages;
				// encode to JSON, render the result (for AJAX)
				$json =  json_encode($response);
				echo $json;
				// leave this loop step
				break;
			} else {
				// wait for 2 sec (not very sexy as this blocks the PHP/Apache process, but that's how it goes)
				sleep(2);
				continue;
			}
		}
	}

/**
 * getCount
 * return the total number of unread messages
 * 
 * @return int
 */
	public function getCount() {
		if (empty($this->request->params['requested'])) {
			throw new ForbiddenException();
		}
		$options = array(
			'conditions' => array(
				'Message.user_to'=>$this->Auth->user('id'),
				'Message.is_read'=> 0,
			),
			'recursive' => -1
		);
		return $this->Message->find('count', $options);
	}

/**
 * send Message method
 *
 * @return void
 */
	public function sendNewMessage($id = null) {
		if ($this->request->is('ajax')){
			$this->autoRender = false;
			$this->layout = null;
		}
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];
		

	 	if ($this->request->is('ajax')) {
			$this->request->data['Message']['user_by'] = $this->Auth->user('id');
			if($this->Message->sentMessage($this->request->data, 0)){
				$response['type'] = 'success';
				$response['message'] = __('Message was sent successfully.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] =__('Message Could not be sent. Please try again!');
			}
		}
		return json_encode($response);
	}

/**
 * send Message method
 * send a message from property view page.
 *
 * @return void
 */
	public function newMessage() {
		if ($this->request->is('ajax')){
			$this->autoRender = false;
			$this->layout = null;
		}
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$property = $this->Message->Property->read(null, $this->request->data['Message']['property_id']);
		
		$this->request->data['Message']['user_by'] = $this->Auth->user('id');
		$this->request->data['Message']['user_to'] = $property['Property']['user_id'];
		$this->request->data['Message']['message_type'] = 'message';

		// debug([$property, $this->request->data]);
		// die;
		if($this->Message->sentMessage($this->request->data, 1)){
			$response['type'] = 'success';
			$response['message'] = __('Message was sent successfully.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] =__('Message Could not be sent. Please try again!');
		}

		return json_encode($response);
	}


/**
 * user_index method
 *
 * @return void
 */
	public function index($type = 'all') {
		// $this->Message->virtualFields += $this->User->virtualFields;
		// debug($this->User->virtualFields);
		// die();
		// unset($this->User->virtualFields);

		if ('all' === $type) {
			$conditions = array(
				'Message.is_archived' => 0,
				'Message.user_to'=> $this->Auth->user('id')
			);
		} elseif ('starred' === $type) {
			$conditions = array(
				'Message.is_starred' => 1,
				'Message.user_to'=> $this->Auth->user('id')
			);
		} elseif ('unread' === $type) {
			$conditions = array(
				'Message.is_read' => 0,
				'Message.is_archived' => 0,
				'Message.user_to'=> $this->Auth->user('id')
			);
		} elseif ('reservations' === $type) {
			$conditions = array(
				'Message.is_archived' => 0,
				'Message.message_type' => 'reservation_request',
				'Message.user_to'=> $this->Auth->user('id')
			);
		} elseif ('never_responded' === $type) {
			$conditions = array(
				'Message.is_respond' => 0,
				'Message.is_archived' => 0,
				'Message.user_to'=> $this->Auth->user('id')
			);
		}elseif ('archived' === $type) {
			$conditions = array(
				'Message.is_archived' => 1,
				'Message.user_to'=> $this->Auth->user('id')
			);
		} else {
			$conditions = array(
				'Message.is_archived' => 0,
				'Message.user_to'=> $this->Auth->user('id')
			);
		}

		// $conditions['AND'] = [
		//     'OR' => array(
		//         'Message.user_by' => $this->Auth->user('id'),
		//         'Message.user_to' => $this->Auth->user('id'),
		//     ),
		// ];

		// $conditions['OR'] = array(
		// 	array('Message.user_by' => $this->Auth->user('id')),
		// 	array('Message.user_to' => $this->Auth->user('id')),
		// );

		$language_id = $this->Message->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Message->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);

		$this->Message->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'contain' => array(
				'UserBy',
				'UserTo',
				'Reservation',
				'Property' => [
					'PropertyTranslation'
				],
			),
			'limit' => 25,
			// 'fields' => array('*'),
			'order' => array('Message.id' => 'DESC'),
			// 'group' => array('Message.conversation_id'),
			'recursive' => 0,
			'maxLimit' => 100,
			'paramType' => 'querystring'
		);

		$messages = $this->Paginator->paginate();
		$this->set('messages', $messages);

		// THIS IS HELPFULL TO GET LOG FILES
		// $log = $this->Message->getDataSource()->getLog(false, false);
		// debug($log);
	}

/**
 * user_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function conversation($conversation_id = null) {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->layout = null;
		}

		if (!$conversation_id) {
			throw new BadRequestException(__('Missing conversation id.'));
		}

		if (!$this->Message->hasConversation($conversation_id)) {
			throw new NotFoundException(__('Invalid conversation'));
		}

		$query = "SELECT id 
		FROM messages 
		WHERE (`messages`.`conversation_id` = {$conversation_id} AND  `messages`.`user_by` = {$this->Auth->user('id')}) OR
			(`messages`.`conversation_id` = {$conversation_id}  AND  `messages`.`user_to` = {$this->Auth->user('id')}) 
		ORDER BY id DESC 
		LIMIT 50";



		// this is used to grab allways the last 50 messages
		$messagesID = $this->Message->query($query);
		$group = [];
		foreach ($messagesID as $value) {
			$group[] = $value['messages']['id'];
		}


		$language_id = $this->Message->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Message->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);

		$this->Message->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    // 'foreignKey' => false,
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);

		$messages = $this->Message->find('all', array(
			'conditions' => array(
				'OR' => array(
					array('AND' => array(
						array('Message.conversation_id' => $conversation_id),
						array('Message.user_by' => $this->Auth->user('id')),
					)),
					array('AND' => array(
						array('Message.conversation_id' => $conversation_id),
						array('Message.user_to' => $this->Auth->user('id')),
					)),
				),
				'Message.id IN' => $group,
			),
			'contain' => array(
				'UserBy',
				'UserTo',
				'Reservation',
				'Property' => [
					'PropertyTranslation'
				]
			),
			'limit' => 50,
			// 'fields' => array('*'),
			'order' => array('Message.id' => 'asc'),
			'recursive' => 0
		));

		if (empty($messages)) {
			$this->Flash->error(__('This conversation does not exist.'));
			return $this->redirect($this->referer(array('action' => 'index')));
		}

		if ($messages[0]['Message']['user_by'] == $this->Auth->user('id')) {
			$coversation_userID = $messages[0]['Message']['user_to'];
		} else {
			$coversation_userID = $messages[0]['Message']['user_by'];
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->request->data['Message']['reservation_id'] != 0) {
				$insertData = array(
					'property_id'    => $this->request->data['Message']['property_id'],
					'reservation_id' => $this->request->data['Message']['reservation_id'],
					'user_by'        => $this->request->data['Message']['user_by'],
					'user_to'        => $this->request->data['Message']['user_to'],
					'message'        => $this->request->data['Message']['message'],
					'subject'        => __('Conversation'),
					'message_type'   => 'conversation'
				);

				// update message
				$this->Message->updateAll(
					array(
						'Message.is_respond'=> 1
					),
					array(
						'Message.conversation_id' => $conversation_id,
						'Message.user_to' => $this->request->data['Message']['user_by']
					)
				);
			} elseif ($this->request->data['Message']['contact_id']!=0) {
				$insertData = array(
					'property_id'    => $this->request->data['Message']['property_id'],
					'contact_id' 	 => $this->request->data['Message']['contact_id'],
					'user_by'        => $this->request->data['Message']['user_by'],
					'user_to'        => $this->request->data['Message']['user_to'],
					'message'        => $this->request->data['Message']['message'],
					'subject'        => __('Conversation'),
					'message_type'   => 'conversation'
				);
				// update message
				$this->Message->updateAll(
					array(
						'Message.is_respond'=> 1
					),
					array(
						'Message.conversation_id' => $conversation_id,
						'Message.user_to' => $this->request->data['Message']['user_by']
					)
				);
			} elseif ($this->request->data['Message']['reservation_id']==0 && $this->request->data['Message']['contact_id']==0
			) {
				$insertData = array(
					'property_id'    => $this->request->data['Message']['property_id'],
					'conversation_id'=> $this->request->data['Message']['property_id'],
					'user_by'        => $this->request->data['Message']['user_by'],
					'user_to'        => $this->request->data['Message']['user_to'],
					'message'        => $this->request->data['Message']['message'],
					'subject'        => __('List Creation'),
					'message_type'   => 'list_creation'
				);

				// update message
				$this->Message->updateAll(
					array(
						'Message.is_respond'=> 1
					),
					array(
						'Message.conversation_id' => $conversation_id,
						'Message.user_to' => $this->request->data['Message']['user_by']
					)
				);
			}

			$insertData['Message'] = $insertData;
			if ($this->Message->sentMessage($insertData, 1)) {
				$this->Flash->success(__('Message has been sent.'));
			} else {
				$this->Flash->error(__('Message could not be sent. Please, try again.'));
			}
			return $this->redirect(array('action' => 'conversation', $conversation_id));
		}

		$data['conversation_id'] = $conversation_id;
		$data['property_id']     = $messages[0]['Message']['property_id'];
		$data['reservation_id']  = $messages[0]['Message']['reservation_id'];
		$data['contact_id'] 	 = $this->Message->getContactId($conversation_id);
		$user  = $this->User->getUserByID($coversation_userID);
		$data['User'] = $user['User'];
		$this->set(compact('messages','data'));
	}

/**
 * send Message method
 *
 * @return void
 */
	public function sendMessage($user_by = null) {
		
		if (!$user_by) {
			throw new BadRequestException(__('Missing user id.'));
		}

		$user_to = $this->Auth->user('id');


		$query = "SELECT MAX(`conversation_id`) as conversation_id 
		FROM `messages` 
		WHERE
			(`messages`.`user_by` = '" . $user_by . "' AND `messages`.`user_to` ='" . $user_to . "') 
			OR 
			(`messages`.`user_by` = '" . $user_to . "' AND `messages`.`user_to` ='" . $user_by . "')";

		// this is used to grab allways the last 50 messages
		$messagesID = $this->Message->query($query);
	}

/**
 * View a review by host
 *
 * @todo Place function on the review controller
 * @param  int $reservation_id
 * @return void
 */
	public function host_review($reservation_id = null) {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->layout = null;
		}

		if(!$reservation_id) {
			throw new BadRequestException(__('Missing reservation id.'));
		}

		// check if reservation exist
		if (!$this->Message->Reservation->exists($reservation_id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		// get reservation
		$options = array(
			'conditions' =>  array(
				'Reservation.id' => $reservation_id,
				'Reservation.user_to' => $this->Auth->user('id')
			)
		);
		$reservation = $this->Message->Reservation->find('first', $options);

		if (empty($reservation)) {
			$this->Flash->error(__('Reservation could not be found. Please, try again.'));
			return $this->redirect(array('action' => 'index', 'all'));
		}

		// now we get reviews for this reservation
		$options = array(
			'conditions' =>  array(
				'Review.reservation_id' => $reservation_id,
				'Review.user_by' => $this->Auth->user('id')
			)
		);
		$review = $this->Message->Reservation->Review->find('first', $options);

		$this->set(compact('review'));
	}

/**
 * View a review by traveler
 *
 * @todo Place function on the review controller
 * @param  int $reservation_id
 * @return void
 */
	public function traveler_review($reservation_id = null) {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->layout = null;
		}

		if(!$reservation_id) {
			throw new BadRequestException(__('Missing reservation id.'));
		}

		// check if reservation exist
		if (!$this->Message->Reservation->exists($reservation_id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		// get reservation
		$options = array(
			'conditions' =>  array(
				'Reservation.id' => $reservation_id,
				'Reservation.user_by' => $this->Auth->user('id')
			)
		);
		$reservation = $this->Message->Reservation->find('first', $options);

		if (empty($reservation)) {
			$this->Flash->error(__('Reservation could not be found. Please, try again.'));
			return $this->redirect(array('action' => 'index', 'all'));
		}

		// now we get reviews for this reservation
		$options = array(
			'conditions' =>  array(
				'Review.reservation_id' => $reservation_id,
				'Review.user_by' => $this->Auth->user('id')
			)
		);
		$review = $this->Message->Reservation->Review->find('first', $options);

		$this->set(compact('review'));
	}

/**
 * user_view messages auction
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function auction($id = null) {
		if(!isset($id) || empty($id)) {
			$this->Session->setFlash(__('This Message Does not exist.'),'flash_error');
			return $this->redirect($this->referer(array('action' => 'index')));
			exit;
		}

		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			$this->Session->setFlash(__('This Message Does not exist.'),'flash_error');
			return $this->redirect($this->referer(array('action' => 'index')));
			exit;
		}

		App::uses('Language', 'Model');
		$Language = new Language();
		$language_id = $Language->getActiveLanguageId();

		$this->Message->bindModel(array(
			'hasOne' => array(
				'PropertyTranslation' => array(
					// 'foreignKey' => false,
					'conditions' => array(
						'Message.property_id = PropertyTranslation.property_id',
						'PropertyTranslation.language_id' => $language_id
					),
					'className' => 'PropertyTranslation'
				),
			)
		));
		$booking = $this->Message->find('first', array(
			'conditions' => array(
				'Message.id' => $id,
			),
			'recursive' => 0,
			'order' => array('Message.id' => 'DESC'),
		));

		if (!isset($booking['Message']) || empty($booking['Message'])) {
			$this->Session->setFlash(__('This Message Does not exist.'),'flash_error');
			return $this->redirect($this->referer(array('action' => 'index')));
			exit;
		}

		$booking_data = json_decode($booking['Message']['data'], true);
		if (!isset($booking_data['Booking']['checkin']) || empty($booking_data['Booking']['checkin']) || trim($booking_data['Booking']['checkin'])=='' || !$this->__validateDate($booking_data['Booking']['checkin'])){
			$this->Session->setFlash(__('Sorry! Access denied, Invalid date format'),'flash_error');
			return $this->redirect($this->referer(array('action' => 'index')));
			exit;
		}

		App::uses('Review', 'Model');
		$Review = new Review();
		// find property reviews
		$Review->unbindModel(array(
			'belongsTo' => array('Reservation','Property')
		));
		$options =  array(
			'conditions' => array(
				'Review.user_by' 	=> $booking['UserBy']['id'],
				'Review.status' 	=> 1,
				'Review.is_dummy' 	=> 0,
				'Review.review_status'=> array('completed', 'incomplete')
			),
			'recursive'=>0
		);
		$userReviews = $Review->find('all', $options);
		$this->request->data = $booking;
		$this->set(compact('booking','userReviews'));
	}

/**
 * changeStatus method
 *
 * @return void
 */
	public function changeStatus(){
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];
		

		if ($this->Message->save($this->request->data, false)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed message starred status.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Message Status could not be changed. Please Try again!');
		}

		return json_encode($response);
	}

/**
 * changeStatus method
 *
 * @return void
 */
	public function changeArchiveStatus(){
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];
		

		if ($this->Message->save($this->request->data, false)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed archive status of this message.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('This message archive status could not be changed. Please Try again!');
		}

		return json_encode($response);
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];
		
		$this->Message->id = $id;
		if ($this->request->is('ajax')) {
			if ($this->Message->delete()) {
				$response['type'] = 'success';
				$response['message'] = __('Message has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Message could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} elseif ($this->request->is('post')) {
			if ($this->Message->delete()) {
				$this->Flash->success(__('Message has been deleted.'));
			} else {
				$this->Flash->error(__('Message could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

/**
 * is_read method
 *
 * @return void
 * @description mark as read messages.
 */
	public function isRead(){
		$this->autoRender = false;
		$this->layout = null;
		$this->request->onlyAllow('ajax');
		$this->Message->save($this->request->data, false);
		return true;
	}

}
