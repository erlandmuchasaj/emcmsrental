<?php
App::uses('Component', 'Controller', 'Session');
App::uses('CakeTime', 'Utility');
class CurrencyConverterComponent extends Component {

	public $components = array('Session');

	/**
	 * Using database
	 *
	 * @var bool
	 */
	private $database;

	/**
	 * Time interval for refreshing database
	 *
	 * @var int
	 */
	private $refresh;

	/**
	 * Number of decimal to use for formatting converted price
	 *
	 * @var int
	 */
	private $decimal;

	/**
	 * Number to divise 1 and get the sup step to round price to
	 *
	 * @var float
	 */
	private $round;

	/**
	 * The current controller.
	 *
	 * @var string
	 */
	public $controller = '';

	/**
	 * Default CurrencyConverterComponent settings.
	 *
	 * When calling CurrencyConverterComponent() these settings will be merged with the configuration
	 * you provide.
	 *
	 * - `database` - Mention if Component have to store currency rate in database
	 * - `refresh` - Time interval for Component to refresh currency rate in database
	 * - `decimal` - Number of decimal to use when formatting amount float number
	 * - `round` - Number to divise 1 and get the sup step to round price to (eg: 4 for 0.25 step)
	 *
	 * @var array
	 */
	protected $_defaultConfig = [
	    'database' => true, // Mention if Component have to store currency rate in database
	    'refresh' => 24, // Time interval for Component to refresh currency rate in database
	    'decimal' => 2, // Number of decimal to use when formatting amount float number
	    'round' => false, // Number to divise 1 and get the sup step to round price to (eg: 4 for 0.25 step)
	];

	/**
	 * Initialization to get controller variable
	 *
	 * @param Controller $controller The controller to use.
	 * @param array $settings Array of settings.
	 */
	function initialize(Controller $controller, $settings = array()) {
		$this->controller =& $controller;
	}

	/**
	 * Convertion function
	 *
	 * @param string $fromCurrency the starting currency that user wants to convert to.
	 * @param string $toCurrency the ending currency that user wants to convert to.
	 * @param float $amount the amount to convert.
	 * @param boolean $saveIntoDb if develop wants to store convertion rate for use it without resending data to yahoo service.
	 * @param int $hourDifference the hour difference to check if the last convertion is passed, if yes make a new call to yahoo finance api.
	 * @param string $dataSource which dataSOurce need to use
	 * @return float the total amount converted into the new currency
	 */
	public function convertV2($fromCurrency, $toCurrency, $amount, $saveIntoDb = 1, $hourDifference = 1, $dataSource = 'default') {
		
		$rate = 1;
		$amount = floatval($amount);

		if ($fromCurrency !== $toCurrency) {

			if ($fromCurrency === 'PDS') {
				$fromCurrency = 'GBP';
			}

			if ($saveIntoDb == 1) {
				$this->_checkIfExistTable($dataSource);


				$arrReturn = $this->checkToFind($fromCurrency, $toCurrency, $hourDifference);
				if (isset($arrReturn['find'])) {
					$find = $arrReturn['find'];
				}

				if (isset($arrReturn['rate'])) {
					$rate = $arrReturn['rate'];
				}

				if ($find == 0) {
					$rate = $this->_getRateFromAPI($fromCurrency, $toCurrency);
					$CurrencyConverter = ClassRegistry::init('CurrencyConverter');
					$CurrencyConverter->create();
					$CurrencyConverter->set(array(
						'from'         => $fromCurrency,
						'to'           => $toCurrency,
						'rates'        => $rate,
						'created'      => date('Y-m-d H:i:s'),
						'modified'     => date('Y-m-d H:i:s'),
					));
					$CurrencyConverter->save();
				}

				$value = (double)$rate * (double)$amount;
				return number_format((double)$value, 2, '.', '');
			} else {

				$rate = $this->_getRateFromAPI($fromCurrency, $toCurrency);
				
				$value = (double)$rate * (double)$amount;
				return number_format((double)$value, 2, '.', '');
			}
		} else {
			return number_format((double)$amount, 2, '.', '');
		}
	}

	public function convert($from, $to, $amount, $saveIntoDb = 1, $hourDifference = 1, $dataSource = 'default')
	{
	    $amount = floatval($amount);
	    $rate = $this->_getRateToUse($from, $to, $saveIntoDb, $hourDifference, $dataSource);
	    $value = (double)$rate * (double)$amount;
	    return $this->_formatConvert($value);
	}

