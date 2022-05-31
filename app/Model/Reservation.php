<?php
App::uses('AppModel', 'Model');
/**
 * Reservation Model
 *
 * @property Property $Property
 * @property CancellationPolicy $CancellationPolicy
 * @property Message $Message
 */
class Reservation extends AppModel {

/**
 * Reservations Statuses
 *
 * payment_pending 		//
 * pending_approval 	//
 * declined 			// (rejected)
 * accepted 			// (confirmed)
 * expired				//
 * payment_completed 	// (confirmed)
 * canceled_by_host 	// (canceled) / (canceled_by_admin)
 * canceled_by_traveler // (canceled)
 * awaiting_checkin (new)
 * checkin 				// (attended)
 * awaiting_traveler_review
 * awaiting_host_review
 * completed
 *
 */

/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Reservation';

/**
 * User Table
 *
 * @var string
 */
	public $useTable = 'reservations';

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
	public $displayField = 'confirmation_code';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'you can not modify directly the reservation id.',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_by' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Traveler id name can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_to' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Host id can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'property_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Property id can not be empty.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'confirmation_code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Tracking code can not be empty.',
				'allowEmpty' => false
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Reservation with the same tracking code allredy exists.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Traveler' => array(
			'className' => 'User',
			'foreignKey' => 'user_by',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'Host' => array(
			'className' => 'User',
			'foreignKey' => 'user_to',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Property' => array(
			'className' => 'Property',
			'foreignKey' => 'property_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
		'CancellationPolicy' => array(
			'className' => 'CancellationPolicy',
			'foreignKey' => 'cancellation_policy_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
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
			'foreignKey' => 'reservation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Review' => array(
			'className' => 'Review',
			'foreignKey' => 'reservation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	/**
	 * Reservation statuses stuff functions
	 *
	 * @var array
	 */
	public function getAllReservation($type = 'all', $conditions = null, $fields = array(), $order = null) {

		$order = array_merge(
			array('Reservation.id' => 'desc'),
			(array)$order
		);

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);

		$this->Property->bindModel([
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

		$options = array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'Price',
					'Address',
					'Currency',
					'PropertyTranslation',
				],
				'CancellationPolicy',
			),
			'conditions' => $conditions,
			'fields' => $fields,
			'order' => $order,
		);
		return $this->find($type, $options);
	}

	public function getReservation($id = null) {
		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);

		$this->Property->bindModel([
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

		$options = array(
			'contain' => array(
				'Host',
				'Traveler',
				'Property' => [
					'Price',
					'Currency',
					'Address',
					'PropertyTranslation',
				],
				'CancellationPolicy',
			),
			'conditions' =>  array('Reservation.' . $this->primaryKey => $id),
			'order' => array('Reservation.id' => 'desc'),
			// 'recursive' => -1,
		);
		return $this->find('first', $options);
	}

	public function isOwnedByHost($reservation_id, $user_to) {
		return (bool)($this->field('Reservation.id', array('Reservation.' . $this->primaryKey => $reservation_id, 'Reservation.user_to' => $user_to)) === $reservation_id);
	}

	public function isOwnedByTraveler($reservation_id, $user_by) {
		return (bool)($this->field('Reservation.id', array('Reservation.' . $this->primaryKey => $reservation_id, 'Reservation.user_by' => $user_by)) === $reservation_id);
	}

	// host functions
	public function accept($id, $custom_message = '') {
		$siteEmail  = Configure::read('Website.email');
		$reservation = $this->getReservation($id);
		// we must check if the user accessing these function
		//  has access to this reservation and also is hsot or traveler
		if ($reservation && ('pending_approval' === $reservation['Reservation']['reservation_status'])) {
			// update reservation data
			$this->id = $id;
			if ($this->saveField('reservation_status', 'payment_pending')) {

				// we make dates unavailable for others to book.
				$this->Property->Calendar->bookDates($id, $reservation['Reservation']['checkin'], $reservation['Reservation']['checkout'], $reservation['Traveler']['id']);

				//Send Message Notification to Traveler
				$insertData = array(
					'property_id'    => $reservation['Reservation']['property_id'],
					'reservation_id' => $reservation['Reservation']['id'],
					// 'conversation_id'=> $reservation['Reservation']['id'],
					'user_by'        => $reservation['Reservation']['user_to'],
					'user_to'        => $reservation['Reservation']['user_by'],
					'subject'        => __('Congratulation, Your reservation request is granted by %s for %s.', array($reservation['Host']['name'], $reservation['Property']['address'])),
					'message'        => $custom_message,
					'message_type'   => 'request_sent'
				);
				$insertData['Message'] = $insertData;
				$this->Message->sentMessage($insertData);
				// update message of the host
				$this->Message->updateAll(
					array(
						'Message.is_respond'=> 1
					),
					array(
						'Message.reservation_id' => $reservation['Reservation']['id'],
						'Message.user_to'=> $reservation['Reservation']['user_to']
					)
				);

				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\r\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message .= "\r\n".__('Congratulation, Your reservation request with id (#%s) has been granted.', $reservation['Reservation']['id']);
				$message .= "\r\n".__('Please proceed with the payment,');
				$message .= "\r\n".$custom_message;
				$message .= "\r\n".__('Enjoy your staying,');
				$message .= "\r\n".__('Thanks and Regards.');
				$message .= "\r\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation granted'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\r\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\r\n".__('You have succesfully granted rreservation request with id (#%s).', $reservation['Reservation']['id']);
				$message .= "\r\n".__('Thanks and Regards');
				$message .= "\r\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation granted'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);

				// Send Mail To Administrator
				$viewVars = array('reservation' => $reservation);
				$message  = "\r\n".__('Hello Administrator,');
				$message .= "\r\n".__('Rreservation request with id (#%s) from %s to %s has been granted.', array($reservation['Reservation']['id'], $reservation['Traveler']['name'], $reservation['Host']['name']));
				$message .= "\r\n".__('Thanks and Regards');
				$message .= "\r\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation granted'),// email subject,
					'content' => $message
				);
				parent::__sendMail($siteEmail, $optionsEmail);

				return true;
			}
		}
		return false;
	}

	public function decline($id, $custom_message = '') {
		$siteEmail  = Configure::read('Website.email');
		$reservation = $this->getReservation($id);
		if ($reservation && $reservation['Reservation']['reservation_status'] === 'pending_approval') {
			$this->id = $id;
			if ($this->saveField('reservation_status', 'declined')) {
				// things to do here
				// update calendar to remove booked dates
				// send message notification to Traveler
				// update message for host
				// Refund reservation ID
				//  Send Email to traveler
				//  Send email to Host
				//  Send Email to Administrator

				$this->Property->Calendar->resetCalendarDays(
					$reservation['Reservation']['property_id'],
					$reservation['Reservation']['checkin'],
					$reservation['Reservation']['checkout'],
					$reservation['Property']['price']
				);

				//Send Message Notification to Traveler
				$insertData = array(
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_to'],
					'user_to'         => $reservation['Reservation']['user_by'],
					'subject'         => __('Sorry, Your reservation request is declined by %s for %s.', array($reservation['Host']['name'], $reservation['Property']['address'])),
					'message'        => $custom_message,
					'message_type'   => 'request_sent'
				);
				$insertData['Message'] = $insertData;
				$this->Message->sentMessage($insertData);
				// update message
				$this->Message->updateAll(
					array(
						'Message.is_respond'=> 1
					),
					array(
						'Message.reservation_id' => $reservation['Reservation']['id'],
						'Message.user_to'=> $reservation['Reservation']['user_to']
					)
				);

				// payment_helper called for refund amount for host and guest as per host and guest cancellation policy
				// refund($id);

				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message .= "\n".__('Sorry, Your reservation request with id (#%s) has been decline.', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards,');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation decline'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\n".__('Rreservation request with id (#%s) has been decline.', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation decline'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);

				// Send Mail To Administrator
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello Administrator,');
				$message .= "\n".__('Rreservation request with id (#%s) from %s to %s has been decline.', array($reservation['Reservation']['id'], $reservation['Traveler']['name'], $reservation['Host']['name']));
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation decline'),// email subject,
					'content' => $message
				);
				parent::__sendMail($siteEmail, $optionsEmail);

				return true;
			}
		}
		return false;
	}

	public function cancel_by_host($id = null) {
		$siteEmail  = Configure::read('Website.email');
		$reservation = $this->getReservation($id);
		if (
			$reservation &&
			($reservation['Reservation']['reservation_status'] === 'pending_approval' ||
				$reservation['Reservation']['reservation_status'] === 'payment_completed')
		) {
			$this->id = $id;
			if ($this->saveField('reservation_status', 'canceled_by_host')) {
				// things to do here
				// update calendar to remove booked dates
				// send message notification to Traveler
				// update message for host
				// Refund reservation ID
				// Send Email to traveler
				// Send email to Host
				// Send Email to Administrator

				$this->Property->Calendar->resetCalendarDays(
					$reservation['Reservation']['property_id'],
					$reservation['Reservation']['checkin'],
					$reservation['Reservation']['checkout'],
					$reservation['Property']['price']
				);

				//Send Message Notification to Traveler
				$insertData = array(
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_to'],
					'user_to'         => $reservation['Reservation']['user_by'],
					'subject'         => __('Reservation Canceled'),
					'message'         => __('Sorry, Your reservation request is canceled by %s for %s.', array($reservation['Host']['name'], $reservation['Property']['address'])),
					'message_type'   => 'request_sent'
				);
				$insertData['Message'] = $insertData;
				$this->Message->sentMessage($insertData);
				// update message
				$this->Message->updateAll(
					array(
						'Message.is_respond'=> 1
					),
					array(
						'Message.reservation_id' => $reservation['Reservation']['id'],
						'Message.user_to'=> $reservation['Reservation']['user_to']
					)
				);

				// payment_helper called for refund amount for host and guest as per host and guest cancellation policy
				// refund($id);

				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message .= "\n".__('Sorry, Your reservation request with id (#%s) has been decline.', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards,');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation decline'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\n".__('Rreservation request with id (#%s) has been decline.', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation decline'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);

				// Send Mail To Administrator
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello Administrator,');
				$message .= "\n".__('Rreservation request with id (#%s) from %s to %s has been decline.', array($reservation['Reservation']['id'], $reservation['Traveler']['name'], $reservation['Host']['name']));
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation decline'),// email subject,
					'content' => $message
				);
				parent::__sendMail($siteEmail, $optionsEmail);

				return true;
			}
		}
		return false;
	}

	// traveler functions
	public function cancel_by_traveler($id = null) {
		$siteEmail  = Configure::read('Website.email');
		$reservation = $this->getReservation($id);
		if (
			$reservation &&
			($reservation['Reservation']['reservation_status'] === 'pending_approval' ||
				$reservation['Reservation']['reservation_status'] === 'payment_completed')
		) {
			$this->id = $id;
			if ($this->saveField('reservation_status', 'canceled_by_traveler')) {
				// things to do here
				// update calendar to remove booked dates
				// send message notification to Traveler
				// update message for host
				// Refund reservation ID
				//  Send Email to traveler
				//  Send email to Host
				//  Send Email to Administrator

				$this->Property->Calendar->resetCalendarDays(
					$reservation['Reservation']['property_id'],
					$reservation['Reservation']['checkin'],
					$reservation['Reservation']['checkout'],
					$reservation['Property']['price']
				);

				//Send Message Notification to Host
				$insertData = array(
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_by'],
					'user_to'         => $reservation['Reservation']['user_to'],
					'subject'         => __('Reservation Canceled'),
					'message'         => __('Sorry, Reservation request by %s for %s is Canceled.', array($reservation['Traveler']['name'], $reservation['Property']['address'])),
					'message_type'   => 'request_sent'
				);
				$insertData['Message'] = $insertData;
				$this->Message->sentMessage($insertData);
				// update message
				$this->Message->updateAll(
					array(
						'Message.is_respond'=> 1
					),
					array(
						'Message.reservation_id' => $reservation['Reservation']['id'],
						'Message.user_to' => $reservation['Reservation']['user_by']
					)
				);

				// payment_helper called for refund amount for host and guest as per host and guest cancellation policy
				// refund($id);

				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message .= "\n".__('Sorry, Your reservation request with id (#%s) was canceled successfuly.', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards,');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation Canceled'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\n".__('Rreservation request with id (#%s) has been canceled.', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation decline'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);

				// Send Mail To Administrator
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello Administrator,');
				$message .= "\n".__('Rreservation request with id (#%s) from %s to %s has been canceled.', array($reservation['Reservation']['id'], $reservation['Traveler']['name'], $reservation['Host']['name']));
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation canceled'),// email subject,
					'content' => $message
				);
				parent::__sendMail($siteEmail, $optionsEmail);

				return true;
			}
		}
		return false;
	}

	public function checkin($id = null) {
		$siteEmail  = Configure::read('Website.email');
		$reservation = $this->getReservation($id);
		if (
			$reservation &&
			('payment_completed' === $reservation['Reservation']['reservation_status'] ||
				'awaiting_checkin' === $reservation['Reservation']['reservation_status'])
		) {
			$this->id = $id;
			if ($this->saveField('reservation_status', 'checkin')) {
				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message .= "\n".__('You successfully checked-in to the reservation (#%d).', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards,');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,   // variables passed to the view
					'subject' => __('Checkin'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\n".__('%s successfully checked-in to your property.', $reservation['Traveler']['name']);
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,   // variables passed to the view
					'subject' => __('Checkin'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);
				return true;
			}
		}
		return false;
	}

	public function checkout($id = null) {
		$reservation = $this->getReservation($id);
		$today    = get_gmt_time(strtotime(date("Y-m-d")));
		$checkout = get_gmt_time(strtotime($reservation['Reservation']['checkout']));
		if (
			$reservation &&
			('checkin' === $reservation['Reservation']['reservation_status']) &&
			($checkout <= $today)
		) {
			$this->id = $id;
			if ($this->saveField('reservation_status', 'awaiting_traveler_review')) {

				//Send Message Notification to Traveler
				$insertData = array(
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_by'],
					'user_to'         => $reservation['Reservation']['user_to'],
					'subject'         => __('Review Request'),
					'message'         => __('%s wants the review from you.', $reservation['Host']['name']),
					'message_type'   => 'review_by_host'
				);
				$insertData['Message'] = $insertData;
				$this->Message->sentMessage($insertData);

				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message .= "\n".__('You successfully checked-out from %s.', $reservation['Property']['address']);
				$message .= "\n".__('Please leave a review and tell us how it went.');
				$message .= "\n".__('Thanks and Regards,');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,   // variables passed to the view
					'subject' => __('Checkin'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\n".__('%s has successfully checked-out from your property.', [$reservation['Traveler']['name'], $reservation['Property']['address']]);
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,   // variables passed to the view
					'subject' => __('Checkin'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);
				return true;
			}
		}
		return false;
	}

	// Cron jobs and refund
	public function refund($id = null) {
		$reservation = $this->getReservation($id);
		if ($reservation) {

		}
		return false;
	}

	public function checkExpire($id = null) {
		return $this->field('reservation_status', array('Reservation.' . $this->primaryKey => $id));
	}

	public function expire($id = null) {

		$siteEmail = Configure::read('Website.email');

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Property->bindModel([
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

		$reservation = $this->find('first', array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'PropertyTranslation'
				],
				'CancellationPolicy',
			),
			'conditions' => array(
				'Reservation.' . $this->primaryKey => $id,
			),
			'order' => array('Reservation.id' => 'desc'),
		));

		$todayDate = date("Y-m-d H:i:s");
		$todayDate = get_gmt_time(strtotime($todayDate));

		$timestamp = $reservation['Reservation']['book_date'];
		$bookDateGmtTime = get_gmt_time(strtotime('+1 day', strtotime($timestamp)));

		if (($bookDateGmtTime <= $todayDate) &&
			($reservation['Reservation']['reservation_status'] === 'pending_approval' ||
			$reservation['Reservation']['reservation_status'] === 'payment_pending')
		) {
			// Update reservation status
			$this->id = $id;
			$this->saveField('reservation_status', 'expired');

			//Send Message Notification
			$insertData = array(
				'property_id'     => $reservation['Reservation']['property_id'],
				'reservation_id'  => $reservation['Reservation']['id'],
				'user_by'         => $reservation['Reservation']['user_to'],
				'user_to'         => $reservation['Reservation']['user_by'],
				'subject'         => __('Reservation Expired'),
				'message'         => __('Sorry, Your reservation is expired by %s for %s.', array($reservation['Host']['name'], $reservation['Property']['PropertyTranslation']['title'])),
				'message_type'   => 'request_sent'
			);
			$insertData['Message'] = $insertData;
			$this->Message->sentMessage($insertData);
			// update message
			$this->Message->updateAll(
				array(
					'Message.is_respond'=> 1
				),
				array(
					'Message.reservation_id' => $reservation['Reservation']['id'],
					'Message.user_to'=> $reservation['Reservation']['user_to']
				)
			);

			// //////////////////// send sms to host /////////
			// here we can send a SMS to the host to notify him
			// that the request has expired
			// $sms_host = __('The reservation request has expired which has booked by %s for %s (%s - %s )', [
			// 	$reservation['Traveler']['name'],
			// 	$reservation['Property']['PropertyTranslation']['title'],
			// 	$reservation['Reservation']['checkin'],
			// 	$reservation['Reservation']['checkout']
			// ]);
			// send_sms_user($phoneNumber, $sms_host);
			// //////////////////// send sms to host /////////
			// // //////////////////// send sms to guest /////////
			// $sms_guest = __('Your reservation request is expired by %s for %s (%s - %s).', [
			// 	$reservation['Host']['name'],
			// 	$reservation['Property']['PropertyTranslation']['title'],
			// 	$reservation['Reservation']['checkin'],
			// 	$reservation['Reservation']['checkout']
			// ]);
			// send_sms_user($phoneNumberGuest, $sms_guest);
			// // //////////////////// send sms to guest /////////

			// refund mony if taken any to traveler
			// called for refund amount for host and guest as per host and guest cancellation policy
			// ** $this->refund($id);

			//Send Mail To Traveller
			$viewVars = array('reservation' => $reservation);
			$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
			$message .= "\n".__('The reservation request has expired which was booked by %s for %s (%s - %s )', [
				$reservation['Host']['name'],
				$reservation['Property']['PropertyTranslation']['title'],
				$reservation['Reservation']['checkin'],
				$reservation['Reservation']['checkout']
			]);
			$message .= "\n".__('Thanks and Regards.');

			$optionsEmail = array(
				'viewVars' => $viewVars,		// variables passed to the view
				'subject' => __('Reservation Request Expired'),// email subject,
				'content' => $message
			);
			parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

			//Send Mail To Host
			$viewVars = array('reservation' => $reservation);
			$message  = "\r\n".__('Hello %s,', $reservation['Host']['name']);
			$message .= "\r\n".__('Your reservation request is expired by %s for %s (%s - %s).', [
				$reservation['Traveler']['name'],
				$reservation['Property']['PropertyTranslation']['title'],
				$reservation['Reservation']['checkin'],
				$reservation['Reservation']['checkout']
			]);
			$message .= "\r\n".__('Thanks and Regards.');

			$optionsEmail = array(
				'viewVars' => $viewVars,		// variables passed to the view
				'subject' => __('Reservation Request Expired'),// email subject,
				'content' => $message
			);
			parent::__sendMail($reservation['Host']['email'], $optionsEmail);

			//Send Mail To Site Administrator
			if ($reservation['Host']['email'] !== $siteEmail && $reservation['Traveler']['email'] !== $siteEmail) {
				$viewVars = array('reservation' => $reservation);
				$message = __('The reservation request made by %s to %s for %s (%s - %s) has expired.', [
					$reservation['Traveler']['name'],
					$reservation['Host']['name'],
					$reservation['Property']['PropertyTranslation']['title'],
					$reservation['Reservation']['checkin'],
					$reservation['Reservation']['checkout']
				]);
				$message .= "\r\n".__('Thanks and Regards.');

				$optionsEmail = array(
					'viewVars' => $viewVars,		// variables passed to the view
					'subject' => __('Reservation Request Expired'),// email subject,
					'content' => $message
				);
				parent::__sendMail($siteEmail, $optionsEmail);
			}

			return true;
		}
		return false;
	}

	// Cron jobs
	// use bellow functions to call from the CRON
	// in this way you can update reservation status automaticlly
	// and save yourself time.
	public function cronExpire() {
		$options = array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property',
				'CancellationPolicy',
			),
			'fields' => array('Reservation.*', 'Traveler.*', 'Host.*', 'Property.*','CancellationPolicy.*'),
			'conditions' =>  array(
				'Reservation.reservation_status' => ['pending_approval', 'payment_pending']
			)
		);
		$reservations = $this->find('all', $options);

		$siteEmail = Configure::read('Website.email');

		$today = get_gmt_time(strtotime(date("Y-m-d H:i:s")));
		if (!empty($reservations)) {
			foreach ($reservations as $key => $reservation) {
				$book_date = get_gmt_time(strtotime('+1 day', get_gmt_time(strtotime($reservation['Reservation']['book_date']))));
				// if have past 24h ore 1day since reservation and there were no interaction
				// exprie reservation
				if ($book_date <= $today) {
					// update reservation status
					$this->id = $reservation['Reservation']['id'];
					if ($this->saveField('reservation_status', 'expired')) {
						//Send Message Notification
						$insertData = array(
							'property_id'    => $reservation['Reservation']['property_id'],
							'reservation_id' => $reservation['Reservation']['id'],
							'user_by'        => $reservation['Reservation']['user_to'],
							'user_to'        => $reservation['Reservation']['user_by'],
							'subject'        => __('Reservation Expire'),
							'message'        => __('Sorry, Your reservation request has been expired.'),
							'message_type'   => 'request_sent'
						);
						// send message
						$insertData['Message'] = $insertData;
						$this->Message->sentMessage($insertData);
						// update message
						$this->Message->updateAll(
							array(
								'Message.is_respond'=> 1
							),
							array(
								'Message.reservation_id' => $reservation['Reservation']['id'],
								'Message.user_to'=> $reservation['Reservation']['user_to']
							)
						);

						// payment_helper called for refund amount for host and guest as per host and guest cancellation policy
						// refund($reservation['Reservation']['id']);

						// after we updated the reservation stauts and refunded the price
						// then we send email to traveler host and ADMINISTRATOR

						//Send Mail To Traveller
						$viewVars = array('reservation' => $reservation);
						$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
						$message .= "\n".__('Sorry, Your reservation request with id (#%s) has expired.', $reservation['Reservation']['id']);
						$message .= "\n".__('Thanks and Regards,');
						$message .= "\n";
						$optionsEmail = array(
							'viewVars' => $viewVars,		// variables passed to the view
							'subject' => __('Reservation expired'),// email subject,
							'content' => $message
						);
						parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

						//Send Mail To Host
						$viewVars = array('reservation' => $reservation);
						$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
						$message .= "\n".__('Rreservation request with id (#%s) has expired.', $reservation['Reservation']['id']);
						$message .= "\n".__('Thanks and Regards');
						$message .= "\n";
						$optionsEmail = array(
							'viewVars' => $viewVars,		// variables passed to the view
							'subject' => __('Reservation expired'),// email subject,
							'content' => $message
						);
						parent::__sendMail($reservation['Host']['email'], $optionsEmail);

						// Send Mail To Administrator
						$viewVars = array('reservation' => $reservation);
						$message  = "\r\n".__('Hello Administrator,');
						$message .= "\r\n".__('Rreservation request with id (#%s) from %s to %s has expired.', array($reservation['Reservation']['id'], $reservation['Traveler']['name'], $reservation['Host']['name']));
						$message .= "\r\n".__('Thanks and Regards');
						$message .= "\r\n";
						$optionsEmail = array(
							'viewVars' => $viewVars,		// variables passed to the view
							'subject' => __('Reservation expired'),// email subject,
							'content' => $message
						);
						parent::__sendMail($siteEmail, $optionsEmail);
					}
				}
			}
		}
		return true;
	}

	/**
	 * cronCheckinDay
	 * This is run every 1 hour to remind user to checkin.
	 * 
	 * @return void
	 */
	public function cronCheckinDay() {
		// execute every 1 houers
		$options = array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property',
				'CancellationPolicy',
			),
			'conditions' =>  array(
				'Reservation.reservation_status' => 'payment_completed',
				'Reservation.checkin' => date('Y-m-d'),
			)
		);
		$reservations = $this->find('all', $options);

