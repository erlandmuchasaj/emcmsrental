<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

	// App::import('Vendor', array('file' => 'autoload'));

/**
 * EMCMS Rentals Global settings:
 */
	Configure::load('site_config');

// App::uses('CakeRoute', 'Routing/Route');

// Setup a 'default' cache configuration for use in the application.
	Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); // Loads a single plugin named DebugKit
 */
	CakePlugin::load([
		'DebugKit',
		'CurrencyConverter',
		'SocialShare',
		'Upload',
		'Maintenance',
		'Paypal',
		'Froala',
		// 'Stripe',
		// 'Rest',
	]);

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher',
	'MaintenanceFilter',
));

/**
 * Configures default file logging options
 */
// usage: CakeLog::write('debug', 'message');
//  or : CakeLog::write('debug', print_r($this->_logs, true));
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));


CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

// all 3 below save to the same file info.log
// usage: CakeLog::write('info', 'message');
// usage: CakeLog::write('info', print_r($array, true));
// usage: CakeLog::write('payments', 'message');
// usage: CakeLog::write('reservations', 'message');
CakeLog::config('info', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'error'),
	'scopes' => array('info', 'payments','reservations'),
	'file' => 'info',
));

CakeLog::config('stripe', array(
    'engine' => 'FileLog',
    'types' => array('info', 'error', 'success'),
    'scopes' => array('stripe'),
    'file' => 'stripe',
));

CakeLog::config('paypal', array(
    'engine' => 'FileLog',
    'types' => array('info', 'error', 'success'),
    'scopes' => array('paypal'),
    'file' => 'paypal',
));

CakeLog::config('curl', array(
    'engine' => 'FileLog',
    'types' => array('info', 'error','success'),
    'scopes' => array('curl', 'fsocket', 'streams'),
    'file' => 'curl',
));


// Here we can define function that can be executed Globaly everywhere

/**
 * Check for HTML field validity (no XSS please !)
 *
 * @param string $html HTML field to validate
 * @return bool Validity is ok or not
 */
function isCleanHtml($html, $allow_iframe = false) {
    $events = 'onmousedown|onmousemove|onmmouseup|onmouseover|onmouseout|onload|onunload|onfocus|onblur|onchange';
    $events .= '|onsubmit|ondblclick|onclick|onkeydown|onkeyup|onkeypress|onmouseenter|onmouseleave|onerror|onselect|onreset|onabort|ondragdrop|onresize|onactivate|onafterprint|onmoveend';
    $events .= '|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onmove';
    $events .= '|onbounce|oncellchange|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondeactivate|ondrag|ondragend|ondragenter|onmousewheel';
    $events .= '|ondragleave|ondragover|ondragstart|ondrop|onerrorupdate|onfilterchange|onfinish|onfocusin|onfocusout|onhashchange|onhelp|oninput|onlosecapture|onmessage|onmouseup|onmovestart';
    $events .= '|onoffline|ononline|onpaste|onpropertychange|onreadystatechange|onresizeend|onresizestart|onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onsearch|onselectionchange';
    $events .= '|onselectstart|onstart|onstop';

    if (preg_match('/<[\s]*script/ims', $html) || preg_match('/('.$events.')[\s]*=/ims', $html) || preg_match('/.*script\:/ims', $html)) {
        return false;
    }

    if (!$allow_iframe && preg_match('/<[\s]*(i?frame|form|input|embed|object)/ims', $html)) {
        return false;
    }
    return true;
}

/**
 * Check for boolean validity
 *
 * @param bool $bool Boolean to validate
 * @return bool Validity is ok or not
 */
function isBool($bool) {
    return $bool === null || is_bool($bool) || preg_match('/^(0|1)$/', $bool);
}

/**
 * Check for an integer validity
 *
 * @param int $value Integer to validate
 * @return bool Validity is ok or not
 */
function isInt($value) {
    return ((string)(int)$value === (string)$value || $value === false);
}

/**
 * Price display method validity
 *
 * @param string $data Data to validate
 * @return bool Validity is ok or not
 */
function isString($data) {
    return is_string($data);
}

/**
 * Check for Latitude/Longitude
 *
 * @param string $data Coordinate to validate
 * @return bool Validity is ok or not
 */
function isCoordinate($data) {
    return $data === null || preg_match('/^\-?[0-9]{1,8}\.[0-9]{1,8}$/s', $data);
}

/**
 * Check for empty values
 *
 * @param string $data Coordinate to validate
 * @return bool Validity is ok or not
 */
function isEmpty($field) {
    return ($field === '' || $field === null || trim($field)==='');
}


function EMCMS_stripslashes($string){
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
    return $string;
}

function EMCMS_strtolower($str) {
    if (is_array($str)) {
        return false;
    }
    if (function_exists('mb_strtolower')) {
        return mb_strtolower($str, 'utf-8');
    }
    return strtolower($str);
}

