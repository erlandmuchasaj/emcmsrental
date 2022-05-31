<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 * @property Reservation $Reservation
 * @property Property $Property
 */

class Review extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

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
		'model_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank, Review belongs to a model.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'title' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Review title can not be empty.',
				'allowEmpty' => false
			),
			'maxLength' => array(
				'rule' => array('maxLength', 60),
				'message' => 'Review title can not have more then 60 characters.',
			),
		),
		'review' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Review text body can not be empty.',
				'allowEmpty' => false
			),
			'maxLength' => array(
				'rule' => array('maxLength', 360),
				'message' => 'Review summary can not have more then 360 characters.',
			),
		),
	);

/**
 * belongsTo associations
 * aka review for an Experience reservation
 * aka review for an Property reservation
 * @var array
 */
	public $belongsTo = array(
		'Reservation' => array(
			'className' => 'Reservation',
			'foreignKey' => 'reservation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserBy' => array(
			'className' => 'User',
			'foreignKey' => 'user_by',
			'conditions' => '', // array('Review.user_by = UserBy.id'), testing -- works
			'fields' => '',
			'order' => ''
		),
		'UserTo' => array(
			'className' => 'User',
			'foreignKey' => 'user_to',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Experience' => array(
		    'className' => 'Experience',
		    'foreignKey' => 'model_id',
		    'conditions' => array(
		        'Review.model' => 'Experience',
		    ),
		),
		'Property' => array(
		    'className' => 'Property',
		    'foreignKey' => 'model_id',
		    'conditions' => array(
		        'Review.model' => 'Property',
		    ),
		),
		'Service' => array(
		    'className' => 'Service',
		    'foreignKey' => 'model_id',
		    'conditions' => array(
		        'Review.model' => 'Service',
		    ),
		),
	);

/**
 * BeforeSave Method
 *
 * @return array
 */
	public function beforeSave($options = array()) {
		// only on create
		if (!isset($this->data[$this->alias]['token']) || empty($this->data[$this->alias]['token'])) {
			$this->data[$this->alias]['token'] = md5(uniqid(rand(), true));
		}
		return parent::beforeSave($options);
	}

/**
 * getReviewSum
 * get the sume of all reviews that are active and published
 *
 * @param  int $user_id
 * @param  int  $model_id
 * @param  string  $model
 * @return array containint the sum of each review
 */
	private function getReviewSum($user_id = null, $model_id = null, $model = 'Property') {
		$result = $this->find('all', array(
			'conditions' => array(
				'Review.user_to' => $user_id,
				'Review.model_id' => $model_id,
				'Review.model' => $model,
				'Review.status' => 1,
			),
			'fields' => array(
				'SUM(Review.cleanliness) AS cleanliness',
				'SUM(Review.communication) AS communication',
				'SUM(Review.house_rules) AS house_rules',
				'SUM(Review.accurancy) AS accurancy',
				'SUM(Review.checkin) AS checkin',
				'SUM(Review.location) AS location',
				'SUM(Review.value) AS value'
			)
		));
		return $result[0][0];
	}

/**
 * getReviewRating
 * @param  int $user_id
 * @param  int  $model_id
 * @return INT return overall rating star of a property
 */
	public function getReviewRating($user_id = null, $model_id = null, $model = 'Property') {
		$stars = $this->getReviewSum($user_id, $model_id, $model);
		$count = $this->find('count', array(
			'conditions' => array(
				'Review.user_to' => $user_id,
				'Review.model_id' => $model_id,
				'Review.model' => $model,
				'Review.status' => 1,
			)
		));
		$ratings['communication'] = 0;
		$ratings['cleanliness'] = 0;
		$ratings['accurancy'] 	= 0;
		$ratings['location'] 	= 0;
		$ratings['overall'] 	= 0;
		$ratings['checkin'] 	= 0;
		$ratings['value'] 		= 0;

		if ($count > 0) {
			$cleanliness   = $stars['cleanliness'];
			$communication = $stars['communication'];
			$accurancy     = $stars['accurancy'];
			$checkin  	   = $stars['checkin'];
			$location  	   = $stars['location'];
			$value  	   = $stars['value'];
			$overall 	   = ($cleanliness + $communication + $accurancy + $checkin + $location + $value) / ($count*6);

			$ratings['cleanliness'] = round(($cleanliness/$count), 2);
			$ratings['communication'] = round(($communication/$count), 2);
			$ratings['accurancy'] = round(($accurancy/$count), 2);
			$ratings['checkin'] = round(($checkin/$count), 2);
			$ratings['location'] = round(($location/$count), 2);
			$ratings['value'] = round(($value/$count), 2);
			$ratings['overall'] =  round($overall, 2);
		}
		return $ratings;
	}

/**
 * getReviews
 * @param  int $user_id
 * @param  int  $model_id
 * @param  string  $model
 * @return array
 */
	public function getReviews($user_id = null, $model_id = null, $model = 'Property', $limit = 15) {
		$this->unbindModel(array(
			'belongsTo' => array('Reservation', 'UserBy')
		));
		$this->bindModel(array(
			'hasOne' => array(
				'Reservation' => array(
					'foreignKey' => false,
					'conditions' => array(
						'Reservation.id = Review.reservation_id',
						'Reservation.reservation_status' => 'completed'
					),
					'className' => 'Reservation'
				),
				'UserBy' => array(
					'foreignKey' => false,
					'conditions' => array(
						'UserBy.id = Review.user_by'
					),
					'className' => 'UserBy'
				)
			)
		));

		$options =  array(
		    'contain' => array(
		        'UserBy'
		    ),
		    'conditions' => array(
		        'Review.user_to' => $user_id,
		        'Review.model_id' => $model_id,
		        'Review.model' => $model,
		        'Review.status' => 1
		    ),
		    'recursive' => 0,
		    'limit' => $limit
		);
		$result = $this->find('all', $options);
		return $result;
	}

/**
 * getReviewRating
 * @param  int $user_id
 * @param  int  $model_id
 * @return INT return total count of active reviews for a given property
 */
	public function getReviewCount($user_id = null, $model_id = null, $model = 'Property') {
		$this->unbindModel(array(
			'belongsTo' => array('Reservation')
		));
		$this->bindModel(array(
			'hasOne' => array(
				'Reservation' => array(
					'foreignKey' => false,
					'conditions' => array(
						'Reservation.id = Review.reservation_id',
						'Reservation.reservation_status' => 'completed'
					),
					'className' => 'Reservation'
				)
			)
		));

		$options =  array(
		    'contain' => false,
		    'conditions' => array(
		        'Review.user_to' => $user_id,
		        'Review.model_id' => $model_id,
		        // 'Review.property_id' => $model_id,
		        'Review.status' => 1,
		        'Review.model' => $model,
		    ),
		    'recursive' => 0
		);
		$result = $this->find('count', $options);
		return $result;
	}

}