		if (!empty($reservations)) {
			foreach ($reservations as $key => $reservation) {
				$this->id = $reservation['Reservation']['id'];
				if ($this->saveField('reservation_status', 'awaiting_checkin')) {

					//Send Mail To Traveller
					$viewVars = array('reservation' => $reservation);
					$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
					$message .= "\n".__('Remember to checkin.', $reservation['Reservation']['id']);
					$message .= "\n".__('Thanks and Regards,');
					$message .= "\n";
					$optionsEmail = array(
						'viewVars' => $viewVars,
						'subject' => __('Reservation checkin'),
						'content' => $message
					);
					parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

					//Send Mail To Host
					$viewVars = array('reservation' => $reservation);
					$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
					$message .= "\n".__('Remember to remind %s to checkin.', [$reservation['Traveler']['name'], $reservation['Reservation']['id']]);
					$message .= "\n".__('Thanks and Regards');
					$message .= "\n";
					$optionsEmail = array(
						'viewVars' => $viewVars,
						'subject' => __('Reservation checkin'),
						'content' => $message
					);
					parent::__sendMail($reservation['Host']['email'], $optionsEmail);
				}
				$this->clear();
			}
		}
	}

	/**
	 * cronCheckin
	 * If user is still waiting to checkin run this command.
	 * run this command every 1 our after 1'o clock (PM). which is the official checkin time. 
	 * 
	 * @return void
	 */
	public function cronCheckin() {
		// execute evry 4 houers
		$options = array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property',
				'CancellationPolicy',
			),
			'conditions' => array(
				'Reservation.reservation_status' => 'awaiting_checkin',
				'Reservation.checkin' => date('Y-m-d'),
			)
		);
		$reservations = $this->find('all', $options);

		if (!empty($reservations)) {
			foreach ($reservations as $key => $reservation) {
				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message  = "\n".__('Today is your checkin date,');
				$message .= "\n".__('Please remember to checkin.', $reservation['Reservation']['id']);
				$message .= "\n".__('Thanks and Regards,');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars, // variables passed to the view
					'subject' => __('Reminder checkin'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\n".__('Remember to remind %s to checkin.', [$reservation['Traveler']['name'], $reservation['Reservation']['id']]);
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars, // variables passed to the view
					'subject' => __('Reminder checkin'),// email subject,
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);
			}
		}
	}

	/**
	 * cronCheckHostReview
	 * Notify host to leave a review.
	 * after user has checked out.
	 * 
	 * @return void
	 */
	public function cronCheckHostReview() {
		// $todayPlus = get_gmt_time(strtotime('+1 day', get_gmt_time(strtotime(date("Y-m-d")))));
		$todayPlus = get_gmt_time(strtotime(date("Y-m-d")));
		// execute evry 6 houers
		$options = array(
			'contain' => array(
				'Traveler',
				'Host',
				'Property',
				'CancellationPolicy',
			),
			'conditions' => array(
				'Reservation.reservation_status' => 'checkin',
				'Reservation.checkout < ' => date('Y-m-d', $todayPlus),
			)
		);
		$reservations = $this->find('all', $options);

		if (!empty($reservations)) {
			foreach ($reservations as $key => $reservation) {
				$this->id = $reservation['Reservation']['id'];
				if ($this->saveField('reservation_status', 'awaiting_traveler_review')) {

					//Send Mail To Traveller
					$viewVars = array('reservation' => $reservation);
					$message  = "\r\n".__('Hello %s,', $reservation['Traveler']['name']);
					$message  = "\r\n".__('We hope that you enjoyed your staying at %s house located at %s', [$reservation['Traveler']['name'], $reservation['Property']['address']]);
					$message .= "\r\n".__('Now you can leave a review, telling us how it went.');
					$message .= "\r\n".__('Thanks and Regards,');
					$message .= "\r\n";
					$optionsEmail = array(
						'viewVars' => $viewVars,
						'subject' => __('Reservation checkin'),
						'content' => $message
					);
					parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);
				}
				$this->clear();
			}
		}
	}

	/**
	 * BeforeSave Method
	 *
	 * @return array
	 */
	public function beforeSave($options = array()) {
		// only on create
		if (!isset($this->data[$this->alias]['confirmation_code']) || empty($this->data[$this->alias]['confirmation_code'])) {
			$this->data[$this->alias]['confirmation_code'] = 'EMCMS'.$this->uniqueRandom(7);
		}

		return parent::beforeSave($options);
	}

	/**
	 * Generate a unique random string of characters
	 *
	 * @param int    $length Desired length (optional)
	 * @param string $table - name of the table
	 * @param string $col - name of the column that needs to be tested
	 * @param string $flag Output type (NUMERIC, ALPHANUMERIC, NO_NUMERIC, RANDOM)
	 *
	 * @return string
	 */
	public function uniqueRandom($length = 16, $col = 'confirmation_code', $table = 'reservations', $flag = 'ALPHANUMERIC') {

	    $unique = false;
	    // Store tested results in array to not test them again
	    $tested = [];

	    $length = (int)$length;
	    if ($length <= 0) {
	        $length = 16;
	    }

	    switch ($flag) {
	        case 'NUMERIC':
	            $str = '0123456789';
	            break;
	        case 'NO_NUMERIC':
	            $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	            break;
	        case 'RANDOM':
	            $num_bytes = ceil($length * 0.75);
	            $bytes = self::getBytes($num_bytes);
	            return substr(rtrim(base64_encode($bytes), '='), 0, $length);
	        case 'ALPHANUMERIC':
	        default:
	            $str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	            break;
	    }

	    $bytes = self::getBytes($length);

	    do {

	        // Generate random string of characters
	        $position = 0;
	        $random = '';
	        for ($i = 0; $i < $length; $i++) {
	            $position = ($position + ord($bytes[$i])) % mb_strlen($str);
	            $random .= $str[$position];
	        }

	        // Check if it's already testing
	        // If so, don't query the database again
	        if (in_array($random, $tested) ){
	            continue;
	        }

	        // Check if it is unique in the database
	        $count = $this->find('count', [
	        	'conditions'=> [
	        		$col => $random,
	        	],
	        	'recursive' => -1,
	        	'callbacks' => false
	        ]);

	        // Store the random character in the tested array
	        // To keep track which ones are already tested
	        $tested[] = $random;

	        // String appears to be unique
	        if ($count == 0) {
	            // Set unique to true to break the loop
	            $unique = true;
	        }

	        // If unique is still false at this point
	        // it will just repeat all the steps until
	        // it has generated a random string of characters
	    }
	    while(!$unique);


	    return $random;
	}

	/**
	 * Random bytes generator
	 *
	 * Thanks to Zend for entropy
	 *
	 * @param $length Desired length of random bytes
	 * @return bool|string Random bytes
	 */
	public static function getBytes($length) {
	    $length = (int)$length;

	    if ($length <= 0) {
	        return false;
	    }

	    if (function_exists('openssl_random_pseudo_bytes')) {
	        $bytes = openssl_random_pseudo_bytes($length, $crypto_strong);

	        if ($crypto_strong === true) {
	            return $bytes;
	        }
	    }

	    if (function_exists('mcrypt_create_iv')) {
	        $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);

	        if ($bytes !== false && mb_strlen($bytes) === $length) {
	            return $bytes;
	        }
	    }

	    // Else try to get $length bytes of entropy.
	    // Thanks to Zend

	    $result         = '';
	    $entropy        = '';
	    $msec_per_round = 400;
	    $bits_per_round = 2;
	    $total          = $length;
	    $hash_length    = 20;

	    while (mb_strlen($result) < $length) {
	        $bytes  = ($total > $hash_length) ? $hash_length : $total;
	        $total -= $bytes;

	        for ($i=1; $i < 3; $i++) {
	            $t1 = microtime(true);
	            $seed = mt_rand();

	            for ($j=1; $j < 50; $j++) {
	                $seed = sha1($seed);
	            }

	            $t2 = microtime(true);
	            $entropy .= $t1 . $t2;
	        }

	        $div = (int) (($t2 - $t1) * 1000000);

	        if ($div <= 0) {
	            $div = 400;
	        }

	        $rounds = (int) ($msec_per_round * 50 / $div);
	        $iter = $bytes * (int) (ceil(8 / $bits_per_round));

	        for ($i = 0; $i < $iter; $i ++) {
	            $t1 = microtime();
	            $seed = sha1(mt_rand());

	            for ($j = 0; $j < $rounds; $j++) {
	                $seed = sha1($seed);
	            }

	            $t2 = microtime();
	            $entropy .= $t1 . $t2;
	        }

	        $result .= sha1($entropy, true);
	    }

	    return substr($result, 0, $length);
	}

}
