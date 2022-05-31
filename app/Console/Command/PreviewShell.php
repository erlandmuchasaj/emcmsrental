<?php

App::uses('AppShell', 'Console/Command');
App::uses('CakeEmail', 'Network/Email');
App::uses('ClassRegistry', 'Utility');

class PreviewShell extends AppShell {

	public function main() {
		Configure::write('App.baseUrl', '/');

		$conditions = array();
		if ($this->args) {
			$conditions['id'] = $this->args;
		}

		$emailQueue = ClassRegistry::init('EmailQueue');
		$emails = $emailQueue->find('all', array(
			'conditions' => $conditions
		));

		if (!$emails) {
			$this->out('No emails found');
			return;
		}


		foreach ($emails as $i => $email) {
			$this->out("Email :" . $email['EmailQueue']['id']);
			$this->out("Email :" . $email['EmailQueue']['to']);
			// $this->out("Email :" . print_r($email, true));
			$this->preview($email);
		}
	}

	public function preview($e) {

		$options = $e['EmailQueue']['options'];

		$email = new CakeEmail($options['config']);
		$email->transport('Debug') // Mail , Debug
			->template($options['template'], $options['layout'])
			->emailFormat($options['emailFormat'])
			->viewVars($options['viewVars'])
			->from($e['EmailQueue']['to'])
			->to($e['EmailQueue']['to'])
			->subject($options['subject']);

		$return = $email->send($options['content']);

		// $this->out('Content:');
		// $this->hr();
		// $this->out($return['message']);
		$this->hr();
		$this->out('Headers:');
		$this->hr();
		$this->out($return['headers']);
		$this->hr();
		$this->out('Data:');
		$this->hr();
		debug ($e['EmailQueue']['options']);
		$this->hr();
		$this->out();
	}

}