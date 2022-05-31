<?php
App::uses('AppModel', 'Model');
/**
 * Calendar Model
 *
 * @property Property $Property
 */
class Calendar extends AppModel {

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
	public $displayField = 'property_id';


/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = 'Property';

/**
 * checkAvailability
 *
 * check if someone can book in those given dates
 *
 * @param int $id calendar/proeprty id
 * @param string $checkin date in Y-m-d format
 * @param string $checkout date in Y-m-d format
 * @return boolean 
 */
	public function checkAvailability($id = null, $checkin = null, $checkout = null) {
        $calendar = $this->find('first', array(
            'conditions' => array(
                'Calendar.property_id' => $id
            ),
            'recursive' => -1,
            'callbacks' => false,
        ));
        if ($calendar) {
        	$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
        	$checkout_time = strtotime($checkout);
        	while (strtotime($checkin) < $checkout_time){ 
        		if (isset($decoded[$checkin])){
        			if ($decoded[$checkin]['status']==='booked' || $decoded[$checkin]['status']==='unavailable') {
        				return false;
        			}
        		} 
        		$checkin = date("Y-m-d", strtotime("+1 day", strtotime($checkin)));
        	}
        }
        return true;
	}

/**
 * isModified
 *
 * This function is used to reset to their initial state
 * all days that have been booked before. If the days in calendar has a different price
 * from the property price we keep those days.
 *
 * @param int $id calendar/proeprty id
 * @param string $checkin date in Y-m-d format
 * @param string $checkout date in Y-m-d format
 * @param float $price property initial price
 * @return boolean 
 */
	public function isModified($id = null, $checkin = null, $checkout = null, $price = null) {
		$calendar = $this->find('first', array(
			'conditions' => array(
				'Calendar.property_id' => $id
			),
			'recursive' => -1,
			'callbacks' => false,
		));
		if (!empty($calendar)) {
			$epsilon = 0.00001;
			$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
			$checkout_time = strtotime($checkout);
			while (strtotime($checkin) < $checkout_time){ 
				if (isset($decoded[$checkin])){
					if (trim($decoded[$checkin]['price']) !='' && (abs($decoded[$checkin]['price']-$price) >= $epsilon)) {
						return true;
					}
				} 
				$checkin = date("Y-m-d", strtotime("+1 day", strtotime($checkin)));
			}
		}
		return false;
	}

/**
 * bookDates
 *
 * This function is used to book specific dates for a specific user
 *
 * @param int $id calendar/proeprty id
 * @param string $checkin date in Y-m-d format
 * @param string $checkout date in Y-m-d format
 * @param int $user_id user making the reservation
 * @return boolean 
 */
	public function bookDates($id = null, $checkin = null, $checkout = null, $user_id = null) {
		$calendar = $this->find('first', array(
			'conditions' => array(
				'Calendar.property_id' => $id
			)
		));

		if (isset($calendar['Calendar']['calendar_data']) && !empty($calendar['Calendar']['calendar_data'])) { 
			$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
		} else {
			$decoded = array();
		}

		$start_date = $checkin;
		$checkout_time = strtotime($checkout);
		while (strtotime($start_date) < $checkout_time) { 
			if (isset($decoded[$start_date])) {
				$decoded[$start_date]['status'] = 'booked';
			} else {
				$temp_product = [
					'bind'   => 0,           
					'info'   => '',             
					'notes'  => '',           
					'price'  => '', 
					'promo'  => '',           
					'status' => 'booked',
					'booked_using' =>'portal',
					'user_id' => $user_id,  
				];
				$decoded[$start_date] = $temp_product;
			}
			if (isset($temp_product)) {
				unset($temp_product);
			}
			$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		}

		//Construct Calendar object to save in DB
		$calendar['Calendar']['id'] = $id;
		$calendar['Calendar']['property_id'] = $id;
		$calendar['Calendar']['calendar_data'] = json_encode($decoded);
		if ($this->save($calendar)) { 
			return true;
		}
		return false;
	}

/**
 * resetCalendarDays
 *
 * This function is used to reset to their initial state
 * all days that have been booked before. If the days in calendar has a different price
 * from the property price we keep those days.
 *
 * @param int $id calendar/proeprty id
 * @param string $checkin date in Y-m-d format
 * @param string $checkout date in Y-m-d format
 * @param float $initial_price property initial price
 * @return void 
 */
	public function resetCalendarDays($id = null, $checkin = null, $checkout = null, $initial_price = null) {
		$calendar = $this->find('first', array(
		    'conditions' => array(
		        'Calendar.property_id' => $id
		    ),
		    'recursive' => -1,
		    'callbacks' => false
		));
		if (!empty($calendar)) {
			$epsilon = 0.00001;
			$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
			$checkout_time = strtotime($checkout);
			while (strtotime($checkin) < $checkout_time){ 
				if (isset($decoded[$checkin])){
					// Delete passed days but keep those dates which has
					// updated their price
					if (trim($decoded[$checkin]['price']) === '' || (abs($decoded[$checkin]['price']-$initial_price) < $epsilon)) {
						unset($decoded[$checkin]);
					} else {
						$decoded[$checkin]['status'] = 'available';
						$decoded[$checkin]['booked_using'] = '';
						$decoded[$checkin]['user_id'] = 0;
					}
				} 
				$checkin = date('Y-m-d', strtotime('+1 day', strtotime($checkin)));
			}
		}
	}

/**
 * removePassedDays
 *
 * This function is used to delete passed days from calendar data
 * this way they are lighter to load and decreese load time
 * of the page that is using them
 * 
 * @return void 
 */
	public function removePassedDays() {
		$calendars = $this->find('all', ['recursive' => -1, 'callbacks' => false]);
		if (!empty($calendars)) {
			$todayTime = date("Y-m-d");
			foreach ($calendars as $key => $calendar) {
				$this->create();
				$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
				foreach ($decoded as $day => $value) {
					// if we are dealing with a passed day
					// remove it from calendar
					if (strtotime($day) < strtotime($todayTime)) {
						unset($decoded[$day]);
					}
				}
				$calendar['Calendar']['calendar_data'] = json_encode($decoded);
				$this->save($calendar);
				$this->clear();
			}
		}
	}

}
