<?php 
/**
 * Stripe Component
 * 
 * A component that handles payment processing using Stripe.
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
 * Compatible with Stripe API version 3.4.0
 * 
 * ***** IMPORTANT ******
 * Stripe PHP library is not included, it should be downloaded from Stripe's website
 * @link	https://stripe.com/docs/libraries  
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
class StripeComponent extends Component {

/**
 * Minimum and maximum charge amounts
 *
 * @var array
 */
	public $min_max = [
		'USD' => '0.50',
		'AUD' => '0.50',
		'BRL' => '0.50',
		'CAD' => '0.50',
		'CHF' => '0.50',
		'DKK' => '2.50',
		'EUR' => '0.50',
		'GBP' => '0.30',
		'HKD' => '4.00',
		'JPY' => '50',
		'MXN' => '10',
		'NOK' => '3.00',
		'NZD' => '0.50',
		'SEK' => '3.00',
		'SGD' => '0.50',
	];

/**
 * The limit amount that user can chare 
 *
 * @var string
 */
	public $amount_limit = '99999999';

/**
 * Stripe mode, can be 'Live' or 'Test' 
 *
 * @var string
 */
	public $mode = 'Test';

/**
 * Stripe API Secret key
 *
 * @var string
 */
	public $key = null;

/**
 * Stripe API Publishable key
 * Used with Checkout JS or element JS of stripe
 * @var string
 */
	private $publishable = null;

/**
 * Default currency to use for the transaction
 *
 * @var string
 * @access public
 */
	public $currency = 'eur';

/**
 * Default mapping of fields to be returned: local_field => stripe_field
 *
 * @var array
 * @access public
 */
	public $fields = array('stripe_id' => 'id');

/**
 * 
 * If provided, statuses will be saved in that file, default is false
 * if enabled, log should be added in bootstrap, e.g. if log file should be in tmp/logs/stripe.log
 * 
 *	CakeLog::config('stripe', array(
 *		'engine' => 'FileLog',
 *		'file' => 'stripe',
 *	));
 *
 * @var string
 */
	public $logFile = false;

/**
 * Can be 'both', 'success' or 'error', to what results to save, default is 'error'
 *
 * @var string
 */
	public $logType = 'error';

/**
 *  For saving the reflection class, to use in the loop
 *
 * @protected array
 */
	protected $reflectionClass = array();

/**
 * Valid parameters that can be included in the call to Stripe_Charge::create
 *
 * @var array
 * @access protected
 */
	protected $_chargeParams = array(
		'amount',
		'currency',
		'customer',
		'card',
		'description',
		'metadata',
		'capture',
		'statement_descriptor',
		'receipt_email',
		'application_fee',
		'shipping',
		'source'
	);

/**
 * Initialize component
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */

	public function initialize(Controller $controller) {
		$this->Controller = $controller;

		$loaded = App::import('Vendor', 'Stripe/init');
		// abort if vendor class wasn't autoloaded and can't be found.
		if (!$loaded) {
			throw new CakeException('Stripe is missing or could not be loaded.');
		}

		if (!class_exists('Stripe\Stripe')) {
			throw new CakeException('Stripe PHP Library not found. Be sure it is unpacked in app/Vendor/Stripe directory. It can be downloaded from https://stripe.com/docs/libraries');
		}
		
		// if mode is not set in bootstrap, defaults to 'Test' 
		$mode = Configure::read('Stripe.mode');
		if ($mode) {
			$this->mode = $mode;
		}

		// set the Stripe API key
		$this->key = Configure::read('Stripe.Secret');
		if (!$this->key) {
			throw new CakeException('Stripe API Secret key is not set');
		}

		// set the Stripe API key
		$this->publishable = Configure::read('Stripe.Publishable');
		if (!$this->publishable) {
			throw new CakeException('Stripe Publishable API key is not set');
		}
		
		// if currency is not set, defaults to 'usd'
		$currency = Configure::read('Stripe.currency');
		if ($currency) {
			$this->currency = EMCMS_strtolower($currency);
		}

		$this->setApiKey();
	}

	public function getPublishableKey() {
		return $this->publishable;
	}	
	
	public function getCents($price) {
		// $card = [
		// 	'number' => '4242424242424242',
		// 	'exp_month' => 2,
		// 	'exp_year' => 2020,
		// 	'cvc' => '314'
		// ];
		// $token = $this->createCardToken($card);
		// debug($token);
		// die();

		// $this->setApiKey();
		// $charge = $this->fetch(Stripe\Charge::create([
		// 	'card' => $token['id'],
		// 	'currency' => 'usd',
		// 	'amount' => '158',
		// 	'description' => 'Add in wallet',
		// ]));
		// debug($charge);
		// $response = Stripe\Token::create([
		// 	"card" => [
		// 		"number" => "4242424242424242",
		// 		"exp_month" => 2,
		// 		"exp_year" => 2020,
		// 		"cvc" => "314"
		// 	]
		// ]);
		// debug($response->jsonSerialize());
		// die();

		return ($price*100);
	}
	
	public function getUsd($price, $currency = false) {
		return number_format($price/100, 2) . ($currency ? EMCMS_strtoupper($this->currency) : '');
	}
	
	public function setApiKey() {
		Stripe\Stripe::setApiKey($this->key);
	}
	
/**
 * charge method
 * Charges the given credit card(card id, array or token) or customer
 *
 * @param array $data
 * @param string $customerId[optional] 
 * @return array
 * 
 * @link https://stripe.com/docs/api#create_charge
 */
	public function charge($data = null, $customerId = null) {
		if (!$customerId && empty($data['card']) && empty($data['source'])) {
			throw new CakeException(__('Customer Id or Card is required'));
		}

		if ($customerId) {
			$data['customer'] = $customerId;
		}
		
		// set default currency
		if (!isset($data['currency'])) {
			$data['currency'] = $this->currency;
		}

		// pass metadata to stripe object
		if (isset($data['reservation']) && !empty($data['reservation'])) {
			if (is_array($data['reservation'])) {
				$data['metadata'] = $data['reservation'];
			} else {
				$data['metadata'] = [$data['reservation']];
			}
			unset($data['reservation']);
		}

		$data['expand'] = ["customer"];

		return $this->request(__FUNCTION__, $data);
	}

