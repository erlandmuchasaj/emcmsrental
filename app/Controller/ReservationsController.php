<?php
App::uses('AppController', 'Controller');
App::uses('Paypal', 'Paypal.Lib');
/**
 * Reservations Controller
 *
 * @property Reservation $Reservation
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ReservationsController extends AppController {

/**
 * Reservations Statuses
 *
 * 1 - pending_approval 	// 
 * 0 - payment_pending 		//
 * 4 - declined 			// (rejected)
 * 3 - accepted 			// (confirmed)
 * 2 - expired				//
 * 0 - payment_error 	    // (failed)
 * 0 - payment_completed 	// (confirmed)
 * 5 - canceled_by_host 	// (canceled) / (canceled_by_admin)
 * 6 - canceled_by_traveler // (canceled)
 * 0 - awaiting_checkin 	// (new)
 * 7 - checkin 				// (attended)
 * 9 - awaiting_traveler_review
 * 8 - awaiting_host_review
 * 10 - completed
 *
 * 11 - after_checkin_canceled_by_host
 * 12 - after_checkin_canceled_by_guest
 * 13 - pending_reservation_canceled
 * ---------------------------
 */

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash', 'Stripe');

/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		/*
			Making a jquery ajax call with Security component activated
			$this->Security->unlockedActions = array('ajax_action');
		*/
		$this->Auth->allow(
			'index',
			'view'
		);
		$this->Auth->autoRedirect = false;
		if (isset($this->Security) && $this->action == 'index') {
			$this->Security->validatePost = false;
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index($search = null) {
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = array();
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'index', $this->request->data['Reservation']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array(
				'Property.address LIKE' => '%' . $search . '%',
				'Reservation.confirmation_code LIKE' => '%' . $search . '%',
				'Traveler.name LIKE' => '%' . $search . '%',
				'Traveler.surname LIKE' => '%' . $search . '%',
				'Traveler.email LIKE' => '%' . $search . '%',
				'Host.name LIKE' => '%' . $search . '%',
				'Host.surname LIKE' => '%' . $search . '%',
				'Host.email LIKE' => '%' . $search . '%',
			);
		}

		$this->Paginator->settings = array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property',
				'CancellationPolicy',
			),
			'fields' => array('Reservation.*', 'Traveler.*', 'Host.*', 'Property.*','CancellationPolicy.*'),
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Reservation.modified' => 'ASC'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
		);
		$reservations = $this->Paginator->paginate();
		$this->set(compact('reservations', 'search'));
	}

/**
 * my_trips method
 *
 * This method is used to get all trips made by a specific
 * user as a traveler
 *
 * @return void
 */
	public function my_trips($search = null) {
		// $this->Reservation->cronCheckHostReview();

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = array('Traveler.id'=>$this->Auth->user('id'));
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'my_trips', $this->request->data['Reservation']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array(
				'Property.address LIKE' => '%' . $search . '%',
				'Reservation.confirmation_code LIKE' => '%' . $search . '%',
				'Host.name LIKE' => '%' . $search . '%',
				'Host.surname LIKE' => '%' . $search . '%',
				'Host.email LIKE' => '%' . $search . '%',
			);
		}

		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Reservation->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Reservation->Property->bindModel([
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
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'PropertyTranslation'
				],
				'CancellationPolicy',
			),
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Reservation.created' => 'DESC'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
		);
		$reservations = $this->Paginator->paginate();

		$this->set(compact('reservations', 'search'));
	}

/**
 * my_reservations method
 *
 * This method is used to get all reservations made
 * to a specific user
 *
 * @return void
 */
	public function my_reservations($search = null) {
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}
		// $this->Reservation->Property->Calendar->removePassedDays();

		$conditions = array('Host.id'=>$this->Auth->user('id'));
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'my_reservations', $this->request->data['Reservation']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array(
				'Property.address LIKE' => '%' . trim($search) . '%',
				'Reservation.confirmation_code LIKE' => '%' . trim($search) . '%',
				'Traveler.name LIKE' => '%' . trim($search) . '%',
				'Traveler.surname LIKE' => '%' . trim($search) . '%',
				'Traveler.email LIKE' => '%' . trim($search) . '%',
			);
		}

		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Reservation->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Reservation->Property->bindModel([
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
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'PropertyTranslation'
				],
				'CancellationPolicy',
			),
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Reservation.created' => 'DESC'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
		);
		$reservations = $this->Paginator->paginate();
		$this->set(compact('reservations', 'search'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->layout = null;
		}

		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		// check if the reservation belongs to this user as host or as traveler
		if (
			!$this->Reservation->isOwnedByHost($id, $this->Auth->user('id')) &&
			!$this->Reservation->isOwnedByTraveler($id, $this->Auth->user('id'))
		) {
			throw new ForbiddenException(__('You dont have access on this reservation.'));
		}

		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Reservation->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Reservation->Property->bindModel([
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

		$reservation = $this->Reservation->find('first', array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'PropertyTranslation'
				],

				'CancellationPolicy',
			),
			'conditions' => array(
				'Reservation.'.$this->Reservation->primaryKey => $id,
			),
			'limit' => 1
		));

		$this->set(compact('reservation'));

		if ($this->request->is('ajax')) {
			$this->render('modal_receipt', 'ajax');
		}
	}


