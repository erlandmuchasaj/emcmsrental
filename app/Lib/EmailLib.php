<?php

App::uses('ClassRegistry', 'Utility');

class EmailLib {
	/**
	 * send E-mail method
	 *
	 * @param mixed $to email or array of emails as recipients
	 * @param array $options list of options for email sending. Possible keys:
	 * @return boolean
	 */
	public static function __sendMail($emailTo, array $options = []) {
		if (!$emailTo) {
			return false;
		}

		if (!filter_var($emailTo, FILTER_VALIDATE_EMAIL)) {
			return false;
		}

		ClassRegistry::init('EmailQueue')->enqueue($emailTo, $options);

		return true;
	}
}
