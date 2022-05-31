<?php
/**
 * Google Helper to retrive image or url for static maps
 *
 * @copyright     Copyright (c) Erland Muchasaj
 * @link          http://erlandmuchasaj.com - Web Developer
 * @email         erland.muchasaj@gmail.com
 * @usage  		  echo $this->Google->image($lat, $lng, $options);
 */
App::uses('AppHelper', 'View/Helper');
class GoogleHelper extends AppHelper {
	/**
	 * CakePHP Basic Helpers Html, Javascript
	 * @var array
	 * @access public
	 */
	public $helpers = array('Html');

	/**
	 * Static Google Maps base-url
	 * @var string
	 * @access protected
	 */
	protected $baseUrl = 'http://maps.googleapis.com/maps/api/staticmap?';

    /**
     * Static Google Maps key
     * @var string
     * @access protected
     */
    protected $key = '';

	/**
	 * Maximum image width
	 * Maximum image width allowed by Google Maps Image API.
	 * @constant int MAX_WIDTH
	 */
	const MAX_WIDTH = 640;

	/**
	 * Maximum image height
	 * Maximum image height allowed by Google Maps Image API.
	 * @constant int MAX_HEIGHT
	 */
	const MAX_HEIGHT = 640;

	/**
	 * Maximum characters
	 * Maximum number of characters allowed in url
	 * @constant int MAX_CHARACTERS
	 */
	const MAX_CHARACTERS = 2048;


	public function __construct(){
		parent::__construct()
	    $this->key = Configure::read('Google.key');
	}
	

	/**
	 * return an image generated from google static map
	 *
	 * @param  string $lat     [latitude]
	 * @param  string $lng     [longitude]
	 * @param  array  $options [optional parameters]
	 * @return mixed  google map static map
	 */
	public function image($lat, $lng, $options = array()) {
		$defaults = array(
			'size'		=> '480x320', // (required) size of the image to be returned
			'zoom'		=> 15,		// (optional) zoom level of google map
			'format'	=> null,	// (optional) gif, png or png8, png32, jpg,
			'scale'		=> null, 	// (optional) 1, 2
			'maptype'	=> null, 	// (optional) roadmap, satellite, hybrid, and terrain
			'style' 	=> null,
			'key' 		=> $this->key,
			'visual_refresh' => null,
		);

		if(preg_match('/^[0-9]+(\.[0-9]*)?$/', $lat) && preg_match('/^[0-9]+(\.[0-9]*)?$/', $lng)){
			$lat = $this->cleanLatitude($lat);
			$lng = $this->cleanLongitude($lng);
		} else {
			return false;
		}
		/*
		* size: Image size {horizontal_value}x{vertical_value}.
		* zoom: Zoom Level of google maps.
		* url : https://maps.googleapis.com/maps/api/staticmap?markers=41.333326677284134%2C19.81989097752315&size=480x320&zoom=15.
		* call: echo $this->Google->image(45.583296, 13.3593785, array('alt'=>'google Image','zoom'=>'17'));
		*/
		$options = array_merge($defaults, $options);

		if(isset($options['size']) && !empty($options['size'])){
			if (strpos($options['size'],'x') !== false) {
				$size = explode("x",$options['size']);
			} else {
				return $this->output('');
			}

			$width = abs(intval($size[0]));
			$height = abs(intval($size[1]));
			if($width <= 0 || $height <= 0){
				return $this->output('');
			}
			if($width >= self::MAX_WIDTH || $height >= self::MAX_HEIGHT){
				return $this->output('');
			}
			$size = $width.'x'.$height;
		}

		$url = $this->baseUrl;
		$url .= "markers={$lat}%2C{$lng}&size={$options['size']}"; // %2C => ,
		$url.= (isset($options['zoom']) && !empty($options['zoom'])) ? "&zoom=".abs(intval($options['zoom'])) : '';
		$url.= (isset($options['format']) && !empty($options['format'])) ? "&format={$options['format']}" : '';
		$url.= (isset($options['scale']) && !empty($options['scale'])) ? "&scale={$options['scale']}" : '';
		$url.= (isset($options['maptype']) && !empty($options['maptype'])) ? "&maptype={$options['maptype']}" : '';
		$url.= (isset($options['style']) && !empty($options['style'])) ? "&style={$options['style']}" : '';
		$url.= (isset($options['key']) && !empty($options['key'])) ? "&key={$options['key']}" : '';
		$url.= (isset($options['visual_refresh']) && !empty($options['visual_refresh'])) ? "&visual_refresh={$options['visual_refresh']}" : '';

		// remove google map data from array then pass to img as argument
		foreach ($defaults as $key => $value) {
			unset($options[$key]);
		}

		if(!$this->isValidUrl($url)){
			return $this->output('');
		} else {
			return $this->output($this->Html->image($url, $options));
		}
	}