/**
 * booking
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function book($id = null) {
		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		// check if the reservation belongs to this user as host or as traveler
		if (
			!$this->Reservation->isOwnedByHost($id, $this->Auth->user('id')) &&
			!$this->Reservation->isOwnedByTraveler($id, $this->Auth->user('id'))
		) {
			throw new ForbiddenException(__('You dont have access on this reservation.'));
		}

		App::uses('Country', 'Model');
		$Country = new Country();
		$countries = $Country->find('list', array(
	        'fields' => array('Country.iso_code', 'Country.name'),
	        'recursive' => -1,
	        'callbacks' => false
	    ));

		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();

        // Room Type
        $this->Reservation->Property->unbindModel(array(
        	'belongsTo' => array('RoomType', 'AccommodationType'),
        	'hasMany' => array('PropertyTranslation' )
        ));
        $this->Reservation->Property->bindModel(array(
        	'hasOne' => array(
        		'RoomType' => array(
        			'foreignKey' => false,
        			'conditions' => array(
        				'RoomType.room_type_id = Property.room_type_id',
        				'RoomType.language_id' => $language_id
        			),
        			'className' => 'RoomType'
        		),
        		'AccommodationType' => array(
        			'foreignKey' => false,
        			'conditions' => array(
        				'AccommodationType.accommodation_type_id = Property.accommodation_type_id',
        				'AccommodationType.language_id' => $language_id
        			),
        			'className' => 'AccommodationType'
        		),
        		'PropertyTranslation' => array(
        		    'foreignKey' => 'property_id',
        		    'conditions' => array(
        		    	'PropertyTranslation.property_id = Property.id',
        		    	'PropertyTranslation.language_id' => $language_id
        		    ),
        			'className' => 'PropertyTranslation'
        		),
        	)
        ));

        $reservation = $this->Reservation->find('first', array(
        	'contain' => array(
        		'Traveler',
        		'Host',
        		'Property' => [
        			'PropertyTranslation'
        		],
        		'CancellationPolicy',
        	),
        	'conditions' => array(
        		'Reservation.'.$this->Reservation->primaryKey => $id,
        	),
        	'limit' => 1
        ));

        if ($reservation['Reservation']['reservation_status'] !== 'payment_pending') {
        	$this->Flash->error(__('Sorry, you can not proceed with this order.'));
        	return $this->redirect(array('action' => 'my_trips'));
        }

		$this->set(compact('countries', 'reservation'));
	}

// RESERVATION METHOD STATUSES

/**
 * reservation_request By Traveler To HOST method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function reservation_request($id = null) {

		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		if ($this->request->is(array('post', 'put'))) {

			if ($this->request->data['Reservation']['reservation_id'] != 0) {
				$insertData = array(
					'property_id'    => $this->request->data['Reservation']['property_id'],
					'reservation_id' => $this->request->data['Reservation']['reservation_id'],
					'user_by'        => $this->request->data['Reservation']['user_by'],
					'user_to'        => $this->request->data['Reservation']['user_to'],
					'message'        => EMCMS_escape($this->request->data['Reservation']['message']),
					'subject'        => __('Reservation enquiry.'),
					'message_type'   => 'request_sent'
				);

			} elseif ($this->request->data['Reservation']['contact_id'] != 0) {
				$insertData = array(
					'property_id'    => $this->request->data['Reservation']['property_id'],
					'contact_id' 	 => $this->request->data['Reservation']['contact_id'],
					'user_by'        => $this->request->data['Reservation']['user_by'],
					'user_to'        => $this->request->data['Reservation']['user_to'],
					'message'        => EMCMS_escape($this->request->data['Reservation']['message']),
					'subject'        => __('Contact about reservation.'),
					'message_type'   => 'request_sent'
				);

			} elseif (($this->request->data['Reservation']['reservation_id'] == 0) && ($this->request->data['Reservation']['contact_id'] == 0)) {
				$insertData = array(
					'property_id'    => $this->request->data['Reservation']['property_id'],
					'conversation_id'=> $this->request->data['Reservation']['property_id'],
					'user_by'        => $this->request->data['Reservation']['user_by'],
					'user_to'        => $this->request->data['Reservation']['user_to'],
					'message'        => EMCMS_escape($this->request->data['Reservation']['message']),
					'subject'        => __('List Creation'),
					'message_type'   => 'list_creation'
				);
			}

			// update message
			$this->Reservation->Message->updateAll(
				array(
					'Message.is_respond'=> 1
				),
				array(
					'Message.conversation_id' => $id,
					'Message.user_to' => $this->request->data['Reservation']['user_by']
				)
			);

			$insertData['Message'] = $insertData;
			if ($this->Reservation->Message->sentMessage($insertData, 1)) {
				$this->Flash->success(__('Message has been sent.'));
			} else {
				$this->Flash->error(__('Message could not be sent. Please, try again.'));
			}

			return $this->redirect(array('action' => 'reservation_request', $id));
		}

		if ($this->Reservation->checkExpire($id) === 'pending_approval') {
			$this->Reservation->expire($id);
		}

		$reservation = $this->Reservation->getAllReservation('first', [
			'Reservation.id' => $id,
			'Reservation.user_to' =>  $this->Auth->user('id')
		]);
		
		$limit = $this->Reservation->Message->find('count', [
			'conditions' => [
				'Message.reservation_id' => $id,
			],
			'callbacks' => false,
			'recursive' => -1
		]);

		if ($limit <= 1) {
			$limit = 0;
		} else {
			$limit = $limit - 1;
		}

		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Reservation->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Reservation->Property->bindModel([
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
		$conversation = $this->Reservation->Message->find('all', array(
			'conditions' => array(
				'Message.reservation_id' => $id,
			),
			'contain' => array(
				'UserBy',
				'UserTo',
				'Reservation',
				'Property' => [
					'PropertyTranslation'
				]
			),
			'order' => array('Message.id' => 'desc'),
			'limit' => $limit,
		));

		$query = $this->Reservation->Message->find('first', [
			'conditions' => [
				'Message.reservation_id' => $id,
				'Message.conversation_id' => 0,
			],
			'contain' => array(
				'Reservation',
				'Property'
			),
			'order' => array('Message.id' => 'desc')
		]);

		$this->set(compact('query', 'conversation', 'reservation'));
	}

/**
 * request_sent From Traveler To HOST method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function request_sent($id = null) {
		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		if ($this->Reservation->checkExpire($id) === 'pending_approval') {
			$this->Reservation->expire($id);
		}

		if ($this->request->is(array('post', 'put'))) {

			if ($this->request->data['Reservation']['reservation_id'] != 0) {
				$insertData = array(
					'property_id'    => $this->request->data['Reservation']['property_id'],
					'reservation_id' => $this->request->data['Reservation']['reservation_id'],
					'user_by'        => $this->request->data['Reservation']['user_by'],
					'user_to'        => $this->request->data['Reservation']['user_to'],
					'message'        => EMCMS_escape($this->request->data['Reservation']['message']),
					'subject'        => __('Reservation request.'),
					'message_type'   => 'reservation_request'
				);
			} elseif ($this->request->data['Reservation']['contact_id'] != 0) {
				$insertData = array(
					'property_id'    => $this->request->data['Reservation']['property_id'],
					'contact_id' 	 => $this->request->data['Reservation']['contact_id'],
					'user_by'        => $this->request->data['Reservation']['user_by'],
					'user_to'        => $this->request->data['Reservation']['user_to'],
					'message'        => $this->request->data['Reservation']['message'],
					'subject'        => __('Reservation request.'),
					'message_type'   => 'reservation_request'
				);
			} elseif (($this->request->data['Reservation']['reservation_id'] == 0) && ($this->request->data['Reservation']['contact_id'] == 0)) {
				$insertData = array(
					'property_id'    => $this->request->data['Reservation']['property_id'],
					'conversation_id'=> $this->request->data['Reservation']['property_id'],
					'user_by'        => $this->request->data['Reservation']['user_by'],
					'user_to'        => $this->request->data['Reservation']['user_to'],
					'message'        => EMCMS_escape($this->request->data['Reservation']['message']),
					'subject'        => __('List Creation'),
					'message_type'   => 'list_creation'
				);
			}

			// update message
			$this->Reservation->Message->updateAll(
				array(
					'Message.is_respond'=> 1
				),
				array(
					'Message.conversation_id' => $id,
					'Message.user_to' => $this->request->data['Reservation']['user_by']
				)
			);

			$insertData['Message'] = $insertData;
			$this->Reservation->Message->create();
			if ($this->Reservation->Message->sentMessage($insertData, 1)) {
				$this->Flash->success(__('Message has been sent.'));
			} else {
				$this->Flash->error(__('Message could not be sent. Please, try again.'));
			}

			return $this->redirect(array('action' => 'request_sent', $id));
		}

		$reservation = $this->Reservation->getAllReservation('first', [
			'Reservation.id' => $id,
			'Reservation.user_by' =>  $this->Auth->user('id')
		]);

		// debug($reservation);
		// die();


		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();

		$limit = $this->Reservation->Message->find('count', [
			'conditions' => [
				'Message.conversation_id' => $id,
			],
			'order' => array('Message.id' => 'asc')
		]);

		if ($limit <= 1) {
		} else {
			$limit = $limit - 1;
		}

		$this->Reservation->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Reservation->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => false,
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);
		$conversation = $this->Reservation->Message->find('all', array(
			'conditions' => array(
				'Message.reservation_id' => $id,
			),
			'contain' => array(
				'UserBy',
				'UserTo',
				'Reservation',
				'Property' => [
					'PropertyTranslation'
				]
			),
			'order' => array('Message.id' => 'desc'),
			'limit' => $limit
		));

		$query = $this->Reservation->Message->find('first', array(
			'conditions' => array(
				'Message.conversation_id' => $id
			),
			'contain' => array(
				'Reservation',
				'Property'
			),
			'order' => array('Message.id' => 'asc')
		));

		$this->set(compact('query', 'conversation', 'reservation'));
	}

/**
 * accept By Host method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function accept($id = null) {
		$this->layout = null;
		$this->autoRender = false;

		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		// check if the reservation belongs to this user as host
		if (!$this->Reservation->isOwnedByHost($id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation.'));
		}

		$message = '';
		if (isset($this->request->data['Reservation']['message'])) {
			$message = EMCMS_escape($this->request->data['Reservation']['message']);
		}

		$this->request->allowMethod('post', 'put', 'ajax');

		if ($this->Reservation->accept($id, $message)) {
			$this->Flash->success(__('The reservation has been accepted.'));
		} else {
			$this->Flash->error(__('The reservation could not be accepted. Please, try again.'));
		}

		if ($this->request->is('ajax')){
			return json_encode(['error'=>false, 'message' => __('Action performed')]);
		} else {
			return $this->redirect(array('action' => 'my_reservations'));
		}
	}

/**
 * decline By Host method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function decline($id = null) {
		$this->layout = null;
		$this->autoRender = false;

		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		if (!$this->Reservation->isOwnedByHost($id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation.'));
		}

		$message = '';
		if (isset($this->request->data['Reservation']['message'])) {
			$message = EMCMS_escape($this->request->data['Reservation']['message']);
		}

		$this->request->allowMethod('post', 'put', 'ajax');

		if ($this->Reservation->decline($id, $message)) {
			$this->Flash->success(__('The reservation has been declined.'));
		} else {
			$this->Flash->error(__('The reservation could not be declined. Please, try again.'));
		}

		if ($this->request->is('ajax')){
			return json_encode(['error'=>false, 'message' => __('Action performed')]);
		} else {
			return $this->redirect(array('action' => 'my_reservations'));
		}
	}

/**
 * cancel_by_host method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function cancel_by_host($id = null) {
		$this->layout = null;
		$this->autoRender = false;

		$this->Reservation->id = $id;
		if (!$this->Reservation->exists()) {
			throw new NotFoundException(__('Invalid reservation'));
		}
		$this->request->allowMethod('post', 'put', 'ajax');

		if (!$this->Reservation->isOwnedByHost($id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation'));
		}

		if ($this->Reservation->cancel_by_host()) {
			$this->Flash->success(__('The reservation has been cancelled.'));
		} else {
			$this->Flash->error(__('The reservation could not be cancelled. Please, try again.'));
		}

		if ($this->request->is('ajax')){
			return json_encode(['error'=>false, 'message' => __('Action performed')]);
		} else {
			return $this->redirect(array('action' => 'my_reservations'));
		}
	}

/**
 * review_by_host method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function review_by_host($reservation_id = null) {
		// check if reservation exist
		if (!$this->Reservation->exists($reservation_id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		// checkin if this host has access to this reservation
		if (!$this->Reservation->isOwnedByHost($reservation_id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation'));
		}

		if ($this->request->is(array('post', 'put'))) {
			// get reservation
			$options = array(
				'contain' => array(
					'Traveler',
					'Host'
				),
				'conditions' =>  array(
					'Reservation.' . $this->Reservation->primaryKey => $reservation_id,
					'Reservation.user_to' => $this->Auth->user('id')
				)
			);
			$reservation = $this->Reservation->find('first', $options);

			// update reservation status
			$this->Reservation->id = $reservation_id;
			$this->Reservation->saveField('reservation_status', 'completed');

			//Send Message Notification to Traveler
			$insertData = array(
				'property_id'     => $reservation['Reservation']['property_id'],
				'reservation_id'  => $reservation_id,
				'user_by'         => $reservation['Reservation']['user_to'],
				'user_to'         => $reservation['Reservation']['user_by'],
				'subject'         => __('Review Request'),
				'message'         => __('%s, gives the reviews for you.', $reservation['Host']['name']),
				'message_type'   => 'review_by_traveller'
			);
			$insertData['Message'] = $insertData;
			$this->Reservation->Message->sentMessage($insertData);

			// update message
			$this->Reservation->Message->updateAll(
				array(
					'Message.is_respond'=> 1
				),
				array(
					'Message.reservation_id' => $reservation_id,
					'Message.user_to'=> $reservation['Reservation']['user_to']
				)
			);

			// prepare review
			$this->request->data['Review']['reservation_id'] = $reservation_id;
			$this->request->data['Review']['user_by'] 	= $reservation['Reservation']['user_to'];
			$this->request->data['Review']['user_to'] 	= $reservation['Reservation']['user_by'];
			$this->request->data['Review']['model_id'] 	= $reservation['Reservation']['property_id'];
			$this->request->data['Review']['model'] 	= 'Property';
			$this->request->data['Review']['review_by'] = 'host';

			// save review of the host
			if ($this->Reservation->Review->save($this->request->data)) {
				$this->Flash->success(__('Your review has been saved successfully.'));
				return $this->redirect(array('action' => 'my_reservations'));
			} else {
				$this->Flash->error(__('Your review could not be saved. Please, try again.'));
			}
		} else {
			$reservation = $this->Reservation->find('first', array(
				'conditions' => array(
					'Reservation.'.$this->Reservation->primaryKey => $reservation_id,
					'Reservation.user_to' => $this->Auth->user('id')
				)
			));

			if ('awaiting_host_review' !== $reservation['Reservation']['reservation_status']) {
				$this->Flash->error(__('You can not leave review now. Please, try again.'));
				return $this->redirect(array('action' => 'my_reservations'));
			}
		}

		$this->set(compact('reservation', 'reservation_id'));
	}

/**
 * cancel_by_traveler method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function cancel_by_traveler($id = null) {
		$this->layout = null;
		$this->autoRender = false;

		$this->Reservation->id = $id;
		if (!$this->Reservation->exists()) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		$this->request->allowMethod('post', 'put', 'ajax');

		if (!$this->Reservation->isOwnedByTraveler($id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation'));
		}

		if ($this->Reservation->cancel_by_traveler($id)) {
			$this->Flash->success(__('The reservation has been cancelled.'));
		} else {
			$this->Flash->error(__('The reservation could not be cancelled. Please, try again.'));
		}

		if ($this->request->is('ajax')){
			return json_encode(['error'=>false, 'message' => __('Action performed')]);
		} else {
			return $this->redirect(array('action' => 'my_trips'));
		}

	}

/**
 * pay_host method from Traveler
 *
 * This method is used to proceed with payment
 * for different paymentmethod for pre-booking request
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function pay_host($id = null) {
		$this->autoRender = false;

		$this->request->allowMethod('post', 'put', 'ajax');

		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		if (!$this->Reservation->isOwnedByTraveler($id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation'));
		}

		if ($this->Reservation->checkExpire($id) === 'payment_pending') {
			$this->Reservation->expire($id);
		}

		$payment_method = 'not_defined';
		if (isset($this->request->data['Reservation']['payment_method'])) {
			$payment_method = EMCMS_strtolower($this->request->data['Reservation']['payment_method']);
		}

		if (!in_array($payment_method, ['paypal', 'twocheckout', 'stripe', 'credit_card'], true)) {
			throw new NotImplementedException(__('Payment method not implemented!'));
		}

		if ($payment_method === 'credit_card') {
			$this->Flash->warning(__('This payment method (%s) has not been implemented yet!', Inflector::humanize($payment_method)));
			return $this->redirect($this->referer());
		}

		$reservation = $this->Reservation->getReservation($id);
		// payment method (paypal/stripe/credit_card) and country
		$reservation['Reservation']['payment_method'] = $payment_method;
		$reservation['Reservation']['payment_country'] = $this->request->data['Reservation']['payment_country'];

		// we check availability within these dates
		if (!$this->Reservation->Property->Calendar->checkAvailability($reservation['Property']['id'], $reservation['Reservation']['checkin'], $reservation['Reservation']['checkout'])) {

			$this->Reservation->id = $id;
			$this->Reservation->saveField('reservation_status', 'expired');

			// if these dates has alredy been booked by someone else
			// we expire this request for reservation
			$this->Reservation->expire($id);

			$this->Flash->error(__('Those dates are no longer available.'));
			return $this->redirect(array('action' => 'my_trips'));
		}

		if ('paypal' === $payment_method) {
			try {
				$this->Paypal = new Paypal([
					'sandboxMode' => Configure::read('PayPal.SANDBOX_flag'),
					'nvpUsername' => Configure::read('PayPal.API_username'),
					'nvpPassword' => Configure::read('PayPal.API_password'),
					'nvpSignature'=> Configure::read('PayPal.API_signature'),
				]);

				$toBook = [
					'description'=> __('Booking from %s Site', Configure::read('Website.name')),
					'currency'	=> $reservation['Reservation']['currency'],
					'return' 	=> Configure::read('PayPal.RETURN_url').'/'.$reservation['Reservation']['id'],
					'cancel' 	=> Configure::read('PayPal.CANCEL_url').'/'.$reservation['Reservation']['id'],
					'shipping' 	=> '0',
					'locale' 	=> $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageCode(),
					// 'custom' 	=> 'Erland Muchasaj',
				];

				$temp_product = array(
					'name' 		=> isset($reservation['Property']['PropertyTranslation']['title']) ? H($reservation['Property']['PropertyTranslation']['title']) : 'Transaction.',
					'description'=> isset($reservation['Property']['PropertyTranslation']['description']) ? stripAllHtmlTags($reservation['Property']['PropertyTranslation']['description']) : 'Booking transaction.',
					'number' 	=> $reservation['Reservation']['id'],
					'subtotal' 	=> $reservation['Reservation']['total_price'],
					'tax' 		=> 0,
					'qty' 		=> 1,
				);
				$toBook['items'][] = $temp_product;

				$this->Session->write('reservation_id', $reservation['Reservation']['id']);

				$redirectUrl = $this->Paypal->setExpressCheckout($toBook);

				return $this->redirect($redirectUrl);
			} catch (Exception $e) {
				$this->Flash->error(__("PayPal misconfigured: %s. Please contact support.", $e->getMessage()));
				return $this->redirect(array('action' => 'my_trips'));
			}
		} elseif ('stripe' === $payment_method) {
			$stripe = isset($this->request->data['Stripe']) ? $this->request->data['Stripe'] : null;
			return $this->stripe($reservation, $stripe);
		} elseif ('twocheckout' === $payment_method) {
			# code...
		} elseif ('credit_card' === $payment_method) {
			# code...
		} else {
			throw new BadRequestException(__('This payment method (%s) is not implemented.', $payment_method));
		}
	}

	/**
	 * Stripe
	 * Handle strupe payment workflow;
	 * @param  array $reservation
	 * @param  array $stripe     
	 * @return void
	 */
	public function stripe($reservation = null, $stripe = null) {
		$this->autoRender = false;

		$datasource = $this->Reservation->getDataSource();

		try {
		    $datasource->begin();

			// we check availability within these dates
			if (!$this->Reservation->Property->Calendar->checkAvailability($reservation['Property']['id'], $reservation['Reservation']['checkin'], $reservation['Reservation']['checkout'])) {
				$this->Flash->error(__('Those dates are no longer available.'));
				return $this->redirect(array('controller' => 'properties', 'action' => 'view', $reservation['Property']['id']));
			}

			// if we do have availability then proceed with the money collection
			$card = [
				'number' => $stripe['card_number'],
				'exp_month' => $stripe['expire']['month'],
				'exp_year' => $stripe['expire']['year'],
				'cvc' => $stripe['security_code'], // cvc
			];
			$token = $this->Stripe->createCardToken($card);
			if ($token['status'] !== 'success') {

				$datasource->rollback();

				$this->Flash->error($token['message']);
				return $this->redirect(['controller' => 'properties', 'action' => 'view', $reservation['Property']['id']]);
			}

			$data = [
				'card' 		  => $token['response']['id'],
				'currency'    => EMCMS_strtolower($reservation['Reservation']['currency']),
				'amount'      => $this->Stripe->getCents($reservation['Reservation']['total_price']),
				'description' => __('Booking from %s Site', Configure::read('Website.name')),
				'reservation' => $reservation['Reservation'],
				// Whether to immediately capture the charge. Defaults to true. 
				// 'capture' => true, 
				// Many objects contain the ID of a related object in their response properties. 
				// 'expand' => ['customer'],
			];
			$charge = $this->Stripe->charge($data);

			if ($charge['status'] !== 'success') {

				$datasource->rollback();

				$this->Flash->error($charge['message']);
				return $this->redirect(['controller' => 'properties', 'action' => 'view', $reservation['Property']['id']]);
			}

			/**
			 * @todo Implement or test later
			 */
			$reservation['Reservation']['transaction_id'] = $charge['response']['id'];

			$reservation['Reservation']['payer_id'] = $charge['response']['customer'];
			$reservation['Reservation']['payer_email'] = $charge['response']['receipt_email'];
			$reservation['Reservation']['payer_email'] = $charge['response']['receipt_email'];

			// populate data comming from stripe
			if ($charge['response']['captured'] != true) {

				$datasource->rollback();

				$this->Flash->success(__('Reservation Completed! Proceed with the payment.'));
				$this->set(compact('reservation'));
				return $this->render('success');
			}

			$reservation['Reservation']['is_payed'] = true;
			$reservation['Reservation']['payed_date'] = date('Y-m-d H:i:s');
			$reservation['Reservation']['payment_method'] = 'stripe';
			$reservation['Reservation']['reservation_status'] = 'payment_completed';

			$today   = get_gmt_time(strtotime(date("Y-m-d")));
			$checkin = get_gmt_time(strtotime($reservation['Reservation']['checkin']));
			if ($checkin <= $today) {
				$reservation['Reservation']['reservation_status'] = 'awaiting_checkin';
			}


			$date1 = new DateTime(date('Y-m-d H:i:s', strtotime($reservation['Reservation']['checkin'])));
			$date2 = new DateTime(date('Y-m-d H:i:s', strtotime($reservation['Reservation']['checkout'])));
			$interval = $date1->diff($date2);
			if ($interval->days >= 28) {
				$reservation['Reservation']['cancellation_policy_id'] = 5;
			} else {
				$reservation['Reservation']['cancellation_policy_id'] = $reservation['Property']['cancellation_policy_id'];
			}

			$calendar = $this->Reservation->Property->Calendar->find('first', ['conditions' => array('Calendar.property_id'=> $reservation['Property']['id'])]);
			if (isset($calendar['Calendar']['calendar_data']) && !empty($calendar['Calendar']['calendar_data'])) {
				$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
			} else {
				$decoded = [];
			}
			$start_date = $reservation['Reservation']['checkin'];
			$checkout_time = strtotime($reservation['Reservation']['checkout']);
			while (strtotime($start_date) < $checkout_time) {
				if (isset($decoded[$start_date])) {
					$decoded[$start_date]['status'] = 'booked';
				} else {
					$temp_product = array(
						"bind" 	  => 0,
						"info" 	  => "",
						"notes"   => "",
						"price"   => "",
						"promo"   => "",
						"status"  => "booked",
						"booked_using" =>"portal",
						"user_id" => $reservation['Traveler']['id'],
					);
					$decoded[$start_date] = $temp_product;
				}
				if (isset($temp_product)) {
					unset($temp_product);
				}
				$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
			}
			$encoded = json_encode($decoded);

			//Construct Calendar object to save in DB
			$calendar['Calendar']['id'] = $reservation['Property']['id'];
			$calendar['Calendar']['property_id'] = $reservation['Property']['id'];
			$calendar['Calendar']['calendar_data'] = $encoded;
			if ($this->Reservation->save($reservation) && $this->Reservation->Property->Calendar->save($calendar)) {

				//Send Message Notification to Host
				$insertData = array(
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_by'],
					'user_to'         => $reservation['Reservation']['user_to'],
					'subject'         => __('Reservation Request.'),
					'message'         => __('You have a new reservation from %s for %s.', array($reservation['Traveler']['name'], $reservation['Property']['address'])),
					'message_type'   => 'reservation_request'
				);
				$insertData['Message'] = $insertData;
				$this->Reservation->Message->sentMessage($insertData);

				$datasource->commit();

				$this->Flash->success(__('Reservation Completed! Enjoy your staying.'));
			} else {
				
				$datasource->rollback();

				$this->Flash->error(__('Reservation Completed with errors, (Data could not be saved on Database)!'));
			}


			$this->set(compact('reservation'));
			$this->render('view');
		} catch (Exception $e) {

			$datasource->rollback();

			$this->Flash->error($e->getMessage());
			return $this->redirect(['controller' => 'properties', 'action' => 'view', $reservation['Property']['id']]);
		}
	}