function EMCMS_strtoupper($str) {
    if (is_array($str)) {
        return false;
    }
    if (function_exists('mb_strtoupper')) {
        return mb_strtoupper($str, 'utf-8');
    }
    return strtoupper($str);
}

function EMCMS_strlen($str, $encoding = 'utf-8') {
    if (is_array($str)) {
        return false;
    }
    $str = html_entity_decode($str, ENT_COMPAT, 'utf-8');
    if (function_exists('mb_strlen')) {
        return mb_strlen($str, $encoding);
    }
    return strlen($str);
}

function EMCMS_substr($str, $start, $length = false, $encoding = 'utf-8') {
    if (is_array($str)) {
        return false;
    }
    if (function_exists('mb_substr')) {
        return mb_substr($str, (int)$start, ($length === false ? EMCMS_strlen($str) : (int)$length), $encoding);
    }
    return substr($str, $start, ($length === false ? EMCMS_strlen($str) : (int)$length));
}

function EMCMS_strpos($str, $find, $offset = 0, $encoding = 'utf-8') {
    if (function_exists('mb_strpos')) {
        return mb_strpos($str, $find, $offset, $encoding);
    }
    return strpos($str, $find, $offset);
}

function EMCMS_strrpos($str, $find, $offset = 0, $encoding = 'utf-8') {
    if (function_exists('mb_strrpos')) {
        return mb_strrpos($str, $find, $offset, $encoding);
    }
    return strrpos($str, $find, $offset);
}

function EMCMS_ucfirst($str){
    return EMCMS_strtoupper(EMCMS_substr($str, 0, 1)). EMCMS_substr($str, 1);
}

function EMCMS_ucwords($str){
    if (function_exists('mb_convert_case')) {
        return mb_convert_case($str, MB_CASE_TITLE);
    }
    return ucwords(EMCMS_strtolower($str));
}

/**
 * @param $price
 * @return string
 */
function EMCMS_safeCharEncodePrice($price) {
    /** 
     * $price
     * @var $price - Added hack in for when the variants are being created it passes over the new ISO currency code 
     * which breaks number_format 
     */
    $price = (float) preg_replace("/^([0-9]+\.?[0-9]*)(\s[A-Z]{3})$/", "$1", $price);
    $price = number_format($price, 2, '.', ',');
    return $price;
}

/**
 * @param $format string
 * @param $symbol string
 * @param $price float
 * @return string
 */
function EMCMS_priceHtml($format, $symbol, $price) {
	return sprintf($format, $symbol, EMCMS_safeCharEncodePrice($price));
}

/**
 * Convert \n and \r\n and \r to <br />
 *
 * @param string $string String to transform
 * @return string New string
 */
	function EMCMS_nl2br($str){
		return str_replace(array("\r\n", "\r", "\n"), '<br />', $str);
	}

/**
 * Sanitize data which will be injected into SQL query
 *
 * @param string $string SQL data which will be injected into SQL query
 * @param bool $html_ok Does data contain HTML code ? (optional)
 * @return string Sanitized data
 */
	function EMCMS_escape($string, $html_ok = false, $bq_sql = false) {
	    if (get_magic_quotes_gpc()) {
	        $string = stripslashes($string);
	    }

	    if (!is_numeric($string)) {
	        $string = addslashes($string);

	        if (!$html_ok) {
	            $string = strip_tags(EMCMS_nl2br($string));
	        }

	        if ($bq_sql === true) {
	            $string = str_replace('`', '\`', $string);
	        }
	    }
	    return $string;
	}

/**
 * Function to prepare content before is inserted to DB
 * @deprecated
 * @see EMCMS_escape();
 * @param string $value The text to be validated
 * @return The prepared string text
 */
	function mysqlPrepare($input, $removeAllHtmlTags = false, $bq_sql = false){
		return EMCMS_escape($input, $removeAllHtmlTags, $bq_sql);
	}

/**
 * Allows to display the description with HTML tags
 *
 * @return string
 */
	function getDescriptionHtml($description) {
	    return html_entity_decode(stripslashes($description));
	}

/**
 * Get the GMT time
 */
	if(!function_exists('get_gmt_time')) {
		function get_gmt_time($time = '') {
			if($time == '') {
				$time = time();
			}
			$gmt = local_to_gmt($time);
			return $gmt;
		}
	}

