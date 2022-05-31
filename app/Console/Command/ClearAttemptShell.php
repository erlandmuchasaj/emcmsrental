<?php

App::uses('AppShell', 'Console/Command');
App::uses('ClassRegistry', 'Utility');

class ClearAttemptShell extends AppShell {
	/**
	 * execute once a day
	 * Delete all emails allredy sent.
	 * @return 
	 */
	public function main() {
		$attempt = ClassRegistry::init('Attempt')->cleanup();
	}
}