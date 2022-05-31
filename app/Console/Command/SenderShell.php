<?php
App::uses('AppShell', 'Console/Command');
App::uses('CakeEmail', 'Network/Email');
App::uses('ClassRegistry', 'Utility');

class SenderShell extends AppShell {

	public function getOptionParser() {
		$parser = parent::getOptionParser();
		$parser
			->description('Sends queued emails in a batch')
			->addOption('limit', array(
				'short' => 'l',
				'help' => 'How many emails should be sent in this batch?',
				'default' => 50
			))
			->addOption('template', array(
				'short' => 't',
				'help' => 'Name of the template to be used to render email',
				'default' => 'default'
			))
			->addOption('layout', array(
				'short' => 'w',
				'help' => 'Name of the layout to be used to wrap template',
				'default' => 'default'
			))
			->addOption('config', array(
				'short' => 'c',
				'help' => 'Name of email settings to use as defined in email.php',
				'default' => 'default'
			))
			->addSubCommand('clearLocks', array(
				'help' => 'Clears all locked emails in the queue, useful for recovering from crashes'
			));
		return $parser;
	}

/**
 * Sends queued emails
 *
 * @access public
 */
	public function main() {
		Configure::write('App.baseUrl', '/');

		////////////////////////////////////////////////////////////////////////////////////
		$siteEmail = Configure::check('Website.email_from') ? Configure::read('Website.email_from') : 'do-not-reply@erlandmuchasaj.com';
		$siteTitle = Configure::check('Website.email_from_name') ? Configure::read('Website.email_from_name') : 'EMCMS';
		////////////////////////////////////////////////////////////////////////////////////

		// Store site language
		$Language = ClassRegistry::init('Language');
		$siteLanguage = $Language->getActiveLanguageCode();

		// load email queue and prepare to send them
		$emailQueue = ClassRegistry::init('EmailQueue');
		$emails = $emailQueue->getBatch($this->params['limit']);

		foreach ($emails as $e) {

			// Switch to preferred email language
			$options = $e['EmailQueue']['options'];
			Configure::write('Config.language', $options['lang']);
			try {

				$email = $this->_newEmail($options['config']);

				//  When sending emails within a CLI script
				$email->domain(Configure::read('App.fullBaseUrl'));

				// if (!empty($options['from']) && !empty($options['from_name'])) {
				// 	$email->from([$options['from'] => $options['from_name']]);
				// 	$email->sender($options['from'], $options['from_name']);
				// } else {
				// 	$email->from([$siteEmail => $siteTitle]);
				// }

				$email->from([$siteEmail => $siteTitle]);

				# When sending email on behalf of other people
				// $email->sender('no-replay@erlandmuchasaj.com', 'EMCMS');

				# replyTo($email = null, $name = null)
				# $email->replyTo($bccEmail);

				# Email address to return if have some error.
				// $email->returnPath('erland.muchasaj@gmail.com');
				
				# CC email to someone - cc($email = null, $name = null) 
				# $email->cc($ccEmail);

				# bcc Email -  bcc($email = null, $name = null)
				# $email->bcc($bccEmail);

				$email->to($e['EmailQueue']['to']);
				$email->subject($options['subject']);
				$email->theme($options['theme']);
				$email->template($options['template'], $options['layout']);
				$email->emailFormat($options['emailFormat']);
				$email->viewVars($options['viewVars']);

				$isSent = $email->send($options['content']);

			} catch (SocketException $exception) {
				$this->err($exception->getMessage());
				$isSent = false;
			}

			if ($isSent) {
				$emailQueue->success($e['EmailQueue']['id']);
				$this->out('Email ' . $e['EmailQueue']['id'] . ' was sent to ' . $e['EmailQueue']['to']);
			} else {
				$emailQueue->fail($e['EmailQueue']['id']);
				$this->err('Email ' . $e['EmailQueue']['id'] . ' was not sent to ' . $e['EmailQueue']['to']);
			}
		}

		// Restore to site language
		Configure::write('Config.language', $siteLanguage);

		$ids = Hash::extract($emails, '{n}.EmailQueue.id');
		$emailQueue->releaseLocks($ids);
	}

/**
 * Clears all locked emails in the queue, useful for recovering from crashes
 *
 * @return void
 **/
	public function clearLocks() {
		 ClassRegistry::init('EmailQueue')->clearLocks();
	}

/**
 * Returns a new instance of CakeEmail
 *
 * @return CakeEmail
 **/
	protected function _newEmail($config = 'default') {
		return new CakeEmail($config);
	}
}