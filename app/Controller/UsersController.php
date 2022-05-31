<?php
App::uses('AppController', 'Controller');
App::uses('Paypal', 'Paypal.Lib');
/**
 * Users Controller
 * EmCmsRentals
 * ================
 * This is the part where all the GENERAL functionalities are
 * PUBLIC AREA
 *
 * @author  Erland Muchasaj <erland.muchasaj@gmail.com>
 * @category rental script
 * @version 1.0.0
 * @license MIT <http://opensource.org/licenses/MIT>
 * 
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Users';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = ['Csv','Xls','Gravatar'];

/**
 * Uses
 *
 * @var array
 */
	public $uses = ['User', 'SocialProfile', 'UserSession', 'PayoutPreference'];

/**
 * Components
 *
 * @var array
 */
	public $components = [
		'RequestHandler',
		'Paginator',
		'Activity',
		'BackUp',
		'Attempt',
		'Twilio',
		'Hybridauth',
		'DataTable',
	];

	public $loginAttemptLimit  = 5;
	public $loginAttemptDuration  = '+10 minutes';

/**
 * Built-in Exceptions for CakePHP
 *
 * BadRequestException 		// Used for doing 400 Bad Request error.
 * UnauthorizedException 	// Used for doing a 401 Unauthorized error.
 * ForbiddenException 		// Used for doing a 403 Forbidden error.
 * NotFoundException 		// Used for doing a 404 Not found error.
 * MethodNotAllowedException// Used for doing a 405 Method Not Allowed error.
 * InternalErrorException 	// Used for doing a 500 Internal Server Error.
 * NotImplementedException 	// Used for doing a 501 Not Implemented Errors.
 *
 * Usage*
 * throw new NotFoundException('Could not find that post');
 */

/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->allow(
			'login',
			'logout',
			'signup',
			'activate',
			'social_login',
			'social_endpoint',
			'isLoggedIn',
			'access_denied',
			'requestActivationLink',
			'requestResetPassword',
			'activeResetPassword',
			// 'getCountryPhoneCode',
			// 'verifyNumber',
			'changeCurrency',
			'changeLanguage',
			'changePageCount',
			'getConfiguration',
			'getStatistics',
			'view'
		);

		$this->Auth->autoRedirect = false;
		$user = $this->Auth->user();
		if (!isset($user) || empty($user)) {
			$user = $this->Cookie->read('AutoLoginUser');
			if (isset($user) && !empty($user)) {
				$this->Auth->login($user);
			}
		}

		parent::beforeFilter();
	}

/**
 * user authorization method
 *
 * @return void
 */
	public function isAuthorized($user = null) {
		// The owner of a post can edit and delete it
		if (in_array($this->action, array('edit', 'delete','changepassword'))) {
			$userId = $this->request->params['pass'][0];
			if ($userId !== $user['id']) {
				//$this->Flash->error(__('You are not authorized to access this page.'));
				return false;
			}
		}
		return parent::isAuthorized($user);
	}

/**
 * getConfiguration method
 *
 * @access public
 * @return void
 */
	public function getConfiguration() {
		if (empty($this->request->params['requested'])) {
			throw new ForbiddenException();
		}

		$config = [];

		App::uses('Language', 'Model');
		$this->Language = new Language();
		$language_code = $this->Language->getActiveLanguageCode();
		$default_language = $this->Language->getDefaultLanguage();

		App::uses('Currency', 'Model');
		$this->Currency = new Currency();
		$currency_code = $this->Currency->getLocalCurrency();
		$default_currency = $this->Currency->getDefaultCurrency();

		// App::uses('SiteSetting', 'Model');
		// $this->SiteSetting = new SiteSetting();
		// $siteSetting = $this->SiteSetting->getSiteSetting();
		// $config['siteSetting'] = $siteSetting['SiteSetting'];

		// construct array.
		$config['language_code'] = $language_code;
		$config['currency'] = $currency_code;
		$config['default_language'] = isset($default_language['Language']['id']) ? $default_language['Language']['id'] : null;
		$config['default_currency'] = isset($default_currency['Currency']['id']) ? $default_currency['Currency']['id'] : null;
		$config['siteSetting'] =  Configure::read('Website');

		return $config;
	}

/**
 * change currency method
 *
 * @return void
 */
	public function changeCurrency($currency = null) {
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if (isset($this->request->data['currency_code']) && !empty($this->request->data['currency_code'])) {

			$currencies = ClassRegistry::init('Currency')->getCurrencyList('all');
			$availableCurrencies = Hash::extract($currencies, '{n}.Currency.code');

			$symbol = trim($this->request->data['currency_code']);
			if (!in_array($symbol, $availableCurrencies, true)) {
				$symbol = ClassRegistry::init('Currency')->getDefaultCurrencyCode();
			}

			$this->Session->write('LocaleCurrency', $symbol);
			$this->Cookie->write('currency', $symbol, false, '2 days');
			$response['type'] = 'success';
			$response['message'] = __('Currency data changed successfully.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Currency data could not be changed.');
		}
		return json_encode($response);
	}

/**
 * change language method
 *
 * @return void
 */
	public function changeLanguage($language = null) {
		$this->loadModel('Language');
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];


		if (isset($this->request->data['language_code']) && !empty($this->request->data['language_code'])) {

			$languages = $this->Language->getLanguageList('all');
			$availableLanguages = Hash::extract($languages, '{n}.Language.language_code');

			$languageCode = trim($this->request->data['language_code']);
			if (!in_array($languageCode, $availableLanguages, true)) {
				$languageCode = $this->Language->getDefaultLanguageCode();
			}

			$this->Session->write('Config.language', $languageCode);
			$this->Cookie->write('lang', $languageCode, false, '2 days');
			$response['type'] = 'success';
		}
		
		return json_encode($response);
	}

/**
 * change currency method
 *
 * @return void
 */
	public function changePageCount($count = null) {
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if (isset($this->request->data['per_page_count']) && !empty($this->request->data['per_page_count'])) {
			$count = (int)$this->request->data['per_page_count'];
			$this->Session->write('per_page_count', $count);
			$response['type'] = 'success';
			$response['message'] = __('Page count changed successfully.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Page count could not be changed. Please try again!');
		}
		return json_encode($response);
	}

