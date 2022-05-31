<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('EmailLib', 'Lib');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $theme = 'Emcms';

	public $persistModel = true;

	public $helpers = array(
		'Html',
		'Form',
		'Session',
		'Time',
		'Flash',
	);

	public $components = array(
		'DebugKit.Toolbar',
		'Email',
		'Cookie',
		'Session',
		'Flash',
		'Gzip',
		'RequestHandler',
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'User',
					'fields' => array(
						'username' => 'email', //username=>email for logging in with email
						'password' => 'password'
					),
					'scope'=>array('User.status'=>1, 'User.is_banned'=>0),
					'passwordHasher' => 'Blowfish'
				),
			),
			'loginAction' => array('admin' => false, 'controller' => 'users', 'action' => 'login'),
			'loginRedirect' => array('admin' => false, 'controller' => 'properties', 'action' => 'index'),
			'logoutRedirect' => array('admin' => false, 'controller' => 'users', 'action' => 'login'),
			'authError' => 'You dont have permission for that action.',
			'authorize' => array('Controller'),
			'unauthorizedRedirect' => ['admin' => false, 'controller' => 'users', 'action' => 'access_denied']
		),
		'Maintenance.Maintenance' => array(
			'maintenanceUrl' => array('admin' => false, 'controller' => 'pages', 'action' => 'maintenance'),
			'allowedIp' => array('127.0.0.1'), // allowed IP address when maintanance status
			'allowedAction' => array(
				'contacts' => array('ajaxAddContact'),
				'site_settings' => array('getSettings', 'loadSettings'),
				'pages' => array('maintenance', 'disply', 'home'),
				'users' => array('login', 'logout', 'access_denied', 'isLoggedIn','getConfiguration')
			)
		)
	);

	/**
	 * Indicates whether a saving operation was blocked due to the system being in demo-mode
	 * @var boolean
	 */
	public static $demoBlocked = false;

	/**
	 * Indicates whether the demo-block should be ignored for the current operation
	 * @var boolean
	 */
	public static $demoBlockIgnore = false;

	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
	    self::$demoBlocked = Configure::read('demo');
	}
	
	/*****************************************************
	*  				BEFORE FILTER FUNCTION
	******************************************************/
	public function beforeFilter() {
		parent::beforeFilter();

		// $this->_handleRedirects();

		if ($this->request->is('json') || $this->request->is('xml')) {
		    $this->Auth->authenticate = [
		        'Basic' => [
		        	'userModel' => 'User',
		        	'fields' => [
		        		'username' => 'email',
		        		'password' => 'password'
		        	],
		        	'scope' => ['User.status' => 1, 'User.is_banned' => 0],
		        	'passwordHasher' => 'Blowfish'
		        ],
		    ];
		}
		$this->Auth->allow('display', 'home', 'maintanance');

		////////////////////////////////////////////////////////////////////////////////////
		// /**
		//  * Global Currenciy Variable
		//  * @deprecated Soon to be removed
		//  */
		// $this->loadModel('SiteSetting');
		// $globalSettings = $this->SiteSetting->getSiteSetting();
		////////////////////////////////////////////////////////////////////////////////////

		////////////////////////////////////////////////////////////////////////////////////
		// Global Currenciy Variable
		$this->loadModel('Currency');
		$global_currencies = $this->Currency->getCurrencyList('all');
		$localeCurrency = $this->Currency->getLocalCurrency();
		$this->_setCurrency($localeCurrency);
		////////////////////////////////////////////////////////////////////////////////////

		////////////////////////////////////////////////////////////////////////////////////
		// Global language Variable
		$this->loadModel('Language');
		$global_languages = $this->Language->getLanguageList('all');
		$language_code = $this->Language->getActiveLanguageCode();
		$this->_setLanguage($language_code, $global_languages);
		////////////////////////////////////////////////////////////////////////////////////
		
		if (isset($this->params['language']) && !empty($this->params['language'])) {
			$passedArgs = $this->request->params['named'] + $this->request->params['pass'];
			$availableLanguages = Hash::extract($global_languages, '{n}.Language.language_code');
			$defaultLang = Hash::extract($global_languages, '{n}.Language[is_default=1].language_code');
			$langCode = (isset($defaultLang[0])) ? $defaultLang[0] : 'it';
			if (!in_array($this->params['language'], $availableLanguages, true)) {
				$this->redirect(['language' => $langCode] + $passedArgs);
			}
		}

		if (AuthComponent::user()) {
			if (isset($this->params['prefix']) && ('admin' === $this->params['prefix'])) {
				$this->layout = 'admin';
			}
		} else {
			$this->Auth->authError = false;
		}

		if (!empty($this->request->params['ext'])) {
    		$this->Auth->unauthorizedRedirect['ext'] = $this->request->params['ext'];
		}

		$this->set(
			compact(
				// 'globalSettings',
				'global_currencies',
				'localeCurrency',
				'global_languages',
				'language_code'
			)
		);
	}

	/*****************************************************
	*  				BEFORE RENDER FUNCTION
	******************************************************/
	public function beforeRender(){
		parent::beforeRender();

		if ($this->name == 'CakeError') {
			$this->layout = 'error';
		}

		switch(true) {
			case $this->request->is('ajax'):
			case (!empty($this->request->params['ext']) && $this->request->params['ext'] == 'json'):
				if (isset($this->viewVars['json'])) {
					$this->viewVars['json'] = array('json' => $this->viewVars['json']);
					$this->set('_serialize', 'json');
				}
				//Configure::write('debug', 0);
				break;

			case $this->request->is('ajax'):

				break;

			/*case $this->RequestHandler->prefers('rss'):
				;
				break;

			case $this->RequestHandler->prefers('vcf'):
				;
				break;*/
		}

		// lets load the menu for the front end
		if (empty($this->params['prefix'])) {
			$this->loadModel('Page');
			$emcms_topMenu 	  = $this->Page->menu(null, 'top');
			$emcms_bottomMenu = $this->Page->menu(null, 'bottom');
			$this->set(compact('emcms_topMenu', 'emcms_bottomMenu'));
		}
	}

	/*****************************************************
	*				PRIVATE SET LANGUAGE
	******************************************************/
	private function _setLanguage($defaultLanguage = 'en', $globalLanguages = []) {

		if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
			$this->Session->write('Config.language', $this->Cookie->read('lang'));
		} elseif (isset($this->params['language']) && ($this->params['language'] != $this->Session->read('Config.language'))){

			$languageCode = trim($this->params['language']);
			$availableLanguages = Hash::extract($globalLanguages, '{n}.Language.language_code');
			if (!in_array($languageCode, $availableLanguages, true)) {
				$languageCode = $defaultLanguage;
			}

			$this->Session->write('Config.language', $languageCode);
			$this->Cookie->write('lang', $languageCode, false, '2 days');
		}
		
		//ensure that both I18n and TranslateBehavior access the same language value.
		if ($this->Session->check('Config.language')) {
			Configure::write('Config.language', $this->Session->read('Config.language'));
			CakeSession::write('Config.language', $this->Session->read('Config.language'));
		}
	}

	/*****************************************************
	*				PRIVATE SET CURRENCY
	******************************************************/
	protected function _setCurrency($defaultCurrency = 'EUR') {
		if (!$this->Session->check('LocaleCurrency')) {
			$this->Session->write('LocaleCurrency', $defaultCurrency);
		}
	}

	/*****************************************************
	*				OVERWRITE BEFORE REDIRECT
	******************************************************/
	public function beforeRedirect($url, $status = null, $exit = true) {
		//Only for demo purposes
		if (self::$demoBlocked === true) {
			$this->Flash->error(__('You cannot perform any changes in the demonstration system.'), [
			    'clear' => true,
			]);
		}
	}

	/*****************************************************
	*				OVERWRITE REDIRECT
	******************************************************/
	public function redirect($url = null, $status = null, $exit = true) {
		if (is_array($url)) {
			if ((!isset($url['language']) || empty($url['language'])) && $this->Session->check('Config.language')) {
				$url['language'] = $this->Session->read('Config.language');
			}
		}
		parent::redirect($url, $status, $exit);
	}

	/**
	 * _handleRedirects auto-redirect to specific url
	 * @return bolean | redirect
	 */
	protected function _handleRedirects() {
		$here = rtrim($this->here, '/\\');
		// $here = trim(Router::url(null, true), '/');
		if (!empty($this->request->query)) {
			$here .= '?' . http_build_query($this->request->query);
		}

		$this->loadModel('Redirect');
		$redirect = $this->Redirect->getRedirect($here);
		if ($redirect) {
			return $this->redirect($redirect, 301);
		}
		return false;
	}

	/**
	 * send E-mail method
	 *
	 * @param mixed $to email or array of emails as recipients
	 * @param array $options list of options for email sending. Possible keys:
	 * @return boolean
	 */
	public static function __sendMail($emailTo, array $options = []) {
		EmailLib::__sendMail($emailTo, $options);
	}

	/**
	 * Check if the provided user is authorized for the request.
	 *
	 * Uses the configured Authorization adapters to check whether or not a user is authorized.
	 * Each adapter will be checked in sequence, if any of them return true, then the user will
	 * be authorized for the request.
	 *
	 * @param array|null $user The user to check the authorization of. If empty the user in the session will be used.
	 * @param CakeRequest|null $request The request to authenticate for. If empty, the current request will be used.
	 * @return bool True if $user is authorized, otherwise false
	 */
	public function isAuthorized($user = null) {
		// Any registered user can access public functions
		if (!isset($this->params['prefix']) && empty($this->request->params['admin'])) {
			return true;
		}

		// Only admins can access admin functions
		if (isset($this->request->params['admin'])) {
			return (bool)('admin' === $user['role']);
		}

		// Default deny
		return false;
	}
	
	/*****************************************************
	*  		 FUNCTION TO GET SITE URL
	******************************************************/
	public function siteURL(){
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];
		return $protocol.$domainName;
	}
	
}
