<?php

/**
 * CakePHP HybridauthComponent
 * @author Erland Muchasaj
 */
class HybridauthComponent extends Component {

	public $hybridauth   = null;
	public $adapter      = null;
	public $userProfile = null;
	public $error        = 'no error so far';
	public $provider     = null;
	public $debug_mode   = false;
	public $debug_file   = "hybridauth.log";

	public function __construct() {	

		//get settings from config
		if (!Configure::check('Hybridauth')) {
			throw new CakeException('Hybridauth is not set');
		}

		$loaded = App::import('Vendor', 'hybridauth/Hybrid/Auth');
		if (!$loaded) {
			throw new CakeException('Hybridauth library is missing or could not be loaded.');
		}

		if (!class_exists('Hybrid_Auth')) {
			throw new CakeException('Hybrid_Auth PHP Library not found. Be sure it is unpacked in app/Vendor/ directory.');
		}

		// set the TwoCheckout API privateKey
		$this->debug_mode = Configure::read('Hybridauth.debug_mode');
		$this->debug_file = Configure::read('Hybridauth.debug_file');

		// $this->hybridauth = new Hybrid_Auth(Configure::read('Hybridauth'));

	}

	protected function _init() {
		// App::import('Vendor', 'hybridauth/Hybrid/Auth');
		$this->hybridauth = new Hybrid_Auth(Configure::read('Hybridauth'));
	}

	/**
	 * process the
	 *
	 * @return string
	 */
	public function processEndpoint() {
		App::import('Vendor', 'hybridauth/Hybrid/Endpoint');

		if (!$this->hybridauth) {
			$this->_init();
		}

		Hybrid_Endpoint::process();
	}

	/**
	 * get serialized array of acctual Hybridauth from provider...
	 *
	 * @return string
	 */
	public function getSessionData(){
		if (!$this->hybridauth)
			$this->_init();

		return $this->hybridauth->getSessionData();
	}

	/**
	 *
	 * @param string $hybridauth_session_data pass a serialized array stored previously
	 */
	public function restoreSessionData( $hybridauth_session_data ){
		if( !$this->hybridauth )
			$this->_init();

		$hybridauth->restoreSessionData( $hybridauth_session_data );
	}

	/**
	 * logs you out
	 */
	public function logout(){
		if (!$this->hybridauth) {
			$this->_init();
		}

		$providers = $this->hybridauth->getConnectedProviders();
		if (isset($provider) && !empty($providers)) {
			foreach ($providers as $provider) {
				$adapter = $this->hybridauth->getAdapter($provider);
				$adapter->logout();
			}
		}
	}

	/**
	 * connects to a provider
	 *
	 *
	 * @param string $provider pass Google, Facebook etc...
	 * @return boolean wether you have been logged in or not
	 */
	public function connect($provider) {

		if (!$this->hybridauth) {
			$this->_init();
		}

		try {
			// try to authenticate the selected $provider
			$this->adapter = $this->hybridauth->authenticate($provider);

			//Returns a boolean of whether the user is connected with Facebook
			$isConnected = $this->adapter->isUserConnected();

			if ($this->adapter) {
				// grab the user profile from the logded-in user
				$this->userProfile = $this->_getUser($provider, $this->adapter);
				return true;
			}
			return false;
		} catch (Exception $e) {
			// Display the recived error
			switch ($e->getCode()) {
				case 0:
					$this->error = "Unspecified error:" . $e->getMessage();
					break;
				case 1:
					$this->error = "Hybriauth configuration error.";
					break;
				case 2: 
					$this->error = "Provider [".$provider."] not properly configured.";
					break;
				case 3: 
					$this->error =  "[" .$provider. "] is an unknown or disabled provider.";
					break;
				case 4: 
					$this->error = "Missing provider application credentials for Provider [".$provider."].";
					break;
				case 5: 
					$this->error = "Authentification failed. The user has canceled the authentication or the provider [" .$provider. "] refused the connection.";
					break;
				case 6: 
					$this->error = "User profile request failed. Most likely the user is not connected to the provider [" .$provider. "] and he/she should try to authenticate again.";
					$this->adapter->logout();
					break;
				case 7: 
					$this->error = "User not connected to the provider [" .$provider. "].";
					$this->adapter->logout();
					break;
				default:
					$this->error = "Ooophs, we got an error: " . $e->getMessage();
					break;
			}
			return false;
		}
	}

	/**
	 * creates a social profile array based on the hybridauth profile object
	 *
	 *
	 * @param string $provider the provider given from hybridauth
	 * @return boolean wether you have been logged in or not
	 */
	protected function _getUser($provider, $adapter){
		// convert our object to an array
		$incomingProfile = $adapter->getUserProfile();

		list($firstname, $lastname) = explode(" ", $incomingProfile->displayName, 2);

		// Social Profile
		$socialProfile['SocialProfile']['social_network_name'] = $provider;
		$socialProfile['SocialProfile']['social_network_id'] = $incomingProfile->identifier;
		// User
		$socialProfile['SocialProfile']['first_name']   = !empty($incomingProfile->firstName) ? $incomingProfile->firstName : $firstname;
		$socialProfile['SocialProfile']['last_name']    = !empty($incomingProfile->lastName) ? $incomingProfile->lastName : $lastname;
		$socialProfile['SocialProfile']['email']        = $incomingProfile->email;
		$socialProfile['SocialProfile']['gender']       = $incomingProfile->gender;
		$socialProfile['SocialProfile']['display_name'] = $incomingProfile->displayName;
		$socialProfile['SocialProfile']['image_path']   = $incomingProfile->photoURL;
		$socialProfile['SocialProfile']['username']     = $incomingProfile->email;
		// User profile
		$socialProfile['SocialProfile']['company'] 		= $incomingProfile->organization_name;
		$socialProfile['SocialProfile']['job_title'] 	= $incomingProfile->job_title;
		$socialProfile['SocialProfile']['about']        = $incomingProfile->description;
		$socialProfile['SocialProfile']['address']      = $incomingProfile->address;
		$socialProfile['SocialProfile']['zip']          = $incomingProfile->zip;
		$socialProfile['SocialProfile']['city']         = $incomingProfile->city;
		$socialProfile['SocialProfile']['country']      = $incomingProfile->country;
		$socialProfile['SocialProfile']['region']       = $incomingProfile->region;
		$socialProfile['SocialProfile']['phone'] 		= $incomingProfile->phone;
		$socialProfile['SocialProfile']['url']			= $incomingProfile->webSiteURL;
		$socialProfile['SocialProfile']['link']         = $incomingProfile->profileURL;
		$socialProfile['SocialProfile']['created']      = date('Y-m-d h:i:s');
		$socialProfile['SocialProfile']['modified']     = date('Y-m-d h:i:s');

		return $socialProfile;
	}

}