/**
 * change language method
 *
 * @return void
 */
	public function getCountryPhoneCode($country_id = null) {
		$this->loadModel('Country');
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' => 1,		// 0 | 1
			'type' 	=> 'error',	// info, warning, error, success
			'message' => __('country_id is not set'),
			'data' 	=> null,
		];

		if (isset($this->request->data['country_id']) && !empty($this->request->data['country_id'])) {

			$country = $this->Country->find('first', array(
				'conditions' => [
					'Country.id' => $this->request->data['country_id'],
				],
			));

			if (!$country) {
				$response['message'] = __('No country found with specified country_id: %s', $this->request->data['country_id']);
			} else {
				$response['error'] = '0';
				$response['type']  = 'success';
				$response['message']  = 'Updated';
				$response['data'] = [
					'country_mobile_code' => $country['Country']['phonecode']
				];
			}
		}
		
		return json_encode($response);
	}

/**
 * change language method
 *
 * @return void
 */
	public function verifyNumber() {
		$this->loadModel('Country');
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		// This is Standart Format for all Ajax Call
		$response = [
			'error' => 0,		// 0 | 1
			'type' 	=> 'info',	// info, warning, error, success
			'message' => null,
			'data' 	=> null,
		];

		if (isset($this->request->data['phone_country']) && !empty($this->request->data['phone_number'])) {
			$country = $this->Country->find('first', array(
				'conditions' => [
					'Country.id' => $this->request->data['phone_country']
				],
			    'recursive' => -1,
			    'callbacks' => false
			));

			if (!$country) {
				$response['error'] = 1;
				$response['message'] = __('No country found with specified country_id: %s', $this->request->data['phone_country']);
			} else {

				$code = rand(100000, 999999);
				$number = '+' . $country['Country']['phonecode'] . ltrim($this->request->data['phone_number'], '0');
				$message = 'Your ' . Configure::read('Website.name') . ' code is: ' . $code;

				$dataSource = $this->User->getDataSource();

				try {
					$dataSource->begin();

					# save code to DB
					$isSaved = $this->User->UserProfile->updateAll(
						['verified' => '0', 'verification_code' => $code, 'phone' =>  $dataSource->value($number, 'string')],
						['UserProfile.user_id' => $this->Auth->user('id')]
					);

					if (!$isSaved) {
						throw new Exception("Error Processing Request. User data could not be saved.", 1);
					}
	
					#send sms to the user
					$sms = $this->Twilio->sendSingleSms($number, $message);

					$this->Session->write('verify_code', $code);

					if ($this->Twilio->getMode() === 'sandbox') {
						$response['data'] = $code;
					}

					$dataSource->commit();
				} catch(Exception $e) {
					$dataSource->rollback();
					$response['error'] = '1';
					$response['type']  = 'error';
					$response['message']  = $e->getMessage();
				    return json_encode($response);
				}

				$response['error'] = '0';
				$response['type']  = 'success';
				$response['message'] = __("We Have Sent Verification Code to Your Mobile: %s. Please Enter Verification Code.", $number);
			}
		}
		return json_encode($response);
	}

/**
 * change language method
 *
 * @return void
 */
	public function matchVerify() {
		$this->loadModel('Country');
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		// This is Standart Format for all Ajax Call
		$response = [
			'error' => 0,		// 0 | 1
			'type' 	=> 'info',	// info, warning, error, success
			'message' => null,
			'data' 	=> null,
		];

		if (isset($this->request->data['code']) && !empty($this->request->data['code'])) {
			$code = $this->request->data['code'];
			if ($code !=  $this->Session->read('verify_code')) {
				$response['error'] = '1';
				$response['type']  = 'error';
				$response['message'] = __('Verification code does not match. Please enter correct code');
				return json_encode($response);
			}

			$dataSource = $this->User->getDataSource();
			try {
				$dataSource->begin();

				# save code to DB
				$isSaved = $this->User->UserProfile->updateAll(
					['verified' => '1', 'verification_code' => null],
					['UserProfile.user_id' => $this->Auth->user('id'), 'UserProfile.verification_code' => $code]
				);

				// # save code to DB
				// $query = $this->User->query("SELECT * FROM users_verification WHERE user_id={$this->Auth->user('id')} LIMIT 1");
				// if ($query) {
				// 	# update.
				// } else {
				//  # insert
				// }

				if (!$isSaved) {
					throw new Exception("Error Processing Request. User data could not be saved.", 1);
				}

				$dataSource->commit();
			} catch(Exception $e) {
				$dataSource->rollback();
				$response['error'] = '1';
				$response['type']  = 'error';
				$response['message'] = $e->getMessage();
			    return json_encode($response);
			}

			$response['error'] = '0';
			$response['type']  = 'success';
			$response['message'] = __('Your Phone Number Verified Successfully');

		}
		return json_encode($response);
	}

/**
 * when authorisation fails
 *
 * @return json|array returns true/array if user is logedin
 */
	public function access_denied() {
	    $loggedIn = $this->Auth->user('id');
	    $response = [
	        'result' => false,
	        'code' => 'access-denied',
	        'message' => 'Invalid credentials or access denied.'
	    ];
	    $this->set(compact('loggedIn', 'response'));
	    $this->set('_serialize', ['loggedIn', 'response']);
	}

/**
 * check if user is loggedin
 *
 * @return json
 */
	public function isLoggedIn() {
		$this->autoRender = false;
		$this->request->allowMethod('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = array(
			'error' => 0,
			'data' 	=> $this->Auth->user(),
			'message' => '',
		);

		// $this->Auth->user() returns NULL or User info for logged in user
		if (!$this->Auth->loggedIn()) {
		    $response['error'] = 1;
			$response['data'] = false;
			$response['message'] = __('You are not authenticated. Please login in order to perform this action.');
		}
		return json_encode($response);
	}

