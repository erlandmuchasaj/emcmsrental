<?php

App::uses('AppShell', 'Console/Command');
App::uses('ClassRegistry', 'Utility');

class CheckinDayShell extends AppShell {
	/**
	 * execute evry 4 houers
	 * [main description]
	 * @return [type] [description]
	 */
	public function main() {

		Configure::write('App.baseUrl', '/');

		$Reservation = ClassRegistry::init('Reservation');

		// check if user must checkin
		$Reservation->cronCheckinDay();
		
	}

}