	/**
	 * Convertion function call to yahoo finance api
	 *
	 * @param string $fromCurrency the starting currency that user wants to convert to.
	 * @param string $toCurrency the ending currency that user wants to convert to.
	 * @param int $hourDifference the hour difference to check if the last convertion is passed, if yes make a new call to yahoo finance api.
	 * @return int if it's finded value
	 */
	public function checkToFind($fromCurrency, $toCurrency, $hourDifference) {
		$arrReturn = array();
		$find = 0;
		$rate = 0;

		$CurrencyConverter = ClassRegistry::init('CurrencyConverter');

		$result = $CurrencyConverter->find('first', [
			'conditions' => [
				'from' => $fromCurrency,
				'to' => $toCurrency
			],
			'recursive' => -1,
			'callbacks' => false,
		]);


		if ($result) {
			$find = 1;
			$lastUpdated = $result['CurrencyConverter']['modified'];
			$now = date('Y-m-d H:i:s');
			$dStart = new DateTime($now);
			$dEnd = new DateTime($lastUpdated);
			$diff = $dStart->diff($dEnd);

			if(((int)$diff->y >= 1) || ((int)$diff->m >= 1) || ((int)$diff->d >= 1) || ((int)$diff->h >= $hourDifference) || ((double)$result['CurrencyConverter']['rates'] == 0)){
				$rate = $this->_getRateFromAPI($fromCurrency, $toCurrency);

				$CurrencyConverter->id = $result['CurrencyConverter']['id'];
				$CurrencyConverter->set([
					'from'        => $fromCurrency,
					'to'          => $toCurrency,
					'rates'       => $rate,
					'modified'    => date('Y-m-d H:i:s'),
				]);
				$CurrencyConverter->save();
			} else {
				$rate = $result['CurrencyConverter']['rates'];
			}
		}

		$arrReturn['find'] = $find;
		$arrReturn['rate'] = $rate;

		return($arrReturn);
	}

	/**
	 * Convertion function call to yahoo finance api
	 *
	 * @param string $dataSource which dataSOurce need to use
	 * @return boolean if the table standard currency_converters exist into the database
	 */
	private function _checkIfExistTable($dataSource){
		$find = 0;

		App::uses('ConnectionManager', 'Model');
		$db = ConnectionManager::getDataSource($dataSource);
		$tables = $db->listSources();
		$config = $db->config;

		foreach($tables as $t){
			if ($t == $config['prefix'].'currency_converters'){
				$find = 1;
				break;
			}
		}

		if ($find == 0) {
			$sql = 'CREATE TABLE IF NOT EXISTS `currency_converters` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`from` char(3) NOT NULL,
				`to` char(3) NOT NULL,
				`rates` varchar(10) NOT NULL,
				`created` datetime NOT NULL,
				`modified` datetime NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

			$results = $db->query($sql);
			return $results;
		} else {
			return true;
		}
	}

	/**
	 * Call free.currencyconverterapi.com API to get a rate for one currency to an other one currency.
	 *
	 * @param string $from the currency.
	 * @param string $to the currency.
	 * @return int|null $rate.
	 *
	 * @example http://openexchangerates.org/api/latest.json?base={$from}&symbols={$to}&app_id=8d43d9c41911416bb8d838e179812889"; [here we can use only with payment]
	 */
	private function _getRateFromAPI($from, $to)
	{
	    $rate = null;

	    $url = "https://free.currconv.com/api/v7/convert?q={$from}_{$to}&compact=ultra&apiKey=25f55a0a2194204da116";
	    $request = @fopen($url, 'r');

        if ($request) {

        	$response = ''; 
        	while (!feof($request)) {
        		$response .= fread($request, 4096); 
        	} 
        	fclose($request);

        	$response = json_decode($response, true);
        	if (isset($response[$from . '_' . $to])) {
        	    $rate = (double) $response[$from . '_' . $to];
        	}

        } else {
		    $url = "https://api.exchangeratesapi.io/latest?base={$from}&symbols={$to}";
        	$request = @fopen($url, 'r');

		    if ($request) {

		        $response = ''; 
	        	while (!feof($request)) {
	        		$response .= fread($request, 4096); 
	        	} 
	        	fclose($request); 

	    	    $response = json_decode($response, true);
	    	    if (isset($response['rates'][$to])) {
	    	        $rate = (double) $response['rates'][$to];
	    	    }
		    }
	    }

	    return $rate;
	}

	// ========================================================