	/**
	 * Returns url of the google static map.
	 */
	public function imageUrl($lat, $lng, $options = array()) {
		$defaults = array(
			'size' 		=> '480x320',// (required) size of the image to be returned
			'zoom'		=> 15,	 	// (optional) zoom level of google map
			'format'	=> null,	// (optional) gif, png or png8, png32, jpg,
			'scale' 	=> null,	// (optional) 1, 2
			'maptype' 	=> null,	// (optional) roadmap, satellite, hybrid, and terrain
			'style' 	=> null,
			'key' 		=> $this->key, // (optional) roadmap, satellite, hybrid, and terrain
			'visual_refresh' => null,// (optional) true, false
		);
		if(preg_match('/^[0-9]+(\.[0-9]*)?$/', $lat) && preg_match('/^[0-9]+(\.[0-9]*)?$/', $lng)){
			$lat = $this->cleanLatitude($lat);
			$lng = $this->cleanLongitude($lng);
		} else {
			return false;
		}
		/*
		* url : https://maps.googleapis.com/maps/api/staticmap?markers=41.333326677284134%2C19.81989097752315&size=480x320&zoom=15.
		* call: echo $this->Google->imageUrl(45.583296, 13.3593785, array('zoom'=>'17'));
		*/
		$options = array_merge($defaults, $options);

		if(isset($options['size']) && !empty($options['size'])){
			if (strpos($options['size'],'x') !== false) {
				$size = explode("x",$options['size']);
			} else {
				return $this->output('');
			}

			$width = abs(intval($size[0]));
			$height = abs(intval($size[1]));
			if($width <= 0 || $height <= 0){
				return $this->output('');
			}
			if($width >= self::MAX_WIDTH || $height >= self::MAX_HEIGHT){
				return $this->output('');
			}
			$size = $width.'x'.$height;
		}

		$url = $this->baseUrl;
		$url .= "markers={$lat}%2C{$lng}&size={$size}"; // %2C => ,
		$url.= (isset($options['zoom']) && !empty($options['zoom'])) ? "&zoom=".abs(intval($options['zoom']))  : '';
		$url.= (isset($options['format']) && !empty($options['format'])) ? "&format={$options['format']}" : '';
		$url.= (isset($options['scale']) && !empty($options['scale'])) ? "&scale={$options['scale']}" : '';
		$url.= (isset($options['maptype']) && !empty($options['maptype'])) ? "&maptype={$options['maptype']}" : '';
		$url.= (isset($options['style']) && !empty($options['style'])) ? "&style={$options['style']}" : '';
		$url.= (isset($options['key']) && !empty($options['key'])) ? "&key={$options['key']}" : '';
		$url.= (isset($options['visual_refresh']) && !empty($options['visual_refresh'])) ? "&visual_refresh={$options['visual_refresh']}" : '';

		if(!$this->isValidUrl($url)){
			return $this->output('');
		} else {
			return $this->output($url);
		}
	}

	/**
	 * Check if string does not exceed max number of characters
	 * @access protected
	 * @param string $url
	 * @return boolean
	 */
	protected function isValidUrl($url){
		if(strlen($url) <= self::MAX_CHARACTERS){
			return true;
		}
		return false;
	}

	/**
	 * Clean latitude
	 * Returns latitude as allowed by Google Maps Image API
	 * Value between -90 and 90 width max. 6 digits precision
	 * @access protected
	 * @param float $latitude
	 * @return float
	 */
	protected function cleanLatitude($latitude){
		$latitude = round($latitude, 6);
		// set limits of 90 - -90 for latitude
		$latitude = $latitude > 90 ? 90 : $latitude;
		$latitude = $latitude < -90 ? -90 : $latitude;
		return $latitude;
	}

	/**
	 * Clean longitude
	 * Returns longitude as allowed by Google Maps Image API
	 * Value between -180 and 180 with max. 6 digits precision
	 * @access protected
	 * @param float $longitude
	 * @return float
	 */
	protected function cleanLongitude($longitude){
		$longitude = round($longitude, 6);
		$longitude = fmod($longitude, 180);
		return $longitude;
	}
}