/**
 * retrieveCharge method
 * Retrieves the details of a charge that has previously been created
 *
 * @param string $chargeId
 * @return array
 * 
 * @link https://stripe.com/docs/api#retrieve_charge
 */
	public function retrieveCharge($chargeId = null) {
		if (!$chargeId) {
			throw new CakeException(__('Charge Id is required'));
		}
		
		$data = array(
			'charge_id' => $chargeId	
		);
		
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * updateCharge method
 * Updates the specified charge
 *
 * @param string $chargeId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#update_charge
 */
	public function updateCharge($chargeId = null, $data = array()) {
		if (!$chargeId) {
			throw new CakeException(__('Charge Id is not provided'));
		}

		if (empty($data)) {
			throw new CakeException(__('No data is provided to updates the card'));
		}
	
		$data = array(
			'charge_id' => $chargeId,
			'fields' => $data,
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * refundCharge method
 * Refunds a charge that has previously been created but not yet refunded
 *
 * @param string $chargeId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#refund_charge
 */
	public function refundCharge($chargeId = null, $data = array()) {
		if (!$chargeId) {
			throw new CakeException(__('Charge Id is not provided'));
		}
	
		$data['charge_id'] = $chargeId;

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * captureCharge method
 * Capture the payment of an existing, uncaptured, charge.
 *
 * @param string $chargeId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#charge_capture
 */
	public function captureCharge($chargeId = null, $data = array()) {
		if (!$chargeId) {
			throw new CakeException(__('Charge Id is not provided'));
		}
	
		$data['charge_id'] = $chargeId;

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * listCharges method
 * Returns a list of charges you've previously created
 *
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#list_charges
 */
	public function listCharges($data = array()) {
		$data = array(
			'options' => $data
		);
	
		return $this->request(__FUNCTION__, $data);
	}

/**
 * createCustomer method
 * Creates a new customer
 *
 * @param array	$data - according to customer object
 * @return array
 * 
 * @link  https://stripe.com/docs/api/php#create_customers
 */
	public function createCustomer($data) {
		if (empty($data) || !is_array($data)) {
			throw new CakeException(__('Data is empty or is not an array'));
		}

		return $this->request(__FUNCTION__, $data);
	}

/**
 * retrieveCustomer method
 * Retrives the customer information
 *
 * @param string $customerId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#retrieve_customer
 */
	public function retrieveCustomer($customerId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}

		$data = array(
			'customer_id' => $customerId	
		);

		return $this->request(__FUNCTION__, $data);
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

		$data = array(
			'customer_id' => $customerId,	
			'fields' => $fields
		);

		return $this->request(__FUNCTION__, $data);
	}

/**
 * deleteCustomer method
 * Deletes the customer
 *
 * @param string $customerId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#delete_customer
 */
	public function deleteCustomer($customerId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * listCustomers method
 * Returns array with customers
 * 
 * As this is an expensive call(Reflection class is used to convert objects to arrays) use limit wisely
 *
 * @param array $data
 * @param array $cards - default is false, if true each customers cards will be returned as array
 * @param array $subscriptions - default is false, if true each customers subscriptions will be returned as array
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#list_customers
 */
	public function listCustomers($data = array()) {
		$data = array(
			'options' => $data
		);
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * createCard method
 * Creates a new card for the given customer
 * 
 * @param string $customerId
 * @param mixed $data - card data, token or array 
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#create_card
 */
	public function createCard($customerId = null, $card = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$card) {
			throw new CakeException(__('Card data is not provided'));
		}
		
		$metadata = array();
		if (!empty($card['metadata'])) {
			$metadata = $card['metadata'];
			unset($card['metadata']);
		}
		
		$card['object'] = 'card';
		$data = array(
			'customer_id' => $customerId,
			'source' => $card
		);
		
		if (!empty($metadata)) {
			$data['metadata'] = $metadata;
		}

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * retrieveCard method
 * Retrives an existing card for the given customer
 * 
 * @param string $customerId
 * @param string $cardId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#retrieve_card
 */
	public function retrieveCard($customerId = null, $cardId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$cardId) {
			throw new CakeException(__('Card Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'card_id' => $cardId
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * updateCard method
 * Updates an existing card for the given customer
 * 
 * @param string $customerId
 * @param string $cardId
 * @param array $data
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#update_card
 */
	public function updateCard($customerId = null, $cardId = null, $data = array()) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$cardId) {
			throw new CakeException(__('Card Id is not provided'));
		}
		
		if (empty($data)) {
			throw new CakeException(__('No data is provided to updates the card'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'card_id' => $cardId,
			'fields' => $data,
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * deleteCard method
 * Deletes an existing card for the given customer
 * 
 * @param string $customerId
 * @param string $cardId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#delete_card
 */
	public function deleteCard($customerId = null, $cardId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$cardId) {
			throw new CakeException(__('Card Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'card_id' => $cardId
		);

		return $this->request(__FUNCTION__, $data);
	}

/**
 * listCards method
 * Returs cards for the given customer
 * 
 * @param string $customerId
 * @param string $cardId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#list_cards
 */
	public function listCards($customerId = null, $data = array()) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'options' => $data
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * createSubscription method
 * Creates a new subscription for the given customer
 * 
 * @param int $customerId
 * @param array $data - subscription data, token or array 
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#create_subscription
 */
	public function createSubscription($customerId = null, $subscription = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$subscription) {
			throw new CakeException(__('Subscription data is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'subscription' => $subscription
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * retrieveSubscription method
 * Retrives an existing subscription for the given customer
 * 
 * @param string $customerId
 * @param string $subscriptionId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#retrieve_subscription
 */
	public function retrieveSubscription($customerId = null, $subscriptionId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$subscriptionId) {
			throw new CakeException(__('Subscription Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'subscription_id' => $subscriptionId
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * updateSubscription method
 * Updates an existing subscription for the given customer
 * 
 * @param string $customerId
 * @param string $subscriptionId
 * @param array $data
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#update_subscription
 */
	public function updateSubscription($customerId = null, $subscriptionId = null, $data = array()) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$subscriptionId) {
			throw new CakeException(__('Subscription Id is not provided'));
		}
		
		if (empty($data)) {
			throw new CakeException(__('No data is provided to update the subscription'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'subscription_id' => $subscriptionId,
			'fields' => $data,
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * cancelSubscription method
 * Cancels an existing subscription for the given customer
 * 
 * @param string $customerId
 * @param string $subscriptionId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#cancel_subscription
 */
	public function cancelSubscription($customerId = null, $subscriptionId = null, $atPeriodEnd = false) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$subscriptionId) {
			throw new CakeException(__('Subscription Id is not provided'));
		}
		
		$data = array(
			'at_period_end' => $atPeriodEnd,
			'customer_id' => $customerId,
			'subscription_id' => $subscriptionId
		);

		return $this->request(__FUNCTION__, $data);
	}

/**
 * listSubscriptions method
 * Returs subscriptions for the given customer
 * 
 * @param string $customerId
 * @param string $subscriptionId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#list_subscriptions
 */
	public function listSubscriptions($customerId = null, $data = array()) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'options' => $data
		);

		return $this->request(__FUNCTION__, $data);
	}

/**
 * createPlan method
 * Creates a new subscription plan
 * 
 * @param array $data
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#create_plan
 */
	public function createPlan($data = array()) {
		if (empty($data) || !is_array($data)) {
			throw new CakeException(__('Data is empty or is not an array'));
		}
		
		// set default currency
		if (!isset($data['currency'])) {
			$data['currency'] = $this->currency;
		}
		
		return $this->request(__FUNCTION__, $data);
	}

/**
 * retrievePlan method
 * Retrieves the existing subscription plan
 * 
 * @param string $planId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#retrieve_plan
 */
	public function retrievePlan($planId = null) {
		if (!$planId) {
			throw new CakeException(__('Plan Id is required'));
		}

		$data = array(
			'plan_id' => $planId	
		);
		
		return $this->request(__FUNCTION__, $data);
	}

/**
 * updatePlan method
 * Updates the existing subscription plan
 * 
 * @param string $planId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#update_plan
 */
	public function updatePlan($planId = null, $data = array()) {
		if (!$planId) {
			throw new CakeException(__('Plan Id is required'));
		}
		
		if (empty($data)) {
			throw new CakeException(__('No data is provided to updates the plan'));
		}

		$data = array(
			'plan_id' => $planId,
			'fields' => $data
		);
		
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * deletePlan method
 * Deletes the existing subscription plan
 * 
 * @param string $planId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#delete_plan
 */
	public function deletePlan($planId = null) {
		if (!$planId) {
			throw new CakeException(__('Plan Id is required'));
		}
		
		$data = array(
			'plan_id' => $planId,
		);
		
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * listPlans method
 * Returns all the plans
 * 
 * @param array $data
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#list_plans
 */
	public function listPlans($data = array()) {
		$data = array(
			'options' => $data,
		);
		
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * createCoupon method
 * Creates a new coupon
 * 
 * @param array $data
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#create_coupon
 */
	public function createCoupon($data = array()) {
		if (empty($data) || !is_array($data)) {
			throw new CakeException(__('Data is empty or is not an array'));
		}
		
		// set default currency
		if (!isset($data['currency'])) {
			$data['currency'] = $this->currency;
		}
		
		return $this->request(__FUNCTION__, $data);
	}	

/**
 * retrieveCoupon method
 * Retrieves the existing coupon
 * 
 * @param string $couponId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#retrieve_coupon
 */
	public function retrieveCoupon($couponId = null) {
		if (!$couponId) {
			throw new CakeException(__('Coupon Id is required'));
		}

		$data = array(
			'coupon_id' => $couponId	
		);
		
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * deleteCoupon method
 * Deletes the existing coupon
 * 
 * @param string $couponId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#delete_coupon
 */
	public function deleteCoupon($couponId = null) {
		if (!$couponId) {
			throw new CakeException(__('Coupon Id is required'));
		}
		
		$data = array(
			'coupon_id' => $couponId,
		);
		
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * listCoupons method
 * Returns all the plans
 * 
 * @param array $data
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#list_coupons
 */
	public function listCoupons($data = array()) {
		$data = array(
			'options' => $data,
		);
		
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * deleteCustomerDiscount method
 * Removes the currently applied discount on a customer
 * 
 * @param string $customerId
 * @return array
 * 
 * @link https://stripe.com/docs/api/php#delete_discount
 */
	public function deleteCustomerDiscount($customerId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId	
		);
		
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * deleteSubscriptionDiscount method
 * Removes the currently applied discount on a subscription.
 * 
 * @param string $customerId
 * @param string $subscriptionId
 * @return array
 * 
 * @link https://stripe.com/docs/api#delete_subscription_discount
 */
	public function deleteSubscriptionDiscount($customerId = null, $subscriptionId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		if (!$subscriptionId) {
			throw new CakeException(__('Subscription Id is not provided'));
		}
		
		$data = array(
			'customer_id' => $customerId,
			'subscription_id' => $subscriptionId
		);

		return $this->request(__FUNCTION__, $data);
	}

/**
 * retrieveInvoice method
 * Retrives an existing invoice
 *
 * @param string $invoiceId
 * @return array
 *
 * @link https://stripe.com/docs/api/php#retrieve_invoice
 */
	public function retrieveInvoice($invoiceId = null) {
		if (!$invoiceId) {
			throw new CakeException(__('Invoice Id is not provided'));
		}
	
		$data = array(
				'invoice_id' => $invoiceId
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * retrieveInvoiceLine method
 * Retrives an existing invoice's line
 *
 * @param string $invoiceId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#invoice_lines
 */
	public function retrieveInvoiceLine($invoiceId = null, $data = array()) {
		if (!$invoiceId) {
			throw new CakeException(__('Invoice Id is not provided'));
		}
	
		$data = array(
				'invoice_id' => $invoiceId,
				'options' => $data
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * createInvoice method
 * Creates a new invoice
 *
 * @param string $customerId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#create_invoice
 */
	public function createInvoice($customerId = null, $data = array()) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
	
		$data['customer'] = $customerId;
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * payInvoice method
 * Pay invoice
 *
 * @param string $invoiceId
 * @return array
 *
 * @link https://stripe.com/docs/api#pay_invoice
 */
	public function payInvoice($invoiceId = null) {
		if (!$invoiceId) {
			throw new CakeException(__('Invoice Id is not provided'));
		}
	
		$data['invoice_id'] = $invoiceId;
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * updateInvoice method
 * Update Invoice
 *
 * @param string $invoiceId
 * @return array
 *
 * @link https://stripe.com/docs/api#update_invoice
 */
	public function updateInvoice($invoiceId = null, $data = array()) {
		if (!$invoiceId) {
			throw new CakeException(__('Invoice Id is not provided'));
		}
	
		if (empty($data)) {
			throw new CakeException(__('Data is empty for updating the invoice'));
		}
	
		$data = array(
			'invoice_id' => $invoiceId,
			'fields' => $data
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * listInvoices method
 * List all invoices, if customer id is provided, only corresponding invoices will be returned 
 *
 * @param string $customerId - not required
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#list_customer_invoices
 */
	public function listInvoices($customerId = null, $data = array()) {
		$data['customer'] = $customerId;

		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * retrieveUpcomingInvoice method
 *  
 * @param string $customerId - not required
 * @param string $subscriptionId
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_customer_invoice
 */
	public function retrieveUpcomingInvoice($customerId = null, $subscriptionId = null) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
		
		$data = array(
			'customer' => $customerId,	
			'subscription' => $subscriptionId
		);

		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * createInvoiceItem method
 * Adds an arbitrary charge or credit to the customer's upcoming invoice.
 *
 * @param string $customerId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#create_invoiceitem
 */
	public function createInvoiceItem($customerId = null, $data = array()) {
		if (!$customerId) {
			throw new CakeException(__('Customer Id is not provided'));
		}
	
		$data['customer'] = $customerId;
		if (!isset($data['currency'])) {
			$data['currency'] = $this->currency;
		}
		
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * retrieveInvoiceItem method
 * Retrieves the invoice item with the given ID.
 *
 * @param string $invoiceItemId
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_invoiceitem
 */
	public function retrieveInvoiceItem($invoiceItemId = null) {
		if (!$invoiceItemId) {
			throw new CakeException(__('Invoice Item Id is not provided'));
		}
	
		$data = array(
			'invoice_item_id' => $invoiceItemId		
		);
		
		return $this->request(__FUNCTION__, $data);
	}
		
/**
 * updateInvoiceItem method
 * Updates the amount or description of an invoice item on an upcoming invoice. 
 * Updating an invoice item is only possible before the invoice it's attached to is closed.
 *
 * @param string $invoiceId
 * @return array
 *
 * @link https://stripe.com/docs/api#update_invoiceitem
 */
	public function updateInvoiceItem($invoiceItemId = null, $data = array()) {
		if (!$invoiceItemId) {
			throw new CakeException(__('Invoice Item Id is not provided'));
		}
	
		$data = array(
			'invoice_item_id' => $invoiceItemId,
			'fields' => $data		
		);
		
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * deleteInvoiceItem method
 * Removes an invoice item from the upcoming invoice. Removing an invoice item is only possible before the invoice it's attached to is closed.
 *
 * @param string $invoiceId
 * @return array
 *
 * @link https://stripe.com/docs/api#delete_invoiceitem
 */
	public function deleteInvoiceItem($invoiceItemId = null) {
		if (!$invoiceItemId) {
			throw new CakeException(__('Invoice Item Id is not provided'));
		}
	
		$data = array(
			'invoice_item_id' => $invoiceItemId		
		);
		
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * listInvoiceItems method
 * Returns a list of your invoice items. Invoice Items are returned sorted by creation date, with the most recently created invoice items appearing first.
 *
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#list_invoiceitems
 */
	public function listInvoiceItems($data = array()) {
		$data = array(
			'options' => $data		
		);
		
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * updateDispute method
 *
 * @param string $chargeId
 * @param array $data
 * @return array
 * 
 * @link https://stripe.com/docs/api#update_dispute
 */
	public function updateDispute($chargeId = null, $data = array()) {
		if (!$chargeId) {
			throw new CakeException(__('Charge Id is not provided'));
		}
		
		if (empty($data)) {
			throw new CakeException(__('Data is empty for updating the dispute'));
		}
		
		$data = array(
			'charge_id' => $chargeId,
			'dispute' => $data
		);

		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * closeDispute method
 * Closes the dispute, which changes the status from "under_review" to "lost"
 *
 * @param string $chargeId
 * @return array
 * 
 * @link https://stripe.com/docs/api#close_dispute
 */
	public function closeDispute($chargeId = null) {
		if (!$chargeId) {
			throw new CakeException(__('Charge Id is not provided'));
		}

		$data = array(
			'charge_id' => $chargeId,
		);

		return $this->request(__FUNCTION__, $data);
	}	

/**
 * createTransfer method
 * Used to send funds from your Stripe account to a third-party recipient or to your own bank account
 *
 * @param string $recipientId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api/php#create_transfer
 */
	public function createTransfer($recipientId = null, $data = array()) {
		if (!$recipientId) {
			throw new CakeException(__('Recipient Id is not provided'));
		}
	
		if (empty($data)) {
			throw new CakeException(__('Transfer data is not provided'));
		}
	
		$data['recipient'] = $recipientId;

		if (!isset($data['currency'])) {
			$data['currency'] = $this->currency;
		}
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * retrieveTransfer method
 * Retrieves the details of an existing transfer
 *
 * @param string $recipientId
 * @param string $transferId
 * @return array
 *
 * @link https://stripe.com/docs/api/php#retrieve_transfer
 */
	public function retrieveTransfer($transferId = null) {
		if (!$transferId) {
			throw new CakeException(__('Transfer Id is not provided'));
		}
	
		$data = array(
			'transfer_id' => $transferId
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * updateTransfer method
 * Updates an existing transfer
 *
 * @param string $recipientId
 * @param string $transferId
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api/php#update_transfer
 */
	public function updateTransfer($transferId = null, $data = array()) {
		if (!$transferId) {
			throw new CakeException(__('Transfer Id is not provided'));
		}
	
		if (empty($data)) {
			throw new CakeException(__('No data is provided to update the transfer'));
		}
	
		$data = array(
			'transfer_id' => $transferId,
			'fields' => $data
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * cancelTransfer method
 * Cancels an existing transfer
 *
 * @param string $recipientId
 * @param string $transferId
 * @return array
 *
 * @link https://stripe.com/docs/api/php#cancel_transfer
 */
	public function cancelTransfer($transferId = null) {
		if (!$transferId) {
			throw new CakeException(__('Transfer Id is not provided'));
		}
	
		$data = array(
			'transfer_id' => $transferId
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * listTransfers method
 * Returs transfers
 *
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api/php#list_transfers
 */
	public function listTransfers($data = array()) {
		$data = array(
			'options' => $data
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * createCardToken method
 * Creates a single use token that wraps the details of a credit card.
 *
 * @param array $data - card data
 * @param array $customerId [optional]
 * @return array
 *
 * @link https://stripe.com/docs/api#create_card_token
 */
	public function createCardToken($card = null, $customerId = null) {
		if (!$card) {
			throw new CakeException(__('Card data is not provided'));
		}

		$defaults = [
		    'exp_month' => '', // Two-digit number representing the card's expiration month. REQUIRED
		    'exp_year'  => '', // Two- or four-digit number representing the card's expiration year. REQUIRED
		    'number' 	=> '', // The card number, as a string without any separators. REQUIRED
		    'cvc' 		=> '', // Show orders created at or before date  USUALLY REQUIRED
		    // 'currency'  => 'usd', // Required in order to add the card to an account CUSTOM ONLY
		    // 'name'  => '', // Cardholder's full name - optional
		    // 'address_line1'  => '', // - optional
		    // 'address_line2'  => '', //  - optional
		    // 'address_city'  => '', //  - optional
		    // 'address_state'  => '', //  - optional
		    // 'address_zip'   => '', // ZIP or postal code. - optional
		    // 'address_country'  => '', // Billing address country, if provided. - optional
		];
		$cardParams = array_merge($defaults, $card);
		
		$data = array(
			'customer' => $customerId,
			'card' => $cardParams,
		);
	
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * createBankAccountToken method
 * Creates a single use token that wraps the details of a bank account.
 *
 * @param array $data - card data	
 * @return array
 *
 * @link https://stripe.com/docs/api#create_bank_account_token
 */
	public function createBankAccountToken($bankAccount = null) {
		if (!$bankAccount) {
			throw new CakeException(__('Bank Account is not provided'));
		}
		
		$data = array(
			'bank_account' => $bankAccount
		);
	
		return $this->request(__FUNCTION__, $data);
	}

/**
 * createCardToken method
 * Create a PII token.
 *
 * @param array $data - card data
 * @param array $customerId [optional]
 * @return array
 *
 * @link https://stripe.com/docs/api/tokens/create_pii
 */
	public function createPersonalIDToken($personal_id_number = null) {
		if (!$personal_id_number) {
			throw new CakeException(__('The personal_id_number for the PII, in string form is  required'));
		}
		
		$data = array(
			'pii' => [
				'personal_id_number' => $personal_id_number
			]
		);
	
		return $this->request(__FUNCTION__, $data);
	}	

/**
 * retrieveToken method
 * Retrieves the token with the given ID.
 *
 * @param string $tokenId
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_token
 */
	public function retrieveToken($tokenId = null) {
		if (!$tokenId) {
			throw new CakeException(__('Token Id is not provided'));
		}

		$data = array(
			'token_id' => $tokenId
		);
	
		return $this->request(__FUNCTION__, $data);
	}
		
/**
 * createRecipient method
 * Creates a new recipient
 *
 * @param array	$data - according to recipient object
 * @return array
 *
 * @link  https://stripe.com/docs/api#create_recipient
 */
	public function createRecipient($data) {
		if (empty($data) || !is_array($data)) {
			throw new CakeException(__('Data is empty or is not an array'));
		}
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * retrieveRecipient method
 * Retrives the recipient information
 *
 * @param string $recipientId
 * @return array
 *
 * @link https://stripe.com/docs/api/php#retrieve_recipient
 */
	public function retrieveRecipient($recipientId = null) {
		if (!$recipientId) {
			throw new CakeException(__('Recipient Id is not provided'));
		}
	
		$data = array(
			'recipient_id' => $recipientId
		);
	
		return $this->request(__FUNCTION__, $data);
	}
		
/**
 * updateRecipient method
 * Updates the recipient info
 *
 * @param string $recipientId
 * @param array $fields - fields to be updated
 * @return array
 *
 * @link https://stripe.com/docs/api/php#update_recipient
 */
	public function updateRecipient($recipientId = null, $fields = array()) {
		if (!$recipientId) {
			throw new CakeException(__('Recipient Id is not provided'));
		}
	
		if (empty($fields)) {
			throw new CakeException(__('Update fields are empty'));
		}
	
		$data = array(
			'recipient_id' => $recipientId,
			'fields' => $fields
		);
	
		return $this->request(__FUNCTION__, $data);
	}
		
/**
 * deleteRecipient method
 * Deletes the recipient
 *
 * @param string $recipientId
 * @return array
 *
 * @link https://stripe.com/docs/api/php#delete_recipient
 */
	public function deleteRecipient($recipientId = null) {
		if (!$recipientId) {
			throw new CakeException(__('Recipient Id is not provided'));
		}
	
		$data = array(
				'recipient_id' => $recipientId
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * listRecipients method
 * Returns array with recipients
 *
 * This is an expensive call(Reflection class is used to convert objects to arrays) use limit to get only the items you need
 *
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api/php#list_recipients
 */
	public function listRecipients($data = array()) {
		$data = array(
			'options' => $data
		);
		return $this->request(__FUNCTION__, $data);
	}	

/**
 * retrieveApplicationFee method
 * Retrieves the details of an application fee that your account has collected
 *
 * @param string $applicationFeeId
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_application_fee
 */
	public function retrieveApplicationFee($applicationFeeId = null) {
		if (!$applicationFeeId) {
			throw new CakeException(__('Application Fee Id is not provided'));
		}
		
		$data = array(
			'application_fee_id' => $applicationFeeId
		);

		return $this->request(__FUNCTION__, $data);
	}
		
/**
 * refundApplicationFee method
 * Returns a list of application fees you've previously collected
 *
 * @param string $applicationFeeId
 * @param int $amount
 * @return array
 *
 * @link https://stripe.com/docs/api#refund_application_fee
 */
	public function refundApplicationFee($applicationFeeId = null) {
		if (!$applicationFeeId) {
			throw new CakeException(__('Application Fee Id is not provided'));
		}
		
		$data['application_fee_id'] = $applicationFeeId;
		
		return $this->request(__FUNCTION__, $data);
	}	

/**
 * listApplicationFees method
 * Returns a list of application fees you've previously collected
 *
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#list_application_fees
 */
	public function listApplicationFees($data = array()) {
		$data = array(
			'options' => $data
		);
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * retrieveAccount method
 * Retrieves the details of the account, based on the API key that was used to make the request.
 *
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_account
 */
	public function retrieveAccount() {
		$data = array();
		return $this->request(__FUNCTION__, $data);
	}		
	
/**
 * retrieveBalance method
 * Retrieves the current account balance, based on the API key that was used to make the request.
 *
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_balance
 */
	public function retrieveBalance() {
		$data = array();
		return $this->request(__FUNCTION__, $data);
	}	
		
/**
 * retrieveBalanceTransaction method
 * Retrieves the balance transaction with the given ID.
 *
 * @param string $transactionId
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_balance_transaction
 */
	public function retrieveBalanceTransaction($transactionId = null) {
		if (!$transactionId) {
			throw new CakeException(__('Transaction Id is not provided'));
		}
		
		$data = array(
			'transaction_id' => $transactionId
		);

		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * listBalanceHistory method
 * Returns a list of transactions that have contributed to the Stripe account balance (includes charges, refunds, transfers, and so on).
 *
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#balance_history
 */
	public function listBalanceHistory($data = array()) {
		$data = array(
			'options' => $data
		);

		return $this->request(__FUNCTION__, $data);
	}	

/**
 * retrievePlan method
 * Retrieves the details of an event
 *
 * @param string $eventId
 * @return array
 *
 * @link https://stripe.com/docs/api#retrieve_event
 */
	public function retrieveEvent($eventId = null) {
		if (!$eventId) {
			throw new CakeException(__('Event Id is required'));
		}
	
		$data = array(
			'event_id' => $eventId
		);
	
		return $this->request(__FUNCTION__, $data);
	}	
	
/**
 * listEvents method
 * List events, going back up to 30 days.
 *
 * @param array $data
 * @return array
 *
 * @link https://stripe.com/docs/api#list_events
 */
	public function listEvents($data = array()) {
		$data = array(
			'options' => $data,
		);
	
		return $this->request(__FUNCTION__, $data);
	}
	
/**
 * request method
 * 
 * @param string $method
 * @param array $data
 *  	
 * @return array - containing 'status', 'message' and 'data' keys
 * 	if response was successful, keys will be 'success', 'Success' and the stripe response as associated array respectively,
 *  if request failed, keys will be 'error', the card error message if it was card_error, boolen false otherwise, 
 *  and error data as an array respectively
 */	
	private function request($method = null, $data = null, $extraData = null) {

		if (!$method) {
			throw new CakeException(__('Request method is missing'));
		}

		if (is_null($data)) {
			throw new CakeException(__('Request Data is not provided'));
		}
		
		// $this->setApiKey();
		
		$error = null;
		$success = null;
		$message = false;
		
		try {
			switch ($method) {
				
				/**
				 * 	
				 * 		CHARGES	
				 *  
				 */
				case 'charge':
					$success = $this->fetch(Stripe\Charge::create($data));
					break;
				case 'retrieveCharge':
					$success = $this->fetch(Stripe\Charge::retrieve($data['charge_id']));
					if (!empty($success['refunds'])) {
						foreach ($success['refunds'] as &$refund) {
							$refund = $this->fetch($refund);
						}
					}
					break;
				case 'updateCharge':
					$charge = Stripe\Charge::retrieve($data['charge_id']);
				
					foreach ($data['fields'] as $field => $value) {
						$charge->$field = $value;
					}

					$success = $this->fetch($charge->save());
					break;
				case 'refundCharge':
					$charge = Stripe\Charge::retrieve($data['charge_id']);
					
					// to prevent unknown param error
					unset($data['charge_id']);
					$success = $this->fetch($charge->refund($data));
					
					foreach ($success['refunds']['data'] as &$refund) {
						$refund = $this->fetch($refund);
					}
					break;
				case 'captureCharge':
					$charge = Stripe\Charge::retrieve($data['charge_id']);
					
					unset($data['charge_id']);
					$success = $this->fetch($charge->capture($data));

					if (!empty($success['refunds']['data'])) {
						foreach ($success['refunds']['data'] as &$refund) {
							$refund = $this->fetch($refund);
						}
					}

					break;
				case 'listCharges':
					$charges = Stripe\Charge::all();
					$success = $this->fetch($charges);
				
					foreach ($success['data'] as &$charge) {
						$charge = $this->fetch($charge);
						
						if (isset($charge['refunds']['data']) && !empty($charge['refunds']['data'])) {
							foreach ($charge['refunds']['data'] as &$refund) {
								$refund = $this->fetch($refund);
							}
							unset($refund);
						}
					}
					unset($charge);
					break;
				

				/**
				 * 		CUSTOMERS
				 */
				case 'createCustomer':
					$customer = Stripe\Customer::create($data);
					$success = $this->fetch($customer);
					
					if (!empty($success['cards']['data'])) {
						foreach ($success['cards']['data'] as &$card) {
							$card = $this->fetch($card);
						}
						unset($card);
					}
						
					if (!empty($success['subscriptions']['data'])) {
						foreach ($success['subscriptions']['data'] as &$subscription) {
							$subscription = $this->fetch($subscription);
						}
						unset($subscription);
					}
					
					break;
				case 'retrieveCustomer':
					$customer = Stripe\Customer::retrieve($data['customer_id']);
					$success = $this->fetch($customer);
					
					if (!empty($success['cards']['data'])) {
						foreach ($success['cards']['data'] as &$card) {
							$card = $this->fetch($card);
						}
						unset($card);
					}
					
					if (!empty($success['subscriptions']['data'])) {
						foreach ($success['subscriptions']['data'] as &$subscription) {
							$subscription = $this->fetch($subscription);
						}
						unset($subscription);
					}

					break;
				case 'updateCustomer':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					
					foreach ($data['fields'] as $field => $value) {
						$cu->$field = $value;
					}
					
					$success = $this->fetch($cu->save());
					
					if (!empty($success['cards']['data'])) {
						foreach ($success['cards']['data'] as &$card) {
							$card = $this->fetch($card);
						}
						unset($card);
					}
					
					if (!empty($success['subscriptions']['data'])) {
						foreach ($success['subscriptions']['data'] as &$subscription) {
							$subscription = $this->fetch($subscription);
						}
						unset($subscription);
					}
					
					break;
				case 'deleteCustomer':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$success = $this->fetch($cu->delete());
					
					break;
				case 'listCustomers':
					$customers = Stripe\Customer::all($data['options']);
					$success = $this->fetch($customers);
					
					foreach ($success['data'] as &$customer) {
						$customer = $this->fetch($customer);
						
						if (!empty($customer['cards']['data'])) {
							foreach ($customer['cards']['data'] as &$card) {
								$card = $this->fetch($card);
							}
							unset($card);
						}

						if (!empty($customer['subscriptions']['data'])) {
							foreach ($customer['subscriptions']['data'] as &$subscription) {
								$subscription = $this->fetch($subscription);
							}
							unset($subscription);
						}
					}
					
					break;
					
					
				/**
				 * 		CARDS
				 *  	
				 */	
				case 'createCard':
					$cu = Stripe\Customer::retrieve($data['customer_id']);

					$validCardFields = array(
						'object',
						'address_zip',
						'address_city',
						'address_state',
						'address_country',
						'address_line1',
						'address_line2',
						'number',
						'exp_month',
						'exp_year',
						'cvc',
						'name',
						'metadata'
					);
					
					// unset not valid keys to prevent unknown parameter stripe error
					unset($data['customer_id']);
					foreach ($data['source'] as $k => $v) {
						if (!in_array($k, $validCardFields)) {
							unset($data['source'][$k]);
						}
					}

					$card = $cu->sources->create($data);					
					$success = $this->fetch($card);
					
					break;
				case 'retrieveCard':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$card = $cu->sources->retrieve($data['card_id']);

					$success = $this->fetch($card);
					break;
				case 'updateCard':	
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$cuCard = $cu->sources->retrieve($data['card_id']);

					foreach ($data['fields'] as $field => $value) {
						$cuCard->$field = $value;
					}
					
					$card = $cuCard->save();					
					
					$success = $this->fetch($card);
					break;
				case 'deleteCard':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$card = $cu->sources->retrieve($data['card_id'])->delete();
					
					$success = $this->fetch($card);
					break;
				case 'listCards':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$cards = $cu->sources->all($data['options']);
					$success = $this->fetch($cards); 

					foreach ($success['data'] as &$card) {
						$card = $this->fetch($card);
					}
					
					break;
					

				/**
				 * 		SUBSCRIPTIONS
				 *  	
				 */	
				case 'createSubscription':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					
					// unset customer_id to prevent unknown parameter stripe error
					unset($data['customer_id']);
					$subscription = $cu->subscriptions->create($data['subscription']);					

					$success = $this->fetch($subscription);
					break;
				case 'retrieveSubscription':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$subscription = $cu->subscriptions->retrieve($data['subscription_id']);

					$success = $this->fetch($subscription);
					break;
				case 'updateSubscription':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$cuSubscription = $cu->subscriptions->retrieve($data['subscription_id']);

					foreach ($data['fields'] as $field => $value) {
						$cuSubscription->$field = $value;
					}
					
					$subscription = $cuSubscription->save();					
					
					$success = $this->fetch($subscription);
					break;
				case 'cancelSubscription':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$subscription = $cu->subscriptions->retrieve($data['subscription_id'])->cancel($data['at_period_end']);
					
					$success = $this->fetch($subscription);
					break;
				case 'listSubscriptions':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$subscriptions = $cu->subscriptions->all($data['options']);
					$success = $this->fetch($subscriptions); 

					foreach ($success['data'] as &$subscription) {
						$subscription = $this->fetch($subscription);
					}
					
					break;
					
					
				/**
				 * 		PLANS
				 *  	
				 */	
				case 'createPlan':
					$plan = Stripe\Plan::create($data);
					$success = $this->fetch($plan);
					break;
				case 'retrievePlan':
					$plan = Stripe\Plan::retrieve($data['plan_id']);
					$success = $this->fetch($plan);
					break;
				case 'updatePlan':
					$p = Stripe\Plan::retrieve($data['plan_id']);
					
					foreach ($data['fields'] as $field => $value) {
						$p->$field = $value;
					}

					$plan = $p->save();
					$success = $this->fetch($plan);
					break;
				case 'deletePlan':
					$p = Stripe\Plan::retrieve($data['plan_id']);
					$plan = $p->delete();
					
					$success = $this->fetch($plan);
					break;
				case 'listPlans':
					$plans = Stripe\Plan::all($data['options']);
					$success = $this->fetch($plans);
					
					foreach ($success['data'] as &$plan) {
						$plan = $this->fetch($plan);
					}
					break;
					
					
				/**
				 * 	 	COUPONS
				 * 	
				 */	
				case 'createCoupon':
					$coupon = Stripe\Coupon::create($data);
					$success = $this->fetch($coupon);
					break;
				case 'retrieveCoupon':
					$coupon = Stripe\Coupon::retrieve($data['coupon_id']);
					$success = $this->fetch($coupon);
					break;
				case 'deleteCoupon':
					$c = Stripe\Coupon::retrieve($data['coupon_id']);
					$coupon = $c->delete();
						
					$success = $this->fetch($coupon);
					break;
				case 'listCoupons':
					$coupons = Stripe\Coupon::all($data['options']);
					$success = $this->fetch($coupons);
						
					foreach ($success['data'] as &$coupon) {
						$coupon = $this->fetch($coupon);
					}
					break;
					
					
				/**
				 * 	 	DISCOUNTS
				 *
				 */
				case 'deleteCustomerDiscount':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$discount = $cu->deleteDiscount();
					
					$success = $this->fetch($discount);
					break;
				case 'deleteSubscriptionDiscount':
					$cu = Stripe\Customer::retrieve($data['customer_id']);
					$discount = $cu->subscriptions->retrieve($data['subscription_id'])->deleteDiscount();
					
					$success = $this->fetch($discount);
					break;


					
				/**
				 * 
				 * 	INVOICES
				 * 
				 */
				case 'retrieveInvoice':
					$coupon = Stripe\Invoice::retrieve($data['invoice_id']);
					$success = $this->fetch($coupon);
					
					if (!empty($success['lines']['data'])) {
						foreach ($success['lines']['data'] as &$invoice) {
							$invoice = $this->fetch($invoice);
						}
					}
					break;
				case 'retrieveInvoiceLine':
					$in = Stripe\Invoice::retrieve($data['invoice_id'])->lines->all($data['options']);
					$success = $this->fetch($in);
					
					if (!empty($success['data'])) {
						foreach ($success['data'] as &$invoice) {
							$invoice = $this->fetch($invoice);
						}
					}
					break;
				case 'createInvoice':
					$invoice = Stripe\Invoice::create($data);
					$success = $this->fetch($invoice);
					break;
				case 'payInvoice':
					$invoice = Stripe\Invoice::retrieve($data['invoice_id']);
					$in = $invoice->pay();

					$success = $this->fetch($in);
					break;
				case 'updateInvoice':
					$in = Stripe\Invoice::retrieve($data['invoice_id']);
						
					foreach ($data['fields'] as $field => $value) {
						$in->$field = $value;
					}

					$invoice = $in->save();
					$success = $this->fetch($invoice);
					
					if (!empty($success['lines']['data'])) {
						foreach ($success['lines']['data'] as &$invoice) {
							$invoice = $this->fetch($invoice);
						}
					}
					
					break;
				case 'listInvoices':
					$invocies = Stripe\Invoice::all($data);
					$success = $this->fetch($invocies);
				
					if (!empty($success['data'])) {
						foreach ($success['data'] as &$invoice) {
							$invoice = $this->fetch($invoice);
							
							if (!empty($invoice['lines']['data'])) {
								foreach ($invoice['lines']['data'] as &$invoiceLine) {
									$invoiceLine = $this->fetch($invoiceLine);
								}
								unset($invoiceLine);
							}
							
						}
					}
					break;
				case 'retrieveUpcomingInvoice':
					$invoice = Stripe\Invoice::upcoming($data);
					$success = $this->fetch($invoice);

					if (!empty($success['lines']['data'])) {
						foreach ($success['lines']['data'] as &$invoice) {
							$invoice = $this->fetch($invoice);
						}
					}
					break;
					


				/**
				 * 
				 *  	INVOICE ITEMS
				 *  	
				 */	
				case 'createInvoiceItem':
					$success = $this->fetch(Stripe\InvoiceItem::create($data));
					break;
				case 'retrieveInvoiceItem':
					$success = $this->fetch(Stripe\InvoiceItem::retrieve($data['invoice_item_id']));
					break;
				case 'updateInvoiceItem':
					$ii = Stripe\InvoiceItem::retrieve($data['invoice_item_id']);
					
					foreach ($data['fields'] as $field => $value) {
						$ii->$field = $value;
					}
					
					$success = $this->fetch($ii->save());
					break;
				case 'deleteInvoiceItem':
					$ii = Stripe\InvoiceItem::retrieve($data['invoice_item_id']);
					
					$success = $this->fetch($ii->delete());
					break;
				case 'listInvoiceItems':
					$ii = Stripe\InvoiceItem::all($data['options']);
					$success = $this->fetch($ii);
				
					if (!empty($success['data'])) {
						foreach ($success['data'] as &$card) {
							$card = $this->fetch($card);
						}
					}
						
					break;



				/**
				 * 		DISPUTES
				 *  	
				 */	
				case 'updateDispute':
					$ch = Stripe\Charge::retrieve($data['charge_id']);
					$success = $this->fetch($ch->updateDispute($data['dispute']));
					break;
				case 'closeDispute':
					$ch = Stripe\Charge::retrieve($data['charge_id']);
					$success = $this->fetch($ch->closeDispute());
					break;



				/**
				 * 
				 * 		TRANSFERS
				 *  
				 */	
				case 'createTransfer':
					$success = $this->fetch(Stripe\Transfer::create($data));

					break;
				case 'retrieveTransfer':
					$success = $this->fetch(Stripe\Transfer::retrieve($data['transfer_id']));
					break;
				case 'updateTransfer':
					$tr = Stripe\Transfer::retrieve($data['transfer_id']);
					
					foreach ($data['fields'] as $field => $value) {
						$tr->$field = $value;
					}
						
					$success = $this->fetch($tr->save());
					break;
				case 'cancelTransfer':
					$tr = Stripe\Transfer::retrieve($data['transfer_id']);
					$success = $this->fetch($tr->cancel());
					break;
				case 'listTransfers':
					$tr = Stripe\Transfer::all($data['options']);
					$success = $this->fetch($tr);

					foreach ($success['data'] as &$transfer) {
						$transfer = $this->fetch($transfer);
						
						// charge_fee_details
						if (isset($transfer['summary']['charge_fee_details']) && !empty($transfer['summary']['charge_fee_details'])) {
							foreach ($transfer['summary']['charge_fee_details'] as &$chargeFee) {
								$chargeFee = $this->fetch($chargeFee);
							}
							unset($chargeFee);
						}

						// refund_fee_details
						if (isset($transfer['summary']['refund_fee_details']) && !empty($transfer['summary']['refund_fee_details'])) {
							foreach ($transfer['summary']['refund_fee_details'] as &$refundFee) {
								$refundFee = $this->fetch($refundFee);
							}
							unset($refundFee);
						}

						// adjustment_fee_details
						if (isset($transfer['summary']['adjustment_fee_details']) && !empty($transfer['summary']['adjustment_fee_details'])) {
							foreach ($transfer['summary']['adjustment_fee_details'] as &$adjustmentFee) {
								$adjustmentFee = $this->fetch($adjustmentFee);
							}
							unset($adjustmentFee);
						}

						// transactions
						if (isset($transfer['transactions']['data']) && !empty($transfer['transactions']['data'])) {
							foreach ($transfer['transactions']['data'] as &$transaction) {
								$transaction = $this->fetch($transaction);

								// fee details
								if (isset($transaction['fee_details']) && !empty($transaction['fee_details'])) {
									foreach ($transaction['fee_details'] as &$feeDetails) {
										$feeDetails = $this->fetch($feeDetails);
									}
									unset($feeDetails);
								}
							}
							unset($transaction);
						}
					}
					
					break;
							


				/**
				 * 
				 * 	RECIPIENTS
				 *  
				 */	
				case 'createRecipient':
					$recipient = Stripe\Recipient::create($data);
					$success = $this->fetch($recipient);
						
					if (!empty($success['cards']['data'])) {
						foreach ($success['cards']['data'] as &$card) {
							$card = $this->fetch($card);
						}
						unset($card);
					}
				
					break;
				case 'retrieveRecipient':
					$recipient = Stripe\Recipient::retrieve($data['recipient_id']);
					$success = $this->fetch($recipient);
						
					if (!empty($success['cards']['data'])) {
						foreach ($success['cards']['data'] as &$card) {
							$card = $this->fetch($card);
						}
						unset($card);
					}
						
					break;
				case 'updateRecipient':
					$rp = Stripe\Recipient::retrieve($data['recipient_id']);
						
					foreach ($data['fields'] as $field => $value) {
						$rp->$field = $value;
					}
						
					$success = $this->fetch($rp->save());

					if (!empty($success['cards']['data'])) {
						foreach ($success['cards']['data'] as &$card) {
							$card = $this->fetch($card);
						}
						unset($card);
					}
						
					break;
				case 'deleteRecipient':
					$rp = Stripe\Recipient::retrieve($data['recipient_id']);
					$success = $this->fetch($rp->delete());
						
					break;
				case 'listRecipients':
					$recipients = Stripe\Recipient::all($data['options']);
					$success = $this->fetch($recipients);
						
					foreach ($success['data'] as &$recipient) {
						$recipient = $this->fetch($recipient);
				
						if (!empty($recipient['cards']['data'])) {
							foreach ($recipient['cards']['data'] as &$card) {
								$card = $this->fetch($card);
							}
							unset($card);
						}
					}
					break;
					


				/**
				 * 	
				 * 		APPLICATION FEES
				 *  	
				 */	
				case 'retrieveApplicationFee':
					$success = $this->fetch(Stripe\ApplicationFee::retrieve($data['application_fee_id']));
					
					if (!empty($success['refunds'])) {
						foreach ($success['refunds'] as &$refund) {
							$refund = $this->fetch($refund);
						}
					}
						
					break;
				case 'refundApplicationFee':
					$fee = Stripe\ApplicationFee::retrieve($data['application_fee_id']);

					unset($data['application_fee_id']);
					$success = $this->fetch($fee->refund($data));
					
					if (!empty($success['refunds'])) {
						foreach ($success['refunds'] as &$refund) {
							$refund = $this->fetch($refund);
						}
					}

					break;
				case 'listApplicationFees':
					$fees = Stripe\ApplicationFee::all($data['options']);
					$success = $this->fetch($fees);
				
					foreach ($success['data'] as &$fee) {
						$fee = $this->fetch($fee);
					}
					break;


					
				/**
				 * 
				 * 		ACCOUNT
				 *  	
				 */	
				case 'retrieveAccount':
					$success = $this->fetch(Stripe\Account::retrieve());
					break;

					
					
				/**
				 * 
				 * 		BALANCE
				 *  	
				 */	
				case 'retrieveBalance':
					$success = $this->fetch(Stripe\Balance::retrieve());
					break;
				case 'retrieveBalanceTransaction':
					$success = $this->fetch(Stripe\BalanceTransaction::retrieve($data['transaction_id']));
					break;
				case 'listBalanceHistory':
					$history = Stripe\BalanceTransaction::all($data['options']);
					$success = $this->fetch($history);
				
					foreach ($success['data'] as &$transaction) {
						$transaction = $this->fetch($transaction);
					}
					break;

					
					
				/**
				 * 
				 *  	EVENTS
				 *  	
				 */	
				case 'retrieveEvent':
					$event = Stripe\Event::retrieve($data['event_id']);
					$success = $this->fetch($event);
					
					// cards
					if (isset($success['data']['object']['cards']['data']) && !empty($success['data']['object']['cards']['data'])) {
						foreach ($success['data']['object']['cards']['data'] as &$card) {
							$card = $this->fetch($card);
						}
						unset($refund);
					}
					
					break;
				case 'listEvents':
					$events = Stripe\Event::all($data['options']);
					$success = $this->fetch($events);

					foreach ($success['data'] as &$event) {
						$event = $this->fetch($event);
						
						// refunds
						if (isset($event['data']['object']['refunds']) && !empty($event['data']['object']['refunds'])) {
							foreach ($event['data']['object']['refunds'] as &$refund) {
								$refund = $this->fetch($refund);
							}
							unset($refund);
						}
						
						// cards
						if (isset($event['data']['object']['cards']['data']) && !empty($event['data']['object']['cards']['data'])) {
							foreach ($event['data']['object']['cards']['data'] as &$card) {
								$card = $this->fetch($card);
							}
							unset($refund);
						}
						
					}
					break;

					

				/**
				 * 
				 *  	TOKENS
				 *  	
				 */	
				case 'createCardToken':
					$success = $this->fetch(Stripe\Token::create($data));
					break;
				case 'createPersonalIDToken':
					$success = $this->fetch(Stripe\Token::create($data));
					break;
				case 'createBankAccountToken':
					$success = $this->fetch(Stripe\Token::create($data));
					break;
				case 'retrieveToken':
					$success = $this->fetch(Stripe\Token::retrieve($data['token_id']));
					break;
					
				default:
					throw new CakeException($method.' '.__('method not found in StripeComponent'));
					break;
			}
		} catch(Stripe\Error\Card $e) {
			// throw $e;
			$body = $e->getJsonBody();
			$message = $e->getMessage();
			$http_status = $e->getCode();
		} catch (Stripe\Error\RateLimit $e) {
			// Too many requests made to the API too quickly
			// throw $e;
			$body = $e->getJsonBody();
			$message = $e->getMessage();
			$http_status = $e->getCode();
		} catch (Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			// throw $e;
			$body = $e->getJsonBody();
			$message = $e->getMessage();
			$http_status = $e->getCode();
		} catch (Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed (maybe you changed API keys recently)
			// throw $e;
			$body = $e->getJsonBody();
			$message = $e->getMessage();
			$http_status = $e->getCode();
		} catch (Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			// throw $e;
			$body = $e->getJsonBody();
			$message = $e->getMessage();
			$http_status = $e->getCode();
		} catch (Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send yoursel lf an email
			// throw $e;
			$body = $e->getJsonBody();
			$message = $e->getMessage();
			$http_status = $e->getCode();
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			// throw $e;
			$body = $e->getJsonBody();
			$message = $e->getMessage();
			$http_status = $e->getCode();
		}
		
		if ($success) {
			return array(
				'status' => 'success',
				'message' => 'Success',
				'response' => $success	
			);
		}

		$message = sprintf(
		    'There was an error while executing %s. We got a status: %s, with error message: %s', 
		    $method, 
		    $http_status, 
		    $message
		);

		CakeLog::error($message, 'stripe');
		return array(
			'status' => 'error',
			'message' => $message,
			'response' => $body	
		);
	}
		
/**
 * fetch method
 * Converts object to array - checking also one level nested objects
 * 
 * @param object $object
 * @return array
 */	
	private function fetch($object) {
		$objectClass = get_class($object);
		if (!isset($this->reflectionClass[$objectClass])) {
			$this->reflectionClass[$objectClass] = new ReflectionClass($objectClass);
		}

		$array = array();

		foreach ($this->reflectionClass[$objectClass]->getProperties() as $property) {
			$property->setAccessible(true);
			$array[$property->getName()] = $property->getValue($object);
			$property->setAccessible(false);
		}
		
		foreach ($array['_values'] as $k => $value) {
			if (is_object($value)) {
				$array['_values'][$k] = $this->fetch($value);
			}
		}
		
		return $array['_values'];

		# Version 2 - imple
		// return $object->jsonSerialize();
	}	

}