	/**
	 * Check session to see if rate exists in.
	 *
	 * @param  string $from currency to get the rate from.
	 * @param  string $to currency to get the rate to.
	 * @return float|null $rate.
	 */
	private function _getRateFromSession($from, $to, $hourDifference = 1)
	{
	    $session = $this->Session->read('CurrencyConverter.' . $from . '-' . $to);
	    if ($session) {
	        if (CakeTime::wasWithinLast($hourDifference . ' hours', $session['modified'])) {
	            return $session['rate'];
	        }
	    }
	    return null;
	}

	/**
	 * Store in session a rate and his modified datetime
	 *
	 * @param  \Cake\ORM\Entity $entity
	 * @return void
	 */
	private function _storeRateInSession($entity)
	{
	    $this->Session->write('CurrencyConverter.' . $entity['CurrencyConverter']['from']. '-' . $entity['CurrencyConverter']['to'], [
	        'rate' => $entity['CurrencyConverter']['rates'],
	        'modified' => $entity['CurrencyConverter']['modified']
	    ]);
	}

	/**
	 * getRateToUse return rate to use
	 * Using $from and $to parameters representing currency to deal with and the configuration settings
	 * This method save or update currencyrates Table if necesseray too.
	 *
	 * @param string $from currency to get the rate from
	 * @param string $to currency to get the rate to
	 * @return float|null $rate
	 */
	private function _getRateToUse($from, $to, $saveIntoDb = 1, $hourDifference = 1, $dataSource = 'default')
	{
	    $rate = 1;

	    if ($from !== $to) {

	    	if ($from === 'PDS') {
	    		$from = 'GBP';
	    	}

	        if ($saveIntoDb == 1) {
	        	$this->_checkIfExistTable($dataSource);

	            $rate = $this->_getRateFromSession($from, $to, $hourDifference);
	            if (!$rate) {
	                $rate = $this->_getRateFromDatabase($from, $to, $hourDifference);
	            }
	        } else {
	            $rate = $this->_getRateFromAPI($from, $to);
	        }
	    }
	    return $rate;
	}

	/**
	 * Get a rate from database.
	 *
	 * It queries currencyratesTable and ...
	 * if rate exists and has not to be modified, it returns this rate.
	 * if rate exists and has to be modified, it call _getRateFromAPI method to get a fresh rate, then update in table and store in session this rate.
	 * if rate does not exist, it call _getRateFromAPI to get a fresh rate, then create in table and store this rate.
	 *
	 * @param  string $from currency to get the rate from
	 * @param  string $to currency to get the rate to
	 * @return float|null $rate
	 */
	private function _getRateFromDatabase($from, $to, $hourDifference = 1)
	{
		$rate = 1;
	    $CurrencyConverter = ClassRegistry::init('CurrencyConverter');
	    $result = $CurrencyConverter->find('first', [
	    	'conditions' => [
	    		'from' => $from,
	    		'to' => $to
	    	],
	    	'recursive' => -1,
	    	'callbacks' => false,
	    ]);

	    if ($result) {
	    	$modified = $result['CurrencyConverter']['modified'];
	        if (CakeTime::wasWithinLast($hourDifference . ' hours', $modified)) {
	            $rate = $result['CurrencyConverter']['rates'];
	            $this->_storeRateInSession($result);
	        } else {
	            $rate = $this->_getRateFromAPI($from, $to);
	            if ($rate) {
	                $result['CurrencyConverter']['rates'] = $rate;
	                $CurrencyConverter->save($result);
	                $this->_storeRateInSession($result);
	            }
	        }
	    } else {
	        $rate = $this->_getRateFromAPI($from, $to);
	        if ($rate) {
	        	$CurrencyConverter->create();
	        	$CurrencyConverter->set([
	        		'from'     => $from,
	        		'to'       => $to,
	        		'rates'    => $rate,
	        		'created'  => date('Y-m-d H:i:s'),
	        		'modified' => date('Y-m-d H:i:s'),
	        	]);
	        	$CurrencyConverter->save();

	            $result = $CurrencyConverter->read();
	            $this->_storeRateInSession($result);
	        }
	    }
	    return $rate;
	}

	/**
	 * Format number using configuration
	 *
	 * @param float number to format
	 * @return string formatted number
	 */
	private function _formatConvert($number, $round = false)
	{
	    if ($round) {
	        $n = floor($number);
	        $fraction = ($number - $n);
	        if ($fraction != 0) {
	            $step = 1 / $round;
	            $decimal = (((int)($fraction / $step) + 1) * $step);
	            $number = $n + $decimal;
	        }
	    }

	    return number_format((double)$number, 2, '.', '');
	}

}