/**
 * checkin Traveler method
 *
 * This method is used to proceed with checkin
 * of the traveler for a specific reservation
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function checkin($id = null) {
		$this->layout = null;
		$this->autoRender = false;

		$this->Reservation->id = $id;
		if (!$this->Reservation->exists()) {
			throw new NotFoundException(__('Invalid reservation'));
		}
		$this->request->allowMethod('post', 'put', 'ajax');
		if (!$this->Reservation->isOwnedByTraveler($id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation'));
		}

		if ($this->Reservation->checkin($id)) {
			$this->Flash->success(__('You have successfully checkin to this reservation. Enjoy tour staying.'));
		} else {
			$this->Flash->error(__('You could not checkin. Please, try again.'));
		}

		if ($this->request->is('ajax')){
			return json_encode(['error'=>false, 'message' => __('Action performed')]);
		} else {
			return $this->redirect(array('action' => 'my_trips'));
		}
	}

/**
 * checkout Traveler method
 *
 * This method is used to proceed with checkout
 * of the traveler for a specific reservation
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function checkout($id = null) {
		$this->layout = null;
		$this->autoRender = false;

		$this->Reservation->id = $id;
		if (!$this->Reservation->exists()) {
			throw new NotFoundException(__('Invalid reservation'));
		}
		if (!$this->Reservation->isOwnedByTraveler($id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation'));
		}

		$this->request->allowMethod('post', 'put', 'ajax');
		if ($this->Reservation->checkout($id)) {
			$this->Flash->success(__('You are successfully checked out. Now you can proceed to leave a review.'));
		} else {
			$this->Flash->error(__('You could not checkout. Please, try again.'));
		}

		if ($this->request->is('ajax')){
			return json_encode(['error'=>false, 'message' => __('Action performed')]);
		} else {
			return $this->redirect(array('action' => 'my_trips'));
		}
	}

/**
 * expire Host method
 *
 * This method is used to proceed with expire
 * of the traveler reservation
 *
 * @throws NotFoundException
 * @param int $id
 * @return void
 */
	public function expire($id = null) {
		$this->layout = null;
		$this->autoRender = false;

		$this->Reservation->id = $id;
		if (!$this->Reservation->exists()) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		$this->request->allowMethod('post', 'put', 'ajax');
		if ($this->Reservation->expire($id)) {
			$this->Flash->success(__('You have successfully checkin to this reservation. Enjoy tour staying.'));
		} else {
			$this->Flash->error(__('You could not checkin. Please, try again.'));
		}

		if ($this->request->is('ajax')){
			return json_encode(['error'=>false, 'message' => __('Action performed')]);
		} else {
			return $this->redirect(array('action' => 'my_trips'));
		}
	}

