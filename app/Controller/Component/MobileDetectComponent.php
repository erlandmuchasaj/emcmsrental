<?php
/**
 * MobileDetectComponent
 *
 * A component for identifying mobile devices using the Mobile_Detect project.
 * https://github.com/serbanghita/Mobile-Detect
 *
 * PHP version 5
 *
 * @package		MobileDetectComponent
 * @author		Gregory Gaskill <gregory@chronon.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link		https://github.com/chronon/CakePHP-MobileDetectComponent-Plugin
 */

App::uses('Component', 'Controller');

/**
 * MobileDetectComponent
 *
 * @package		MobileDetectComponent
 */
class MobileDetectComponent extends Component {

/**
 * The state of the Mobile_Detect class
 *
 * @var bool
 * @access public
 */
	public $loaded = false;

/**
 * The MobileDetect object
 *
 * @var object
 * @access public
 */
	public $MobileDetect = null;

/**
 * Loads the Mobile_Detect class, runs the given Mobile_Detect method. Uses
 * 'isMobile' if no method given.
 *
 * @param string $method The method to run
 * @param string $args Optional arguments to the given method
 * @return mixed
 * @throws CakeException
 */
	public function detect($method = 'isMobile', $args = null) {
		if (!class_exists('Mobile_Detect')) {
			// load the vendor class if it hasn't allready been autoloaded.
			$loaded = App::import('Vendor', 'MobileDetect/Mobile_Detect');
			// abort if vendor class wasn't autoloaded and can't be found.
			if (!$loaded) {
				throw new CakeException('Mobile_Detect is missing or could not be loaded.');
			}
		}
		// instantiate once per method call
		if (!($this->MobileDetect instanceof Mobile_Detect)) {
			$this->MobileDetect = new Mobile_Detect();
		}

		return $this->MobileDetect->{$method}($args);
	}
	/**
	 * How to call the function on AppController
	 */
	// $test1 = $this->MobileDetect->detect('isMobile');
	// $test2 = $this->MobileDetect->detect('isTablet');
	// $test3 = $this->MobileDetect->detect('getProperties');
	// $test4 = $this->MobileDetect->detect('isWhateverYouWant');
	// $test5 = $this->MobileDetect->detect('getScriptVersion');
	// $test6 = $this->MobileDetect->detect('getRules');
	// $test7 = $this->MobileDetect->detect('getMatchingRegex');
	// $test8 = $this->MobileDetect->detect('getMatchesArray');

}