/**
 * login method
 *
 * @return void
 */
	public function login() {
		$this->set('title_for_layout', __('Login Area'));

		$this->layout = 'login';

		//if already logged-in, redirect
		if ($this->Auth->loggedIn()) {
			$this->Flash->info(__('You are allredy logged in!'));
			return $this->redirect($this->referer());
		}

		// if we get the post information, try to authenticate
		if ($this->request->is('post')) {
			// Limit to 10 failed attempts
			if ($this->Attempt->limit('login', $this->loginAttemptLimit)) {
				// Validate user credentials
				if ($this->Auth->login()) {
					if ((int)$this->request->data['User']['remember_me'] == 0) {
						$this->Cookie->delete('AutoLoginUser');
					} else {
						$this->Cookie->write('AutoLoginUser', $this->Auth->user(), true, '+2 weeks');
					}
					// if users login then reset attempt data
					$this->Attempt->reset('login');
					// $this->User->id = $this->Auth->user('id');
					$this->Flash->success(__('You have been logged in %s.', $this->Auth->user('name')));

					if (Configure::read('Maintenance.enable') && 'admin' === $this->Auth->user('role')) {
						return $this->redirect($this->Auth->redirectUrl(['admin'=>true, 'controller'=>'users', 'action' => 'dashboard']));
					}

					return $this->redirect($this->Auth->redirectUrl());
				} else {
					// Invalid credentials, count as failed attempt for an hour
					$this->Attempt->fail('login', $this->loginAttemptDuration);
					$this->Flash->error(__('Invalid Email / Password Combination.'));
				}
			} else {
				// User exceeded attempt limit
				// Ideally show a CAPTCHA (ensuring this is not a robot
				// without blocking out and frustrating users),
				// otherwise show error message
				$this->Flash->error(__('Too many failed attempts!'));
			}
		}
	}

////////////////////////////////////////////////////////////////////////////////////
/**
*/
	/* social login functionality */
	public function social_login($provider) {
		if ($this->Hybridauth->connect($provider)) {
			$this->_successfulHybridauth($provider, $this->Hybridauth->userProfile);
		} else {
			$this->Flash->error($this->Hybridauth->error);
			$this->redirect($this->Auth->redirectUrl());
		}
	}

	public function social_endpoint($provider = null) {
		$this->autoRender = false;
		$this->Hybridauth->processEndpoint();
	}

	private function _successfulHybridauth($provider = '', $incomingProfile = []) {
		// #$incomingProfile is the profile geathered from Social Network
		# 1 - check if user already authenticated using this provider before
		$existingProfile = $this->SocialProfile->find('first', [
			'conditions' => [
				'social_network_id'   => $incomingProfile['SocialProfile']['social_network_id'],
				'social_network_name' => $provider,
			],
			'recursive' => -1,
			'callbacks' => false
		]);

		# 2 - if an existing profile is available, then we set the user as connected and log them in
		if (!empty($existingProfile)) {
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.' . $this->User->primaryKey => $existingProfile['SocialProfile']['user_id']
				),
				'recursive' => -1,
				'callbacks' => false,
			));
		} else {
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.email' => $incomingProfile['SocialProfile']['email']
				),
				'recursive' => -1,
				'callbacks' => false,
			));

			if (empty($user)) {
				// create new user
			    $user = $this->User->createFromSocialProfile($incomingProfile);
			}

			// asign the profile to this user.
			$profile = $this->User->SocialProfile->createSocialProfile($incomingProfile, $user['User']['id']);
		}

		# New Social profile. Check if user is loggedin and then connect logged in user to a social profile
		if ($this->Auth->loggedIn()) {
			$this->Flash->success(__('Your %s account is now linked to your account.', $provider));
			return $this->redirect($this->Auth->redirectUrl());
		} else {
			// log in with the newly created user
			$this->_doSocialLogin($user);
		}
	}

	private function _doSocialLogin($user = array(), $returning = false) {
		if ($this->Auth->login($user['User'])) {
			# Here we need to check if user is banned or not.
			$this->Flash->success(__('Welcome to our community, %s', h($this->Auth->user('name'))));
			return $this->redirect($this->Auth->redirectUrl());
		} else {
			$this->Flash->error(__('Unknown Error, could not verify the user: %s.', h($user['User']['name'])));
			return $this->redirect($this->Auth->redirectUrl());
		}
	}
////////////////////////////////////////////////////////////////////////////////////

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
		$this->autoRender = false;
		$this->Session->delete('Auth.User');
		$this->Cookie->delete('AutoLoginUser');
		$this->Hybridauth->logout();

		$this->Flash->success(__('You have been logged out.'));
		return $this->redirect($this->Auth->logout());
	}

