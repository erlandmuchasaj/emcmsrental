<?php 
/**
 * 2Checkout Component
 * 
 * A component that handles payment processing using 2Checkout.
 *
 * PHP 5
 * 
 * Licensed under The MIT License
 * 
 * @package		StripeComponent
 * @version		2.0
 * @author		http://erlandmuchasaj.com
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link		https://github.com/
 * 
 * Stripe php documentation
 * @link	https://stripe.com/docs/api/php
 */

App::uses('Component', 'Controller');

/**
 * StripeComponent
 *
 * @package		StripeComponent
 */
class TwoCheckoutComponent extends Component {

	/**
	 * TwoCheckout mode, can be 'live' or 'sandboox' 
	 * @defaults = sandboox
	 * @var string
	 */
	public $mode = 'sandboox';

	/**
	 * TwoCheckout format, can be 'array' or 'json' 
	 * @defaults = array
	 * @var string
	 */
	public $format = 'array';

	/**
	 * TwoCheckout verifySSL, can be true | false
	 * @defaults = false
	 * @var bool
	 */
	public $verifySSL = false;

	/**
	 * TwoCheckout API privateKey
	 *
	 * @var string
	 */
	public $privateKey = null;

	/**
	 * TwoCheckout sellerId
	 *
	 * @var string
	 */
	public $sellerId = null;

	/**
	 * Default currency to use for the transaction
	 *
	 * @var string
	 * @access public
	 */
	public $currency = 'eur';

	/**
	 * Initialize component
	 *
	 * @param Controller $controller Instantiating controller
	 * @return void
	 */
	public function initialize(Controller $controller) {
		$this->Controller = $controller;

		$loaded = App::import('Vendor', '2Checkout/Twocheckout');
		// abort if vendor class wasn't autoloaded and can't be found.
		if (!$loaded) {
			throw new CakeException('2Checkout is missing or could not be loaded.');
		}

		if (!class_exists('Twocheckout')) {
			throw new CakeException('Twocheckout PHP Library not found. Be sure it is unpacked in app/Vendor/2Checkout directory. It can be downloaded from https://github.com/2Checkout');
		}
		
		// if mode is not set in bootstrap, defaults to 'sandbox' 
		$mode = Configure::read('TwoCheckout.mode');
		if ($mode && in_array($mode, ['live', 'sandbox'], true)) {
			$this->mode = $mode;
		}

		// if format is not set in bootstrap, defaults to 'array' 
		$format = Configure::read('TwoCheckout.format');
		if ($format && in_array($format, ['array', 'json'], true)) {
			$this->format = $format;
		}

		// if format is not set in bootstrap, defaults to 'array' 
		$verifySSL = Configure::read('TwoCheckout.verifySSL');
		if ($verifySSL) {
			$this->verifySSL = (bool) $verifySSL;
		}

		// if currency is not set, defaults to 'usd'
		$currency = Configure::read('TwoCheckout.currency');
		if ($currency) {
			$this->currency = EMCMS_strtolower($currency);
		}

		// set the TwoCheckout API privateKey
		$this->privateKey = Configure::read('TwoCheckout.' . $this->mode . '.privateKey');
		if (!$this->privateKey) {
			throw new CakeException('TwoCheckout API privateKey is not set');
		}

		$this->sellerId = Configure::read('TwoCheckout.' . $this->mode . '.sellerId');
		if (!$this->sellerId) {
			throw new CakeException('TwoCheckout API sellerId is not set');
		}
		
		// $this->setEnvironmentVariable();
	}		


	public function getMode() {
		return $this->mode;
	}

	public function getFormat() {
		return $this->format;
	}

	public function getPrivateKey() {
		return $this->privateKey;
	}
	
	public function getSellerId() {
		return $this->sellerId;
	}

	public function setEnvironmentVariable() {
		Twocheckout::privateKey($this->privateKey); // Private Key
		Twocheckout::sellerId($this->sellerId); // 2Checkout Account Number

		// If you want to turn off SSL verification (Please don't do this in your production environment)
		Twocheckout::verifySSL($this->verifySSL); // this is set to true by default

		// To use your sandbox account set sandbox to true
		if ($this->mode === 'sandbox') {
			Twocheckout::sandbox(true);
		} else {
			// Set to false for production accounts.
			Twocheckout::sandbox(false);
		}
		// All methods return an Array by default or you can set the format to 'json' to get a JSON response.
		Twocheckout::format($this->format); // 2Checkout Account Number
	}

	public function test() {
		try {
			$charge = Twocheckout_Charge::auth(array(
		        "merchantOrderId" => "123",
		        "token"      => 'MjFiYzIzYjAtYjE4YS00ZmI0LTg4YzYtNDIzMTBlMjc0MDlk',
		        "currency"   => 'USD',
		        "total"      => '10.00',
		        "billingAddr" => array(
		            "name" => 'Testing Tester',
		            "addrLine1" => '123 Test St',
		            "city" => 'Columbus',
		            "state" => 'OH',
		            "zipCode" => '43123',
		            "country" => 'USA',
		            "email" => 'example@2co.com',
		            "phoneNumber" => '555-555-5555'
		        )
		    ));

		    return $charge;
		} catch (Twocheckout_Error $e) {
			throw $e;
		}
	}

/**
 * updateCustomer method
 * Updates the customer info
 *
 * @param string $customerId
 * @param array $fields - fields to be updated
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#update_customer
 */
	public function updateCustomer($customerId = null, $fields = array()) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (empty($fields)) {
			throw new CakeException(__('Update fields are empty'));
		}

		// return $this->request(__FUNCTION__, $data);
	}

}