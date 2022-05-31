<?php
App::uses('AppHelper', 'View/Helper');
/**
 * CakePHP Gravatar Helper
 *
 * A CakePHP View Helper for the display of Gravatar images (http://www.gravatar.com)
 *
 * @copyright Copyright 2016-20117, erland muchasaj (http://erlandmuchasaj.com)
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 * hashtype now always md5
 */

class GravatarHelper extends AppHelper {

	/**
	 * Gravatar avatar image base URL
	 *
	 * @var string
	 */
	protected $_url = [
		'http' => 'http://www.gravatar.com/avatar/',
		'https' => 'https://secure.gravatar.com/avatar/'
	];

	/**
	 * Collection of allowed ratings
	 *
	 * @var array
	 */
	protected $_allowedRatings = ['g', 'pg', 'r', 'x'];

	/**
	 * Default Icon sets
	 *
	 * @var array
	 */
	protected $_defaultIcons = ['none', 'mm', 'identicon', 'monsterid', 'retro', 'wavatar', '404'];

	/**
	 * Default settings
	 *
	 * @var array
	 */
	protected $_defaultConfig = [
		'default' => 'mm',
		'size' => 80,
		'rating' => 'x',
		'ext' => false,
	];

	/**
	 * Helpers used by this helper
	 *
	 * @var array
	 */
	public $helpers = ['Html'];


	/**
	 * Constructor
	 *
	 */
	public function __construct($View = null, $config = []) {
		$config += $this->_defaultConfig;
		// Default the secure option to match the current URL.
		$config['secure'] = env('HTTPS');
		parent::__construct($View, $config);
	}

	/**
	 * Shows gravatar for the supplied email address
	 *
	 * @param string $email Email address
	 * @param array $options Array of options, keyed from default settings
	 * @return string Gravatar image string
	 */
	public function image($email, $options = []) {
		$imageUrl = $this->imageUrl($email, $options);
		unset($options['default'], $options['size'], $options['rating'], $options['ext']);
		if ($this->validateGravatar($email)) {
			return $this->Html->image($imageUrl, $options);
		} else {
			$options['title'] = 'Click here to obtain a gravatar.';
			return $this->Html->link($this->Html->image($imageUrl,$options),'http://www.gravatar.com', array('target'=>'_blank','escape'=>false));
		}
	}



	/**
	 * Generates image URL
	 *
	 * @param string $email Email address
	 * @param string $options Array of options, keyed from default settings
	 * @return string Gravatar Image URL
	 */
	public function imageUrl($email, $options = []) {
		$options = $this->_cleanOptions($options + $this->settings);
		$ext = $options['ext'];
		$secure = $options['secure'];
		unset($options['ext'], $options['secure']);
		$protocol = $secure === true ? 'https' : 'http';

		$imageUrl = $this->_url[$protocol] . md5($email);
		if ($ext === true) {
			// If 'ext' option is supplied and true, append an extension to the generated image URL.
			// This helps systems that don't display images unless they have a specific image extension on the URL.
			$imageUrl .= '.jpg';
		}
		$imageUrl .= $this->_buildOptions($options);
		return $imageUrl;
	}

	/**
	 * Generate an array of default images for preview purposes
	 *
	 * @param array $options Array of options, keyed from default settings
	 * @return array Default images array
	 */
	public function defaultImages($options = []) {
		$options = $this->_cleanOptions($options + $this->settings);
		$images = [];
		foreach ($this->_defaultIcons as $defaultIcon) {
			$options['default'] = $defaultIcon;
			$images[$defaultIcon] = $this->image(null, $options);
		}
		return $images;
	}

	/**
	 * Sanitize the options array
	 *
	 * @param array $options Array of options, keyed from default settings
	 * @return array Clean options array
	 */
	protected function _cleanOptions($options) {
		if (!isset($options['size']) || empty($options['size']) || !is_numeric($options['size'])) {
			unset($options['size']);
		} else {
			$options['size'] = min(max($options['size'], 1), 512);
		}

		if (!$options['rating'] || !in_array(mb_strtolower($options['rating']), $this->_allowedRatings)) {
			unset($options['rating']);
		}

		if (!$options['default']) {
			unset($options['default']);
		} else {
			App::uses('Validation', 'Utility');
			if (!in_array($options['default'], $this->_defaultIcons) && !Validation::url($options['default'])) {
				unset($options['default']);
			}
		}
		return $options;
	}

	/**
	 * Generate email address hash
	 *
	 * @param string $email Email address
	 * @param string $type Hash type to employ
	 * @return string Email address hash
	 */
	protected function _emailHash($email, $type) {
		return md5(mb_strtolower($email), $type);
	}

	/**
	 * Build Options URL string
	 *
	 * @param array $options Array of options, keyed from default settings
	 * @return string URL string of options
	 */
	protected function _buildOptions($options = []) {
		$gravatarOptions = array_intersect(array_keys($options), array_keys($this->_defaultConfig));
		if (!empty($gravatarOptions)) {
			$optionArray = [];
			foreach ($gravatarOptions as $key) {
				$value = $options[$key];
				$optionArray[] = $key . '=' . mb_strtolower($value);
			}
			return '?' . implode('&amp;', $optionArray);
		}
		return '';
	}



	/** 
	 * Returns true if user has an uploaded gravatar, else false.
	 *
	 * A function that checks if user has an uploaded gravatar. If he/she does not then it will return 
	 * false and will tell image() to create an image link that opens the gravatar website on a new page.
	 */
	function validateGravatar($email) {
		$hash = md5(strtolower(trim($email)));
		$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
		$headers = @get_headers($uri);
		if (!preg_match('|200|', $headers[0])) {
			$has_valid_avatar = false;
		} else {
			$has_valid_avatar = true;
		}
		return $has_valid_avatar;
	}
}