/**
 * signup method
 *
 * @return void
 */
	public function signup() {
		$this->layout = 'login';

		//if already logged-in, redirect
		if ($this->Auth->loggedIn()) {
			$this->Flash->info(__('You allredy have an account and are logged in.'));
			return $this->redirect($this->referer());
		}
		
		if ((int)Configure::read('Website.disable_registration') == 1) {
			$this->Flash->warning(__('Registration into portal has been disabled by site administrator. Please come back in a later time or contact support.'));
			return $this->redirect($this->referer());
		}

		$errors = array();
		if ($this->request->is('post')) {
			$this->User->create();

			// Using a custom salt value
			$activate 	= Security::hash('Activate', 'md5',  Configure::read('Security.salt'));
			$time 		= time();
			$code		= sha1($activate.$this->request->data['User']['email'].$time).'-'.$time;
			$activationLink = $this->siteURL().$this->webroot."users/activate/".$code;
			$siteAddress    = $this->siteURL().$this->webroot;

			/*
			 *	App::uses('SiteSetting', 'Model');
			 *	$SiteSetting = new SiteSetting();
			 *	$newUserEmail = $SiteSetting->find('first',array('conditions' => array('key' => 'NEW_USER')));
			 *	if (!empty($newUserEmail)){
			 *		$newUserEmail = json_decode($newUserEmail['SiteSetting']['value'], true);
			 *	}
			 *	$emailBody = $newUserEmail['SiteSetting']['send_link_body'];
			 *	$emailBody = str_replace('{site_name}', $siteAddress, $emailBody);
			 *	$emailBody = str_replace('{user_name}', $this->request->data['User']['name'], $emailBody);
			 *	$emailBody = str_replace('{user_email}', $this->request->data['User']['email'], $emailBody);
			 *	$emailBody = str_replace('{user_password}', $this->request->data['User']['password'], $emailBody);
			 *	$emailBody = str_replace('{user_activation_link}', $activationLink, $emailBody);
			 */

			if ((int)$this->request->data['User']['terms_of_service']!=1) {
				throw new BadRequestException(__('You have to agree to terms of service.'));
			}

			$this->request->data['User']['activation_code'] = $code;

			if ($this->User->save($this->request->data)) {
					/*	SEND MESSAGE TO THE USER	*/
					$viewVars = array(
						'user_activation_link' => $activationLink
					);
					$message  = "Hello {$this->request->data['User']['name']}. <br> \n";
					$message .= "This is the link to activate your account, <br> \n";
					$message .= $activationLink;
					$message .= "\n <br> Thanks!";

					$options = array(
						'viewVars' => [
							'user_activation_link' => $activationLink
						],
						'subject'  => __('Active Account'), // email subject,
						'content'  => $message,
						'template' => 'new_user',	// tempalte to be used for this email
					);

					parent::__sendMail($this->request->data['User']['email'], $options);

					$this->Flash->success(__('The user has been saved. An Email has been sent to you with confirmation link.'));
					$this->redirect(array('action' => 'login'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
				$errors = $this->User->validationErrors;
			}
		}
		$this->set('errors',$errors);
	}

/**
 * activate method
 *
 * @return void
 */
	public function activate($code = null) {
		$this->autoRender = false;
		if ($code) {
			$user = $this->User->find('first', array('conditions' => array('activation_code' => $code)));
			if ($user) {
				$delimiter = '-';
				$ary = array();
				if(strpos($code,$delimiter) !== false) {
					$ary = explode('-', $code, 2);
				} else {
					$this->Flash->error(__('Invalid activaiton token. Please try again.'));
					return $this->redirect(array('action' => 'login'));
				}
				// Using a custom salt value
				$activate = Security::hash('Activate', 'md5',  Configure::read('Security.salt'));
				if ($code === sha1($activate.$user['User']['email'].$ary[1]).'-'.$ary[1]){
					$user['User']['activation_code'] = null;
					$user['User']['status'] = 1;

					unset($user['User']['password']);
					unset($user['User']['modified']);

					if ($this->User->save($user, false)){
						/*	SEND MESSAGE TO THE USER	*/
						$viewVars = array();
						$message = __("Hello %s.\n", $user['User']['name']);
						$message .= __("Your Email address has been confirmed successfully, \n <br>");
						$options = array(
							'viewVars' => $viewVars,	// variables passed to the view
							'subject' => __('Email Confirmation Completed'),	// email subject,
							'content' => $message
						);

						parent::__sendMail($user['User']['email'], $options);
						$this->Flash->success(__('Success: Email activation completed.'));
					}
				} else {
					$this->Flash->error(__('Error: Invalid activaiton code.'));
				}
			} else {
				throw new NotFoundException(__('User not found'));
			}
		}
		$this->redirect(array('action' => 'login'));
	}

/**
 * Request Activation Link
 *
 * @return void
 */
	public function requestActivationLink() {
		if ($this->request->is('post')) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);

			if (!$user) {
				$this->Flash->error(__('No user was found with the submitted email address.'));
				return $this->redirect($this->referer());
				// throw new NotFoundException(__('User not found'));
			}

			if ($user['User']['status']) {
				$this->Flash->info(__('Your account is allredy activated.'));
				return $this->redirect($this->referer());
			}

			$activationLink = $this->siteURL().$this->webroot."users/activate/".$user['User']['activation_code'];

			/*	SEND MESSAGE TO THE USER	*/
			$viewVars = array();
			$message = __("Hello %s.\n", $user['User']['name']);
			$message .= __("This is the link to activate your account, \n <br>");
			$message .= $activationLink;

			$options = array(
				'viewVars' => $viewVars,	// variables passed to the view
				'subject'  => __('Request activation link'),	// email subject,
				'content'  => $message
			);

			parent::__sendMail($this->request->data['User']['email'], $options);

			$this->Flash->success(__('An Email has been sent to you with confirmation link.'));
			return $this->redirect(array('admin'=>false, 'user'=>false, 'controller'=>'users', 'action'=>'login'));

		}
	}

/**
 * requestResetPassword method
 *
 * @return void
 */
	public function requestResetPassword() {
		if ($this->request->is(array('post', 'put'))) {
			$var = array();
			$viewVars = array();
			$linkIsSent = true;
			$ResetPassword = Security::hash('ResetPassword', 'md5',  Configure::read('Security.salt'));
			$user = $this->User->find('first', [
				'conditions' => [
					'User.email' => $this->request->data['User']['email'],
					'User.status' => 1
				]
			]);

			if (!$user) {
				$this->Flash->error(__('The email address you entered was not found. Please try a different email address.'));
				$this->redirect($this->referer(array('controller' => 'users', 'action' => 'login')));
				// throw new NotFoundException(__('The email address you entered was not found. Please try a different email address.'));
			}

			// check if reset password link
			// has allredy been sent,
			if (!empty($user['User']['reset_password'])) {
				$delimiter = '-';
				$aryCode = array();

				if (strpos($user['User']['reset_password'], $delimiter) !== false) {
					$aryCode = explode('-', $user['User']['reset_password'], 2);
				} else {
					$this->Flash->error(__('Incorrect access token to reset password. Please Try again.'));
					$this->redirect(array('action' => 'login'));
				}

				if ($user['User']['reset_password'] !== sha1($ResetPassword.$user['User']['email'].$aryCode[1]).'-'.$aryCode[1]){
					$linkIsSent = false;
				}
			}

			if ($linkIsSent == true) {
				$time = time();
				// CODE = SHA1(TEXT.EMAIL.TIME) - TIME;
				// So in bothe cases the time is the same
				// After user tries to reset passuord
				$code = sha1($ResetPassword.$user['User']['email'].$time).'-'.$time;

				$user['User']['reset_password'] = $code;
				unset($user['User']['password']);
				unset($user['User']['image_path']);
				unset($user['User']['modified']);

				if ($this->User->save($user, false)) {
					$resetLink = $this->siteURL().$this->webroot."users/activeResetPassword/".$code;
					$viewVars = array(
						"name"   => h($user['User']['name']),
						"email"  => h($user['User']['email']),
						"reset_link"  => $resetLink,
						"date"  => date('d-m-Y'),
					);
					$message ="Hello {$user['User']['name']}. \n  <br>";
					$message .= "This is the link to reset your password, \n  <br>";
					$message .= "We hope that it was you the one who requested the link. \n  <br>";
					$message .= $resetLink;

					$options = array(
						'viewVars' => $viewVars,	// variables passed to the view
						'subject'  => __('Reset Password'),	// email subject,
						'content'  => $message
					);
					parent::__sendMail($this->request->data['User']['email'], $options);
					$linkIsSent = true;

				} else {
					$linkIsSent = false;
				}
			}

			if ($linkIsSent == true){
				$this->Flash->success(__('Password Reset Succesfully. Please check your email address for reset link.'));
			}else{
				$this->Flash->error(__('Password Reset Failed. Please try again.'));
			}
			$this->redirect(array('action' => 'login'));
		}
	}

