<?php

App::uses('AppShell', 'Console/Command');
App::uses('ClassRegistry', 'Utility');

class CronShell extends AppShell {

	public function main() {
		Configure::write('App.baseUrl', '/');

		$Reservation = ClassRegistry::init('Reservation');
		// check for expired reservation
		$Reservation->cronExpire();
		
		// check if user should leave a review
		$Reservation->cronCheckHostReview();

		// reset passed days 
		$Calendar = ClassRegistry::init('Calendar');
		$Calendar->removePassedDays();
	}

}