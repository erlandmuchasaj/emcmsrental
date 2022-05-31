<?php

App::uses('AppShell', 'Console/Command');
App::uses('ClassRegistry', 'Utility');

class ResetEmailsShell extends AppShell {
	/**
	 * execute once a day
	 * [main description]
	 * @return [type] [description]
	 */
	public function main() {
		$emailQueue = ClassRegistry::init('EmailQueue')->clearLocks();
	}
}
