<?php

class TwilioComponent extends Component {

	protected $_twilio;

	protected $_from;

	/**
	 * Twilio Sid
	 * @var string
	 */
	public $AccountSid = null;

	/**
	 * Twilio AuthToken
	 * @var string
	 */
	private $AuthToken = null;
	
	/**
	 * mode, can be 'live' or 'sandbox' 
	 *
	 * @var string
	 */
	public $mode = 'sandbox';

	public function __construct() {	
		//get settings from config
		$mode = Configure::read('Twilio.mode');
		if ($mode && in_array($mode, ['live', 'sandbox'], true)) {
			$this->mode = $mode;
		}

		// set the TwoCheckout API privateKey
		$this->AccountSid = Configure::read('Twilio.' . $this->mode . '.AccountSid');
		if (!$this->AccountSid) {
			throw new CakeException('Twilio AccountSid key is not set');
		}

		$this->AuthToken = Configure::read('Twilio.' . $this->mode . '.AuthToken');
		if (!$this->AuthToken) {
			throw new CakeException('Twilio AuthToken key is not set');
		}

		$this->_from = Configure::read('Twilio.' . $this->mode . '.from');
		if (!$this->_from) {
			throw new CakeException('Twilio _from number is not set');
		}

		$loaded = App::import('Vendor', 'twilio/Twilio/autoload');
		if (!$loaded) {
			throw new CakeException('Twilio is missing or could not be loaded.');
		}

		if (!class_exists('Twilio\Rest\Client')) {
			throw new CakeException('Twilio\Rest\Client PHP Library not found. Be sure it is unpacked in app/Vendor/twilio directory.');
		}

		$this->_twilio = new Twilio\Rest\Client($this->AccountSid, $this->AuthToken);
	}

	/**
	 * sendSingleSms
	 *
	 * @example
	 * 		'accountSid' => 'ACde8fc5dfc06bb138b2316f5481e0e36e',
	 *  	'apiVersion' => '2010-04-01',
	 *  	'body' => 'Erland Muchasaj, Check this out. C u @ ATIS. :)',
	 *  	'dateCreated' => object(DateTime) {
	 *  		date => '2019-06-12 16:39:24.000000'
	 *  		timezone_type => (int) 1
	 *  		timezone => '+00:00'
	 *  	},
	 *  	'dateUpdated' => object(DateTime) {
	 *  		date => '2019-06-12 16:39:24.000000'
	 *  		timezone_type => (int) 1
	 *  		timezone => '+00:00'
	 *  	},
	 *  	'dateSent' => object(DateTime) {
	 *  		date => '2019-06-12 16:39:25.905311'
	 *  		timezone_type => (int) 3
	 *  		timezone => 'UTC'
	 *  	},
	 *  	'direction' => 'outbound-api',
	 *  	'errorCode' => null,
	 *  	'errorMessage' => null,
	 *  	'from' => '+15005550006',
	 *  	'messagingServiceSid' => null,
	 *  	'numMedia' => '0',
	 *  	'numSegments' => '1',
	 *  	'price' => null,
	 *  	'priceUnit' => 'USD',
	 *  	'sid' => 'SM32f90efe077c41c6b35ed83c18b4db93',
	 *  	'status' => 'queued',
	 *  	'subresourceUris' => array(
	 *  		'media' => '/2010-04-01/Accounts/ACde8fc5dfc06bb138b2316f5481e0e36e/Messages/SM32f90efe077c41c6b35ed83c18b4db93/Media.json'
	 *  	),
	 *  	'to' => '+355672190020',
	 *  	'uri' => '/2010-04-01/Accounts/ACde8fc5dfc06bb138b2316f5481e0e36e/Messages/SM32f90efe077c41c6b35ed83c18b4db93.json'
	 * @example
	 * 
	 * @param  string $to     
	 * @param  string $message
	 * @return [type]         
	 */
	public function sendSingleSms($to, $message) {
		try {
			$sms = $this->_twilio->messages->create($to, [ // Phone number which receives the message
			    'from' => $this->_from, // From a Twilio number in your account
			    'body' => $message,
			]);
		} catch (Exception $e) {
			throw $e;
			// debug($e->getMessage());
			// die;
		}
		return $sms;
		// debug($sms);
		// print($sms->sid);
		// die;
	}

	/**
	 * getMode
	 * @return string
	 */
	public function getMode() {
		return $this->mode;
	}

}