/**
 * review_by_traveler method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function review_by_traveler($reservation_id = null) {
		// check if reservation exist
		if (!$this->Reservation->exists($reservation_id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		// checkin if this traveler has access to this reservation
		if (!$this->Reservation->isOwnedByTraveler($reservation_id, $this->Auth->user('id'))) {
			throw new ForbiddenException(__('You dont have access on this reservation'));
		}

		if ($this->request->is(array('post', 'put'))) {

			// get reservation
			$options = array(
				'contain' => array(
					'Traveler',
					'Host',
					//'Property',
					//'CancellationPolicy',
				),
				'conditions' =>  array(
					'Reservation.' . $this->Reservation->primaryKey => $reservation_id,
					'Reservation.user_by' => $this->Auth->user('id')
				)
			);
			$reservation = $this->Reservation->find('first', $options);

			// update reservation status
			$this->Reservation->id = $reservation_id;
			$this->Reservation->saveField('reservation_status', 'awaiting_host_review');

			//Send Message Notification to Traveler
			$insertData = array(
				'property_id'     => $reservation['Reservation']['property_id'],
				'reservation_id'  => $reservation_id,
				'user_by'         => $reservation['Reservation']['user_by'],
				'user_to'         => $reservation['Reservation']['user_to'],
				'subject'         => __('Review Request'),
				'message'         => __('%s, wants a review from you.', $reservation['Traveler']['name']),
				'message_type'   => 'review_by_host'
			);
			$insertData['Message'] = $insertData;
			$this->Reservation->Message->sentMessage($insertData);

			// update message
			$this->Reservation->Message->updateAll(
				array(
					'Message.is_respond'=> 1
				),
				array(
					'Message.reservation_id' => $reservation_id,
					'Message.user_to'=> $reservation['Reservation']['user_to']
				)
			);

			// prepare review
			$this->request->data['Review']['reservation_id'] = $reservation_id;
			$this->request->data['Review']['user_by'] 	= $reservation['Reservation']['user_by'];
			$this->request->data['Review']['user_to'] 	= $reservation['Reservation']['user_to'];
			$this->request->data['Review']['model_id'] 	= $reservation['Reservation']['property_id'];
			$this->request->data['Review']['model'] 	= 'Property';
			$this->request->data['Review']['review_by'] = 'guest';

			// save traveler review
			if ($this->Reservation->Review->save($this->request->data)) {
				$this->Flash->success(__('Your review has been saved successfully.'));
				return $this->redirect(array('action' => 'my_trips'));
			} else {
				$this->Flash->error(__('Your review could not be saved. Please, try again.'));
			}
		} else {
			$reservation = $this->Reservation->find('first', array(
				'conditions' => array(
					'Reservation.'.$this->Reservation->primaryKey => $reservation_id,
					'Reservation.user_by' => $this->Auth->user('id')
				)
			));

			if ('awaiting_traveler_review' !== $reservation['Reservation']['reservation_status']) {
				$this->Flash->error(__('You can not leave review now. Please, try again.'));
				return $this->redirect(array('action' => 'my_trips'));
			}
		}
		$this->set(compact('reservation', 'reservation_id'));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($search = null) {

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if ($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = [];
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'admin_index', $this->request->data['Reservation']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array(
				'Property.address LIKE' => '%' . trim($search) . '%',
				'Reservation.confirmation_code LIKE' => '%' . trim($search) . '%',
				'Traveler.name LIKE' => '%' . trim($search) . '%',
				'Traveler.surname LIKE' => '%' . trim($search) . '%',
				'Traveler.email LIKE' => '%' . trim($search) . '%',
			);
		}

		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Reservation->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Reservation->Property->bindModel([
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
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'PropertyTranslation'
				],
				'CancellationPolicy',
			),
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Reservation.created' => 'DESC'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
		);
		$reservations = $this->Paginator->paginate();
		$this->set(compact('reservations', 'search'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}

		$language_id = $this->Reservation->Property->PropertyTranslation->Language->getActiveLanguageId();
		// Room Type
		$this->Reservation->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Reservation->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => false,
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			]
		]);
		$reservation = $this->Reservation->find('first', [
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'PropertyTranslation'
				],
				'CancellationPolicy',
			),
			'conditions' => [
				'Reservation.'.$this->Reservation->primaryKey => $id,
			],
			'limit' => 1
		]);

		$this->set(compact('reservation'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Reservation->create();
			if ($this->Reservation->save($this->request->data)) {
				$this->Flash->success(__('The reservation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The reservation could not be saved. Please, try again.'));
			}
		}
		$properties = $this->Reservation->Property->find('list');
		$cancellationPolicies = $this->Reservation->CancellationPolicy->find('list');
		$this->set(compact('properties', 'cancellationPolicies'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Reservation->exists($id)) {
			throw new NotFoundException(__('Invalid reservation'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Reservation->save($this->request->data)) {
				$this->Flash->success(__('The reservation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The reservation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Reservation.' . $this->Reservation->primaryKey => $id));
			$this->request->data = $this->Reservation->find('first', $options);
		}
		$properties = $this->Reservation->Property->find('list');
		$cancellationPolicies = $this->Reservation->CancellationPolicy->find('list');
		$this->set(compact('properties', 'cancellationPolicies'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Reservation->id = $id;
		if (!$this->Reservation->exists()) {
			throw new NotFoundException(__('Invalid reservation'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Reservation->delete()) {
			$this->Flash->success(__('The reservation has been deleted.'));
		} else {
			$this->Flash->error(__('The reservation could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