/**
 * Converts a local Unix timestamp to GMT
 *
 * @access	public
 * @param	integer Unix timestamp
 * @return	integer
 */
	if (!function_exists('local_to_gmt')) {
		function local_to_gmt($time = ''){
			if ($time == '') {
				$time = time();
			}
			return mktime(gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
		}
	}

/**
 * @desc identify the version of php
 * @return string
 */
	function checkPhpVersion() {
	    $version = null;

	    if (defined('PHP_VERSION')) {
	        $version = PHP_VERSION;
	    } else {
	        $version  = phpversion('');
	    }

	    //Case management system of ubuntu, php version return 5.2.4-2ubuntu5.2
	    if (strpos($version, '-') !== false) {
	        $version  = substr($version, 0, strpos($version, '-'));
	    }

	    return $version;
	}

/**
 * Get the server variable SERVER_NAME
 *
 * @return string server name
 */
	function getServerName() {
	    if (isset($_SERVER['HTTP_X_FORWARDED_SERVER']) && $_SERVER['HTTP_X_FORWARDED_SERVER']) {
	        return $_SERVER['HTTP_X_FORWARDED_SERVER'];
	    }
	    return $_SERVER['SERVER_NAME'];
	}

/**
 * Get the server variable REMOTE_ADDR, or the first ip of HTTP_X_FORWARDED_FOR (when using proxy)
 *
 * @return string $remote_addr ip of client
 */
	function getRemoteAddr() {
	    if (function_exists('apache_request_headers')) {
	        $headers = apache_request_headers();
	    } else {
	        $headers = $_SERVER;
	    }

	    if (array_key_exists('X-Forwarded-For', $headers)) {
	        $_SERVER['HTTP_X_FORWARDED_FOR'] = $headers['X-Forwarded-For'];
	    }

	    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && (!isset($_SERVER['REMOTE_ADDR'])
	        || preg_match('/^127\..*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^172\.16.*/i', trim($_SERVER['REMOTE_ADDR']))
	        || preg_match('/^192\.168\.*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^10\..*/i', trim($_SERVER['REMOTE_ADDR'])))) {
	        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')) {
	            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	            return $ips[0];
	        } else {
	            return $_SERVER['HTTP_X_FORWARDED_FOR'];
	        }
	    } else {
	        return $_SERVER['REMOTE_ADDR'];
	    }
	}

	function getUserPlatform() {
	    if (isset($_user_plateform)) {
	        return $_user_plateform;
	    }

	    $user_agent = $_SERVER['HTTP_USER_AGENT'];
	    $_user_plateform = 'unknown';

	    if (preg_match('/linux/i', $user_agent)) {
	        $_user_plateform = 'Linux';
	    } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
	        $_user_plateform = 'Mac';
	    } elseif (preg_match('/windows|win32/i', $user_agent)) {
	        $_user_plateform = 'Windows';
	    }
	    return $_user_plateform;
	}

	function getUserBrowser() {
	    if (isset($_user_browser)) {
	        return $_user_browser;
	    }

	    $user_agent = $_SERVER['HTTP_USER_AGENT'];
	    $_user_browser = 'unknown';

	    if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
	        $_user_browser = 'Internet Explorer';
	    } elseif (preg_match('/Firefox/i', $user_agent)) {
	        $_user_browser = 'Mozilla Firefox';
	    } elseif (preg_match('/Chrome/i', $user_agent)) {
	        $_user_browser = 'Google Chrome';
	    } elseif (preg_match('/Safari/i', $user_agent)) {
	        $_user_browser = 'Apple Safari';
	    } elseif (preg_match('/Opera/i', $user_agent)) {
	        $_user_browser = 'Opera';
	    } elseif (preg_match('/Netscape/i', $user_agent)) {
	        $_user_browser = 'Netscape';
	    }
	    return $_user_browser;
	}

/**
 * stripAllHtmlTags
 * @param  [string] $text
 * @return [string] [return a cleaned input removing all html tags and inline scripts]
 */
	function stripAllHtmlTags($text){
		$text = preg_replace(
			array(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
				// some extras to be seen
				'@<[\/\!]*?[^<>]*?>@si',            /* strip out HTML tags */
				'@<![\s\S]*?--[ \t\n\r]*>@',         /* strip multi-line comments */
				// Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', "$0", "$0", "$0", "$0", "$0", "$0", "$0", "$0"),
			$text
		);
		/**
		 * Convert \n and \r\n and \r to <br />
		 */
		$response = str_replace(array("\r\n", "\r", "\n"), '<br />', $text);
		// you can exclude some html tags here, in this case B and A tags
		// return strip_tags($response , '<b><a>');
		return strip_tags($response);
	}

/**
 * Sanitize a string
 *
 * @param string $string String to sanitize
 * @param bool $full String contains HTML or not (optional)
 * @return string Sanitized string
 */
	function safeOutput($string, $html = false) {
	    if (!$html) {
	        $string = strip_tags($string);
	    }
	    return htmlentitiesUTF8($string, ENT_QUOTES);
	}

	function htmlentitiesUTF8($string, $type = ENT_QUOTES) {
	    if (is_array($string)) {
	        return array_map('htmlentitiesUTF8', $string);
	    }

	    return htmlentities((string)$string, $type, 'utf-8');
	}


// // # Load the global event listeners.
// require_once APP . 'Config' . DS . 'events.php';