/**
 * [activeResetPassword description]
 * @param  [string] $code [tokent sent to user sha1(ResetPass.EMAIL.TIME-TIME)]
 * @return void
 */
	public function activeResetPassword($code = null) {
		if (!$code) {
			throw new NotFoundException(__('Your reset password code does not existed'));
		}

		$errors = [];

		$user = $this->User->find('first', [
			'conditions' => [
				'reset_password' => $code,
				'status' => 1
			]
		]);

		if (!$user){
			throw new NotFoundException(__('Your reset password code does not existed'));
		}

		if ($this->request->is(array('post', 'put'))) {

			$user = $this->User->find('first', [
				'conditions' => [
					'reset_password' => $this->request->data['User']['reset_password'],
					'status' => 1
				]
			]);

			if (isset($user['User']['reset_password']) && !empty($user['User']['reset_password'])) {
				
				$ResetPassword 	= Security::hash('ResetPassword', 'md5',  Configure::read('Security.salt'));
				$aryCode = explode('-', $user['User']['reset_password'], 2);

				if ($user['User']['reset_password'] === sha1($ResetPassword.$user['User']['email'].$aryCode[1]).'-'.$aryCode[1]) {
					// time passed less then a day
					if ((time() - $aryCode[1]) < (24*60*60)) {
						$user['User']['reset_password'] = null;
						$user['User']['password'] = $this->request->data['User']['password'];
						$user['User']['confirm_password'] = $this->request->data['User']['confirm_password'];
						unset($user['User']['modified']);
						unset($user['User']['image_path']);
						if ($this->User->save($user)){
							$this->Flash->success(__('Your password has been reset successfully.'));
							$this->redirect(array('action' => 'login'));
						} else {
							$this->Flash->success(__('Your password could not be reset. Please try again'));
							$errors = $this->User->validationErrors;
						}
					} else {
						$this->Flash->error(__('Your reset password code has expired.'));
					}
				}
			}
		}

		$this->set('code', $code);
		$this->set('errors', $errors);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		
		// $this->Twilio->sendSingleSms('+355672190020', 'Erland Muchasaj, Check this out. C u @ ATIS. :)');
		
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array(
			'contain' => ['UserProfile', 'SocialProfile', 'Image'],
			'conditions' => array('User.' . $this->User->primaryKey => $id)
		);
		$this->set('user', $this->User->find('first', $options));

		$this->Paginator->settings = array(
			'conditions' => array(
				'Property.deleted' => null,
				'Property.is_approved' => 1,
				'Property.status' => 1,
				'Property.user_id'=> $id
			),
			'limit' => 20,
			'order' => array('Property.id' => 'DESC'),
			'paramType' => 'querystring'
		);
		$properties = $this->paginate('Property');
		$this->set(compact('properties'));
	}

/*! EmCmsRentals
 * ================
 * here are private area functions
 *
 * @Author  Erland Muchasaj
 * @Support <http://www.almsaeedstudio.com>
 * @Email   <erland.muchasaj@gmail.com>
 * @version 1.0.0
 * @license MIT <http://opensource.org/licenses/MIT>
 */

/**
 * dashboard method
 *
 * @return void
 */
	public function dashboard() {
		$id = $this->Auth->user('id');
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id),'recursive'=>0);
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($id !== $this->Auth->user('id')) {
			$this->Flash->error(__('You dont have permission to perform this action.'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['User']['image_path']['name'])) {
				unset($this->request->data['User']['image_path']);
			}
			if ($this->User->saveAll($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The user has been saved.'));
				// return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
			$this->redirect($this->referer(array('controller' => 'users', 'action' => 'dashboard')));
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id), 'recursive'=>0);
			$this->request->data = $this->User->find('first', $options);
		}

		App::uses('Country', 'Model');
		$Country = new Country();
		$countries = $Country->find('list', array(
			'conditions' => ['Country.phonecode <>' => 0],
		    'fields' => array('Country.id', 'Country.name'),
		    'order' => array('Country.name' => 'asc'),
		    'recursive' => -1,
		    'callbacks' => false
		));

		// $languages = $this->User->UserProfile->Language->find('list');
		// $timezones = $this->User->UserProfile->Timezone->find('list');
		// $currencies = $this->User->UserProfile->Currency->find('list');
		$this->set(compact('languages', 'timezones', 'currencies','countries'));

	}

