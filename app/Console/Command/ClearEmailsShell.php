<?php

App::uses('AppShell', 'Console/Command');
App::uses('ClassRegistry', 'Utility');

class ClearEmailsShell extends AppShell {
	/**
	 * execute once a day
	 * Delete all emails allredy sent.
	 * @return 
	 */
	public function main() {
		$emailQueue = ClassRegistry::init('EmailQueue')->clearEmails();
	}
}
