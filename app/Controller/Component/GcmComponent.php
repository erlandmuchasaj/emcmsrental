<?php
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Hash', 'Utility');

/**
* Gcm Exception classes
*/
class GcmException extends CakeException {
}

/**
 * Gcm Component
 *
 */
class GcmComponent extends Component {

	/**
	 * Default options
	 *
	 * @var array
	 */
	protected $_defaults = array(
		'api' => array(
			'key' => '',
			'url' => 'https://gcm-http.googleapis.com/gcm/send'
		),
		'parameters' => array(
			'collapse_key' => null,
			'priority' => 'normal',
			'delay_while_idle' => false,
			'dry_run' => false,
			'time_to_live' => 2419200,
			'restricted_package_name' => null
		),
		'http' => []
	);

	/**
	 * Error code and message.
	 *
	 * @var array
	 */
	protected $_errorMessages = array();

	/**
	 * Response of the request
	 *
	 * @var object
	 */
	protected $_response = null;

	/**
	 * Controller reference
	 */
	protected $Controller = null;

	/**
	 * A Component collection, used to get more components.
	 *
	 * @var ComponentCollection
	 */
	protected $Collection;

	/**
	 * Constructor
	 *
	 * @param ComponentCollection $collection
	 * @param array $settings
	 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->Collection = $collection;
		$this->_defaults = Hash::merge($this->_defaults, $settings);

		$this->_errorMessages = array(
			'400' => __('Error 400. The request could not be parsed as JSON or contained invalid fields.'),
			'401' => __('Error 401. Unable to authenticating the sender account.'),
			'500' => __('Error 500. Internal Server Error.'),
			'503' => __('Error 503. Service Unavailable.')
		);
	}

	/**
	 * Called before the Controller::beforeFilter().
	 *
	 * @param Controller $controller Controller with components to initialize
	 * @return void
	 */
	public function initialize(Controller $controller) {
		$this->Controller = $controller;
	}

	/**
	 * send method
	 *
	 * @param string|array $ids
	 * @param array $payload
	 * @param array $parameters
	 * @return boolean
	 */
	public function send($ids = false, $payload = array(), $parameters = array()) {

		if (is_string($ids)) {
			$ids = (array)$ids;
		}

		if ($ids === false || !is_array($ids) || empty($ids)) {
			throw new GcmException(__("Ids must be a string or an array."));
		}

		if (!is_array($payload)) {
			throw new GcmException(__("Payload must be an array."));
		}

		if (!is_array($parameters)) {
			throw new GcmException(__("Parameters must be an array."));
		}

		if (isset($payload['notification'])) {
			$payload['notification'] = $this->_checkNotification($payload['notification']);
			if (!$payload['notification']) {
				throw new GcmException(__("Unable to check notification."));
			}
		}

		if (isset($payload['data'])) {
			$payload['data'] = $this->_checkData($payload['data']);
			if (!$payload['data']) {
				throw new GcmException(__("Unable to check data."));
			}
		}

		$parameters = $this->_checkParameters($parameters);
		if (!$parameters) {
			throw new GcmException(__("Unable to check parameters."));
		}

		$notification = $this->_buildMessage($ids, $payload, $parameters);
		if ($notification === false) {
			throw new GcmException(__("Unable to build the message."));
		}

		return $this->_executePush($notification);
	}

	/**
	 * sendNotification method
	 *
	 * @param string|array $ids
	 * @param array $notification
	 * @param array $parameters
	 * @return boolean
	 */
	public function sendNotification($ids = false, $notification = array(), $parameters = array()) {
		return $this->send($ids, array('notification' => $notification), $parameters);
	}

	/**
	 * sendData method
	 *
	 * @param string|array $ids
	 * @param array $data
	 * @param array $parameters
	 * @return boolean
	 */
	public function sendData($ids = false, $data = array(), $parameters = array()) {
		return $this->send($ids, array('data' => $data), $parameters);
	}

	/**
	 * response method
	 *
	 * @return string
	 */
	public function response() {
		if (array_key_exists($this->_response->code, $this->_errorMessages)) {
			return $this->_errorMessages[$this->_response->code];
		}

		return json_decode($this->_response->body, true);
	}

	/**
	 * _executePush method
	 *
	 * @param json $notification
	 * @return bool
	 */
	protected function _executePush($notification = false) {
		if ($notification === false) {
			return false;
		}

		if ($this->_defaults['api']['key'] === null) {
			throw new GcmException(__("No API key set. Push not triggered"));
		}

		$httpSocket = new HttpSocket();
		$this->_response = $httpSocket->post($this->_defaults['api']['url'], $notification, array(
			'header' => array(
				'Authorization' => 'key=' . $this->_defaults['api']['key'],
				'Content-Type' => 'application/json'
			)
		));

		if ($this->_response->code === '200') {
			return true;
		}

		return false;
	}

	/**
	 * _buildMessage method
	 *
	 * @param array $ids
	 * @param array $payload
	 * @param array $parameters
	 * @return false|string
	 */
	protected function _buildMessage($ids = false, $payload = false, $parameters = false) {
		if ($ids === false) {
			return false;
		}

		$message = array('registration_ids' => $ids);

		if (!empty($payload)) {
			$message += $payload;
		}

		if (!empty($parameters)) {
			$message += $parameters;
		}

		return json_encode($message);
	}

	/**
	 * _checkNotification method
	 *
	 * @param array $notification
	 * @return array $notification
	 */
	protected function _checkNotification($notification = false) {
		if ($notification === false) {
			return false;
		}

		if (!is_array($notification)) {
			throw new GcmException("Notification must be an array.");
		}

		if (empty($notification) || !isset($notification['title'])) {
			throw new GcmException("Notification's array must contain at least a key title.");
		}

		if (!isset($notification['icon'])) {
			$notification['icon'] = 'myicon';
		}

		return $notification;
	}

	/**
	 * _checkData method
	 *
	 * @param array $data
	 * @return array $data
	 */
	public function _checkData($data = false) {
		if ($data === false) {
			return false;
		}

		if (!is_array($data)) {
			throw new GcmException("Data must ba an array.");
		}

		if (empty($data)) {
			throw new GcmException("Data's array can't be empty.");
		}

		// Convert all data into string
		foreach ($data as $key => $value) {
			$data[$key] = strval($value);
		}

		return $data;
	}

	/**
	 * _checkParameters method
	 *
	 * @param array $parameters
	 * @return array $parameters
	 */
	protected function _checkParameters($parameters = false) {
		if ($parameters === false) {
			return false;
		}

		$parameters = Hash::merge($this->_defaults['parameters'], $parameters);
		$parameters = array_filter($parameters);

		if (isset($parameters['time_to_live']) && !is_int($parameters['time_to_live'])) {
			$parameters['time_to_live'] = (int)$parameters['time_to_live'];
		}

		if (isset($parameters['delay_while_idle']) && !is_bool($parameters['delay_while_idle'])) {
			$parameters['delay_while_idle'] = (bool)$parameters['delay_while_idle'];
		}

		if (isset($parameters['dry_run']) && !is_bool($parameters['dry_run'])) {
			$parameters['dry_run'] = (bool)$parameters['dry_run'];
		}

		return $parameters;
	}
}