/**
 * changepassword method
 *
 * @return void
 */
	public function changepassword($id = null) {
		if (!$id) {
			throw new BadRequestException(__('No ID Suplied!'));
		}

		$this->User->id = $id;
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user!'));
		}

		if ($id !== $this->Auth->user('id')) {
			throw new UnauthorizedException(__('Sorry! You can not access this page.'));
		}

		if ($this->request->is(array('post', 'put'))) {
			// debug($this->request->data);
			// die();
			if ($this->User->save($this->request->data)) {
				// $this->Activity->log($this->Model->id, 'ModelName', 'actionName', 'Description - optional');
				//$this->Activity->log($this->User->id, 'User', 'changepassword', 'User Changed Password');
				$this->Flash->success(__('Password changed succesfull.'));
				return $this->redirect(array('controller'=>'users', 'action' => 'dashboard'));
			} else {
				$this->Flash->error(__('Password could not be changed. Please try again!'));
			}
		} else {
			$this->request->data = $this->User->findById($id);
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function payout($id = null) {
		// if (!$this->User->exists($id)) {
		// 	throw new NotFoundException(__('Invalid user'));
		// }

		// if ($id !== $this->Auth->user('id')) {
		// 	$this->Flash->error(__('You dont have permission to perform this action.'));
		// 	return $this->redirect(array('action' => 'index'));
		// }

		if ($this->request->is(array('post', 'put'))) {

			if (!isset($this->request->data['PayoutPreference']['payout_method'])) {
				$this->Flash->error(__('Payment method is required. Please refresh the page and try again.'));
				return $this->redirect(array('action' => 'payout'));
			}

			$payout_method = $this->request->data['PayoutPreference']['payout_method'];

			if ($payout_method === 'paypal') {
				$this->User->PayoutPreference->validator()
					->add('paypal_email', 'required', [
						'rule' => array('notBlank'),
						'message' => 'A email is required'
					])
					->add('paypal_email', 'email', [
						'rule' => array('email'),
						'message' => 'Enter valid mail address'
					]);
			} elseif ($payout_method === 'stripe') {
				$this->User->PayoutPreference->validator()
					->add('account_number', 'required', [
						'rule' => array('notBlank'),
						'message' => 'Acount number is required'
					])
					->add('holder_name', 'required', [
						'rule' => array('email'),
						'message' => 'Holder name is required'
					]);
			} else {
				$this->Flash->error(__('Payment method selected (%s) is not implemented.', $payout_method));
				return $this->redirect(array('action' => 'payout'));
			}


			$this->User->PayoutPreference->set($this->request->data);
			if ($this->User->PayoutPreference->validates()) {

				$this->User->PayoutPreference->create();
				$this->request->data['PayoutPreference']['user_id'] = $this->Auth->user('id');

				if ($this->User->PayoutPreference->save($this->request->data)) {
					$this->Flash->success(__('The Payout Preference has been saved.'));
					return $this->redirect(array('action' => 'payout'));
				} else {
					$this->Flash->error(__('The Payout Preference could not be saved. Please, try again.'));
				}
			    // it validated logic
			} else {
			    // didn't validate logic
			    $errors = $this->User->PayoutPreference->validationErrors;
			    $this->set(compact('errors'));
			}
			// create payout
		}

		$preferences =  $this->User->PayoutPreference->find('all', array(
			'conditions' => array('PayoutPreference.user_id' => $this->Auth->user('id')),
			'order' => array('PayoutPreference.id' => 'asc'),
			'recursive' => -1,
			'callbacks' => false,
		));

		// debug($preferences);

		// Grab available and selected payout methods
		$payments = $this->User->query('SELECT * FROM payments as Payment WHERE Payment.`is_enabled` = 1 AND Payment.`is_payout` = 1');

		App::uses('Country', 'Model');
		$Country = new Country();
		$countries = $Country->find('list', array(
	        'fields' => array('Country.iso_code', 'Country.name'),
	        'order' => array('Country.name' => 'ASC'),
	        'recursive' => -1,
	        'callbacks' => false
	    ));

	    $this->set(compact('countries', 'payments', 'preferences'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');

		if ($id !== $this->Auth->user('id')) {
			$this->Flash->error(__('You dont have permission to perform this action.'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->User->delete()) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/** EmCmsRentals
 * ================
 * This is the part where all the ADMIN functionalities are
 *
 * @author  Erland Muchasaj
 * @support <http://www.almsaeedstudio.com>
 * @email   <erland.muchasaj@gmail.com>
 * @version 1.0.0
 * @license MIT <http://opensource.org/licenses/MIT>
 */

/**
 * Get dashboard statistics
 *
 * @access public
 * @return json
 */
	public function getStatistics() {
		$this->autoRender = false;
		$this->layout = null;

		$response = [];

		$users = $this->User->find('count', [
			'recursive' => -1,
			'callbacks' => false
		]);

		$properties = $this->User->Property->find('count', array(
			'conditions' => array('Property.deleted' => null),
			'recursive' => -1,
			'callbacks' => false
		));

		$reservations = $this->User->Property->Reservation->find('count', array(
			'conditions' => array('Reservation.reservation_status' => 'completed'),
			'recursive' => -1,
			'callbacks' => false
		));

		$response['users'] = $users;
		$response['properties'] = $properties;
		$response['reservations'] = $reservations;

		// Also set the AJAX layout if needed
		return json_encode($response);
	}

/**
 * dashboard method
 *
 * @return void
 */
	public function admin_dashboard() {
		App::uses('Reservation', 'Model');
		$Reservation = new Reservation();
		$reservations = $Reservation->find('all', array(
			'contain' => array(
				'Property'
			),
			'limit' => 10,
			'order' => array('Reservation.created' => 'DESC'),
		));

		$language_id = $this->User->Property->PropertyTranslation->Language->getActiveLanguageId();
		$properties = $this->User->Property->find('all', array(
			'conditions' => array(
				'Property.deleted' => null,
				// 'Property.is_approved' => 1,
			),
			'limit' => 8,
			'order' => array('Property.created' => 'DESC'),
			'contain' => array(
				'PropertyTranslation' => array(
					'conditions' => array(
						'PropertyTranslation.language_id' => $language_id
					)
				),
				'User'
			)
		));

		$getActiveUsers = $this->User->UserSession->getActiveUsers();
		$countActiveUsers = $this->User->UserSession->countActiveUsers();
		$this->set(compact('getActiveUsers','countActiveUsers','reservations', 'properties'));
	}

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$conditions = array();
		//Transform POST into GET
		if(($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['User'])){
			$filter_url['controller'] = $this->request->params['controller'];
			$filter_url['action'] = $this->request->params['action'];
			// We need to overwrite the page every time we change the parameters
			$filter_url['page'] = 1;

			// for each filter we will add a GET parameter for the generated url
			foreach($this->request->data['User'] as $name => $value){
				if ($value){
					// You might want to sanitize the $value here
					// or even do a urlencode to be sure
					$filter_url[$name] = urlencode($value);
				}
			}
			// now that we have generated an url with GET parameters,
			// we'll redirect to that page
			return $this->redirect($filter_url, null, true);
		} else {
			// Inspect all the named parameters to apply the filters
			foreach($this->params['named'] as $param_name => $value){
				// Don't apply the default named parameters used for pagination
				if(!in_array($param_name, array('page','sort','direction','limit'))){
					// You may use a switch here to make special filters
					// like "between dates", "greater than", etc
					if($param_name == "search"){
						$words = explode(' ', $this->User->sanitize($value));
						$query = array();
						foreach ($words as $key => $word) {
							if (!empty($word) && strlen($word) >= 1) {
								$word = str_replace(array('%', '_'), array('\\%', '\\_'), $word);
								$start_search = '%';
								$end_search   = '%';
								$query[]['User.name LIKE '] =  ($word[0] == '-' ? $start_search.substr($word, 1, 15).$end_search : $start_search.substr($word, 0, 15).$end_search);
								$query[]['User.surname LIKE '] =  ($word[0] == '-' ? $start_search.substr($word, 1, 15).$end_search : $start_search.substr($word, 0, 15).$end_search);
								$query[]['User.email LIKE '] =  ($word[0] == '-' ? $start_search.substr($word, 1, 15).$end_search : $start_search.substr($word, 0, 15).$end_search);

								// ($word[0] == '-' ? ' \''.$start_search.substr($word, 1, 15).$end_search.'\'': ' \''.$start_search.substr($word, 0, 15).$end_search.'\'');
								// ($word[0] == '-' ? $start_search.substr($word, 1, 15).$end_search : $start_search.substr($word, 0, 15).$end_search)
								$conditions['OR'] = $query;
							} else {
               					unset($words[$key]);
            				}
						}

						// $conditions['OR'] = array(
						// 	'User.name LIKE' => '%'.$value.'%',
						// 	'User.surname LIKE' => '%'.$value.'%',
						// 	'User.email LIKE' => '%'.$value.'%'
						// );
					} else {
						$conditions['User.'.$param_name] = $value;
					}
					$this->request->data['User'][$param_name] = $value;
				}
			}
		}

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'limit' => 20,
			'order' => array(
				'User.id' => 'desc',
			),
			'recursive' => -1,
			'paramType' => 'querystring'
		);
		$users = $this->Paginator->paginate();
		$this->set('users', $users);

		// Pass the search parameter to highlight the text
		$this->set('search', isset($this->params['named']['search']) ? urldecode($this->params['named']['search']) : "");
	}

/**
 * view method
 *
 * @return void
 */
	public function admin_bannedUsers() {
		$this->Paginator->settings = array(
			'conditions' => array(
				'User.is_banned' => 1
			),
			'limit' => 20,
			'order' => array(
				'User.id' => 'desc',
			),
			'recursive' => -1,
			'paramType' => 'querystring'
		);
		$users = $this->Paginator->paginate();
		$this->set('users', $users);

		// Pass the search parameter to highlight the text
		$this->set('search', isset($this->params['named']['search']) ? urldecode($this->params['named']['search']) : "");
		$this->render('admin_index');
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		// debug($this->params['action']);
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array(
			'conditions' => array('User.' . $this->User->primaryKey => $id),
			'recursive' => 0,
			'contain' => array('UserProfile', 'Image')
		);
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add(){
		$errors = array();
		if ($this->request->is('post')) {
			$this->User->create();
			if (empty($this->request->data['User']['image_path']['name'])) {
				unset($this->request->data['User']['image_path']);
			}

			$this->request->data['User']['status'] = 1;
			// Using a custom salt value
			$activate = Security::hash('Activate', 'md5',  Configure::read('Security.salt'));
			$time	  = time();
			$code	  = sha1($activate.$this->request->data['User']['email'].$time).'-'.$time;
			$this->request->data['User']['activation_code'] = $code;
			if ($this->User->saveAll($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The user has been saved.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
				$errors = $this->User->validationErrors;
			}
		}
		$this->set('errors',$errors);
	}

/**
 * admin_profile method
 *
 * @return void
 */
	public function admin_edit($id = null) {
		if (!isset($id) || empty($id) || !$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['User']['image_path']['name'])) {
				unset($this->request->data['User']['image_path']);
			}
			if ($this->User->saveAll($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} 

		$user = $this->User->find('first', array('conditions' => array('User.' . $this->User->primaryKey => $id), 'contain'=>['UserProfile', 'Image']));
		$this->request->data = $user;

		$this->set('user', $user);
	}

/**
 * index method
 *
 * @return void
 */
	public function admin_ajaxindex() {
		$this->layout = null;
		$this->autoLayout = false;
		$this->autoRender = false;

		// $this->paginate = array('fields' => array('User.*'));
		/**
		Note: The mDataProp attribute is new in version 1.2. This returns JSON data in CakePHP format.
		Prior to 1.2 data was returned in a key-value pair and was cumbersome to work with. It is recommended
		you use the mDataProp. It's disabled by default to maintain backwards compatibility but will be made
		default in the future.
		**/
		$this->DataTable->mDataProp = true;

		$this->paginate = [
	        'fields' => [
	        	'User.name',
	        	'User.email',
	        	'User.role',
	        	'User.created',
	        ],
	        'conditions' => [
	            'role'=> 'user',
	        ]
	    ];

	    $response = $this->DataTable->getResponse();

		echo json_encode($response);
		die();

		// $this->set('response', $response);
		// $this->set('_serialize', 'response');
	}

/**
 * dashboard method
 *
 * @return void
 */
	public function admin_profile() {
		$id = $this->Auth->user('id');
		if (!isset($id) || empty($id) || !$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['User']['image_path']['name'])) {
				unset($this->request->data['User']['image_path']);
			}
			$this->request->data['UserProfile']['user_id'] = $this->Auth->user('id');
			if ($this->User->saveAll($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'profile'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
				// debug($this->User->validationErrors);
			}
		}

		$user = $this->User->find('first', array('conditions' => array('User.' . $this->User->primaryKey => $id), 'recursive'=>0));
		$this->request->data = $user;
		$this->set('user', $user);
	}

/**
 * changepassword method
 *
 * @return void
 */
	public function admin_changepassword($id = null) {
		if (!isset($id) || empty($id) || !$id) {
			throw new NotFoundException(__('No ID Suplied!'));
		}

		$this->User->id = $id;
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user!'));
		}

		if ($id != $this->Auth->user('id')) {
			$this->Flash->error(__(' Sorry! You can not access this page.'));
			return $this->redirect(array('action'=>'index'));
		}

		if ($this->request->is(array('post', 'put'))) {
			// debug($this->request->data);
			// die();
			if ($this->User->save($this->request->data)) {
				// $this->Activity->log($this->Model->id, 'ModelName', 'actionName', 'Description - optional');
				//$this->Activity->log($this->User->id, 'User', 'changepassword', 'User Changed Password');
				$this->Flash->success(__('Password changed succesfull.'));
				return $this->redirect(array('controller'=>'users', 'action' => 'dashboard'));
			} else {
				$this->Flash->error(__('Password could not be changed. Please try again!'));
			}
		} else {
			$this->request->data = $this->User->findById($id);
		}
	}

/**
 * admin_csv method
 *
 * @return mix
 */
	public function admin_backup(){
		Configure::write('debug', '0');
		$this->layout = null;
		$this->autoLayout = false;
		$this->autoRender = false;
		$folder = APP . 'webroot\backups\\'.date('Ymd\_His').'.sql';
		if ($this->BackUp->backup()) {
			$this->Flash->success(__('Database has been backed up successfully. PATH: %s.', $folder));
		} else {
			$this->Flash->error(__('Database could not be backed-up. Please try again later!'));
		}
		return $this->redirect($this->referer());
	}

/**
 * admin_csv method
 *
 * @return mix
 */
	public function admin_csv(){
		Configure::write('debug', '0');
		$this->set('users', $this->User->find('all', array('conditions'=>array('User.deleted'=>null, 'User.status'=>1),'fields'=>array( 'name', 'surname', 'User.email', 'User.birthday', 'User.gender', 'User.created'))));
		$this->layout = null;
		$this->autoLayout = false;
	}

/**
 * admin_xls method
 *
 * @return mix
 */
	public function admin_xls() {
		Configure::write('debug', '0');
		$this->set('users', $this->User->find('all', array('conditions'=>array('User.deleted'=>null, 'User.status'=>1),'fields'=>array( 'name', 'surname', 'User.email', 'User.birthday', 'User.gender', 'User.created'))));
		$this->layout = null;
		$this->autoLayout = false;
	}

/**
 * admin_profile method
 *
 * @return void
 */
	public function admin_sendEmail($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is(array('post', 'put'))) {
			// $viewVars = array();
			// $message = $this->request->data['User']['message'];
			// $options = array(
			// 	'viewVars' => $viewVars,	// variables passed to the view
			// 	'subject' => h($this->request->data['User']['subject']), // email subject,
			// 	'content' => h($message)
			// );
			// parent::__sendMail($this->request->data['User']['email'], $options);

			////////////////////////////////////////////////////////////////////////////////////
			$siteEmail = Configure::check('Website.email_from') ? Configure::read('Website.email_from') : 'do-not-reply@emcmsrental.com';
			$siteTitle = Configure::check('Website.email_from_name') ? Configure::read('Website.email_from_name') : 'EMCMS';
			////////////////////////////////////////////////////////////////////////////////////
			App::uses('CakeEmail', 'Network/Email');
			$Email = new CakeEmail();
			$Email->config('smtp') // smtp, default, fast, mailtrap
			    ->from([$siteEmail => $siteTitle])              
			    ->to([$this->request->data['User']['email']])
			    ->subject(h($this->request->data['User']['subject']));

			if ($Email->send(h($this->request->data['User']['message']))) {
				$this->Flash->success(__('The Email has been send.'));
			} else {
				$this->Flash->error(__('The Email could not be delivered. Please check thet configuraitons are correct.'));
			}
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->request->data = $this->User->find('first', array('conditions' => array('User.'.$this->User->primaryKey => $id)));
		}
	}

/**
 * admin_ban method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_ban($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');

		if ($id == $this->Auth->user('id')) {
			$this->Flash->error(__('You can not perform that action. Please, try again.'));
			return $this->redirect(array('action'=>'index'));
		}

		if ($this->User->saveField('is_banned', 1)) {
			// $this->Activity->log($this->User->id, 'User', 'admin_ban', 'Admin performed a ban action on this user');
			$this->Flash->success(__('The user has been banned.'));
		} else {
			$this->Flash->error(__('The user could not be banned. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_unban method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_unban($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post');

		if ($this->User->saveField('is_banned', 0)) {
			// $this->Activity->log($this->User->id, 'User', 'admin_ban', 'Admin performed a ban action on this user');
			$this->Flash->success(__('The user has been unbanned.'));
		} else {
			$this->Flash->error(__('The user could not be unbanned. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$this->request->allowMethod('post', 'delete');
		
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid User'));
		}

		if ($id == $this->Auth->user('id')) {
			$this->Flash->error(__('You can not perform that action. Please, try again.'));
			return $this->redirect(array('action'=>'index'));
		}

		if ($this->request->is('ajax')) {
			if ($this->User->delete($id, true)) {
				$response['type'] = 'success';
				$response['message'] = __('User has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('User could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} else {
			if ($this->User->delete($id, true)) {
				$this->Flash->success(__('User has been permanently deleted.'));
			} else {
				$this->Flash->error(__('User could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

}
