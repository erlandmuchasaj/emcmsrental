<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');

/**
 * EmailQueue model
 *
 */
class EmailQueue extends AppModel {

/**
 * Name
 *
 * @var string $name
 * @access public
 */
	public $name = 'EmailQueue';

/**
 * Database table used
 *
 * @var string
 * @access public
 */
	public $useTable = 'email_queue';

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
	public $displayField = 'to';

/**
 * How may times an email should be sent
 *
 * @var string
 */
	public $sentLimit =  10;

/**
 * Stores a new email message in the queue
 *
 * @param mixed $to email or array of emails as recipients
 * @param array $options list of options for email sending. Possible keys:
 *
 * - subject : Email's subject
 * - template :  the name of the element to use as template for the email message
 * - layout : the name of the layout to be used to wrap email message
 * - emailFormat: Type of template to use (html, text or both)
 * - config : the name of the email config to be used for sending
 *
 * @return void
 */
	public function enqueue($to, $options = []) {

		$defaults = [
			'config'    => Configure::check('Website.email_driver') ? Configure::read('Website.email_driver') : 'smtp',
			'from'		=> Configure::check('Website.email_from') ? Configure::read('Website.email_from') : null, // Email or array of sender.
			'from_name'	=> Configure::check('Website.email_from_name') ? Configure::read('Website.email_from_name') : null, // person sending email
			'lang'		=> ClassRegistry::init('Language')->getDefaultLanguageCode(), // default language of the email - en by default
			'viewVars'	=> [],	  	  // If you are using rendered content, set the array with variables to be used in the view.
			'subject'	=> 'Email',	  // email subject,
			'content' 	=> '',		  // this is the email body
			'theme'		=> 	null,	  // Theme used when rendering template.
			'template'	=> 'default', // If you are using rendered content, set the template name.
			'layout'	=> 'default', // If you are using rendered content, set the layout to render. If you want to render a template without layout, set this field to null.
			'emailFormat'=>'html',	  // Format of email (html, text or both).
			'attachments'=> null, 	  // List of files to attach.
			'replyTo'    => null,	  // Email or array to reply the e-mail.
			'cc'         => null,	  // Email or array to cc e-mail to.
			'bcc'        => null,	  // Email or array to bcc e-mail to.
		];

		// merge default options with passed parameters
		$options = array_merge($defaults, $options);
		if (!is_array($options['viewVars'])) {
		    $options['viewVars'] = [];
		}

		if (Configure::read('Website.instant_mail') === true) {
			return $this->sendInstantEmail($to, $options);
		} else {
			if (!is_array($to)) {
				$to = array($to);
			}
			foreach ($to as $t) {
				$email['to'] = $t;
				$email['options'] = $options;
				$email['send_at'] = gmdate('Y-m-d H:i:s');

				$this->create();
				$this->save($email);
				$this->clear();
			}
		}
		
		return true;
	}

/**
 * Used to send email instantaniosly
 * @return boolean
 */
	protected function sendInstantEmail($to, array $options) {
		Configure::write('App.baseUrl', '/');

		// Switch to preferred email language
		Configure::write('Config.language', $options['lang']);
		try {
			$email = new CakeEmail($options['config']);

			//  When sending emails within a CLI script
			$email->domain(Configure::read('App.fullBaseUrl'));

			$email->from([$options['from'] => $options['from_name']]);

			# When sending email on behalf of other people
			// $email->sender('do-not-reply@erlandmuchasaj.com', 'EMCMS');

			# replyTo($email = null, $name = null)
			# $email->replyTo($bccEmail);

			# Email address to return if have some error.
			// $email->returnPath('erland.muchasaj@gmail.com');
			
			# CC email to someone - cc($email = null, $name = null) 
			# $email->cc($ccEmail);

			# bcc Email -  bcc($email = null, $name = null)
			# $email->bcc($bccEmail);

			$email->to($to);
			$email->subject($options['subject']);
			$email->theme($options['theme']);
			$email->template($options['template'], $options['layout']);
			$email->emailFormat($options['emailFormat']);
			$email->viewVars($options['viewVars']);

			$isSent = $email->send($options['content']);
		} catch (SocketException $exception) {
			$this->log("Email could not be sent to: {$to}. We got a status code: [". $exception->getCode()."] with error message: " . $exception->getMessage());
			$isSent = false;
		}

		// Restore to site language
		Configure::write('Config.language',  ClassRegistry::init('Language')->getActiveLanguageCode());

		return $isSent;
	}

/**
 * Returns a list of queued emails that needs to be sent
 *
 * @param integer $size, number of unset emails to return
 * @return array list of unsent emails
 * @access public
 */
	public function getBatch($size = 10) {
		$this->getDataSource()->begin();

		$emails = $this->find('all', array(
			'limit' => $size,
			'conditions' => array(
				'EmailQueue.sent' => false,
				'EmailQueue.send_tries <=' => $this->sentLimit,
				'EmailQueue.send_at <=' => gmdate('Y-m-d H:i:s'),
				'EmailQueue.locked' => false
			),
			'order' => array('EmailQueue.created' => 'ASC')
		));

		if (!empty($emails)) {
			# $ids = Set::extract('{n}.EmailQueue.id', $emails);
			$ids = Hash::extract($emails, '{n}.EmailQueue.id');
			$this->updateAll(['locked' => true], ['EmailQueue.id' => $ids]);
		}

		$this->getDataSource()->commit();
		return $emails;
	}

/**
 * Releases locks for all emails in $ids
 *
 * @return void
 **/
	public function releaseLocks($ids) {
		$this->updateAll(array('locked' => false), array('EmailQueue.id' => $ids));
	}

/**
 * Releases locks for all emails in queue, useful for recovering from crashes
 *
 * @return void
 **/
	public function clearLocks() {
		$this->updateAll(array('locked' => false));
	}


/**
 * Delete emails that have been allredy sent
 * useful for recovering from crashes
 *
 * @return void
 **/
	public function clearEmails() {
		$this->updateAll(array('sent' => true));
	}

/**
 * Marks an email from the queue as sent
 *
 * @param string $id, queued email id
 * @return boolean
 * @access public
 */
	public function success($id) {
		$this->id = $id;
		return $this->saveField('sent', true);
	}

/**
 * Marks an email from the queue as failed, and increments the number of tries
 *
 * @param string $id, queued email id
 * @return boolean
 * @access public
 */
	public function fail($id) {
		$this->id = $id;
		$tries = $this->field('send_tries');
		return $this->saveField('send_tries', $tries + 1);
	}

/**
 * Remove an email from the queue
 *
 * @param string $id, queued email id
 * @return boolean
 * @access public
 */
	public function remove($id) {
		$this->id = $id;
		return $this->delete();
	}


/**
 * Converts array data for template vars into a json serialized string
 *
 * @param array $options
 * @return boolean
 **/
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['options'])) {
			$this->data[$this->alias]['options'] = json_encode($this->data[$this->alias]['options']);
		}
		return parent::beforeSave($options);
	}

/**
 * Converts options back into a php array
 *
 * @param array $results
 * @param boolean $primary
 * @return array
 **/
	public function afterFind($results, $primary = false) {
		if (!$primary) {
			return parent::afterFind($results, $primary);
		}

		foreach ($results as &$r) {
			if (!isset($r[$this->alias]['options']) || empty($r[$this->alias]['options'])) {
				return $results;
			}
			$r[$this->alias]['options'] = json_decode($r[$this->alias]['options'], true);
		}

		return $results;
	}

}