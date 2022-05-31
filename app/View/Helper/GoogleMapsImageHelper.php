<?php
/**
 * CakePHP GoogleMapsImage Helper
 * CakePHP GoogleMapsImage Helper for Static Maps
 * Requires: CakePHP 1.3, PHP 5.2
 *
 * @package helpers
 * @author Gilles Wittenberg
 * @copyright (c) 2011, Gilles Wittenberg
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link http://code.google.com/apis/maps/documentation/staticmaps/
 *
 * @todo Make CakePHP 2.0 ready
 * @todo Add support for Premium License
 */
class GoogleMapsImageHelper extends AppHelper {
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
  protected $baseUrl = 'http://maps.google.com/maps/api/staticmap';
  /**
   * Featured Parameters
   * URL Parameters available for Google Maps Image API
   * @access protected
   * @var array
   */
  protected $featuredParameters = array(
    'center',
    'zoom',
    'size',
    'scale',
    'format',
    'maptype',
    'language',
    'markers',
    'paths',
    'visible',
    'style',
    'sensor'
  );
  /**
   * Array to hold all parameters
   * Finally a check will be made to see if required parameters are set.
   * Parameter sensor default set to false.
   * @var array
   * @access protected
   */
  protected $parameters = array(
    'sensor' => 'false'
  );
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
  /**
   * Set center
   * @access public
   * @param string / array $center
   * @param string / int $latitude
   * @param string / int $longitude
   * @return string / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#Locations
   */
  public function setCenter($center, $latitude = null, $longitude = null){
    // Address
    if(is_string($center)){
      $center = urlencode($center);
      $this->parameters['center'] = $center;
      return $center;
    }
    // Latitude, Longitude
    else if(is_array($center)){
      if(!empty($center['latitude']) && !empty($center['longitude'])){
        $latitude = $center['latitude'];
        $longitude = $center['longitude'];
      }
      else if(!empty($center[0]) && !empty($center[1])){
        $latitude = $center[0];
        $longitude = $center[1];
      }
      if($latitude && $longitude){
        if(preg_match('/^[0-9]+(\.[0-9]*)?$/', $latitude) && preg_match('/^[0-9]+(\.[0-9]*)?$/', $longitude)){
          $latitude = $this->cleanLatitude($latitude);
          $longitude = $this->cleanLongitude($longitude);
          $center = $latitude.','.$longitude;
          $this->parameters['center'] = $center;
          return $center;
        }
      }
    }
    return false;
  }
  /**
   * Set zoom
   * @access public
   * @param string / int / float
   * @return int
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#Zoomlevels
   */
  public function setZoom($zoom){
    // Calculate and round zoom. Actually Google Maps Image API allows decimals to be supplied, but they are rounded down.
    $zoom = abs(intval($zoom));
    $this->parameters['zoom'] = $zoom;
    return $zoom;
  }
  /**
   * Set size
   * @access public
   * @param string / array
   * @return string / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#Imagesizes
   */
  public function setSize($size, $width = null, $height = null){
    if(is_string($size)){
      if(preg_match('/^[1-9][0-9]*x[1-9][0-9]*$/', $size)){
        preg_match('/^[1-9][0-9]*/', $size, $matches);
        $width = $matches[0];
        preg_match('/[1-9][0-9]*$/', $size, $matches);
        $height = $matches[0];
      }
    }
    else if(is_array($size)){
      if(isset($size['width']) && isset($size['height'])){
        $width = $size['width'];
        $height = $size['height'];
      }
      else if(isset($size[0]) && isset($size[1])){
        $width = $size[0];
        $height = $size[1];
      }
    }
    
    if($width && $height){
      $width = abs(intval($width));
      $height = abs(intval($height));
      if($width > 0 && $height > 0){
        if($width < self::MAX_HEIGHT && $height < self::MAX_HEIGHT){
          $size = $width.'x'.$height;
          $this->parameters['size'] = $size;
          return $size;
        }
      }
    }
    return false;
  }
  /**
   * Set scale
   * @access public
   * @param string / int / float $scale
   * @return int / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#scale_values
   */
  public function setScale($scale){
    // @todo add options for Premium License
    // '/^[124]{1}$/'
    // if($parameters['map']['size'] != 4 || $this->license == 'Premium')
    $scale = abs(intval($scale));
    if(preg_match('/^[12]$/', $scale)){
      $this->parameters['scale'] = $scale;
      return $scale;
    }
    return false;
  }
  /**
   * Set Image Format
   * @access public
   * @param string $format
   * @return string / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#ImageFormats
   */
  public function setFormat($format){
    $format = strtolower($format);
    if(preg_match('/(png8|png|png32|gif|jpg|jpg-baseline)/', $format)){
      $this->parameters['format'] = $format;
      return $format;
    }
    return false;
  }
  /**
   * Set Map Types
   * @access public
   * @param string $maptype
   * @return string / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#MapTypes
   */
  public function setMaptype($maptype){
    $maptype = strtolower($maptype);
    if(preg_match('/(roadmap|satellite|hybrid|terrain)/', $maptype)){
      $this->parameters['maptype'] = $maptype;
      return $maptype;
    }
    return false;
  }
  /**
   * Set language
   * @access public
   * @param string $language
   * @return string / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#URL_Parameters
   * @todo check for allowed languages
   */
  public function setLanguage($language){
    if(is_string($language)){
      $language = strtolower($language);
      if($language){
        $parameters['language'] = $language;
        return $language;
      }
    }
    return false;
  }
  /**
   * Set markerStyles
   * @access public
   * @param array $markerStyles
   * @param int $index
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#MarkerStyles
   */
  public function setMarkerStyles($markerStyles, $index = 0){
    $markerStylesArray = array();
    if(is_array($markerStyles)){
      foreach($markerStyles as $key => $value){
        if($key == 'size'){
          $size = strtolower($value);
          if(preg_match('/(tiny|mid|small)/', $size)){
            $markerStylesArray['size'] = $size;
          }
        }
        else if($key == 'color'){
          $color = strtolower($value);
          if($this->isValidColor($color)){
            $markerStylesArray['color'] = $color;
          }
        }
        else if($key == 'label'){
          $label = strtoupper(substr($value, 0, 1));
          if($label){
            $markerStylesArray['label'] = $label;
          }
        }
      }
    }
    if($markerStylesArray){
      $markerStylesString = '';
      // %7C = urlencode |
      foreach($markerStylesArray as $key => $value){
        $markerStylesString .= $key.':'.$value.'%7C';
      }
      // remove trailing urlencoded pipe (%7C)
      $markerStylesString = preg_replace('/\%7C$/', '', $markerStylesString);
      $this->parameters['markers'][$index]['markerStyles'] = $markerStylesString;
      return $markerStylesString;
    }
    return false;
  }
  /**
   * Set marker
   *
   * @access public
   * @param array $marker
   * @param int $index
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#markers
   * @todo check if icon is valid url
   */
  public function setMarker($marker, $index = 0){
    if(!is_array($marker)){
      return false;
    }
    $markerArray = array();
    // location
    if(!empty($marker['location'])){
      // Address
      if(is_string($marker['location'])){
        $markerArray['location'] = urlencode($marker['location']);
      }
      // Latitude, Longitude
      else if(is_array($marker['location'])){
        if(!empty($marker['location']['latitude']) && !empty($marker['location']['longitude'])){
          $latitude = $marker['location']['latitude'];
          $longitude = $marker['location']['longitude'];
        }
        else if(count($marker['location']) >= 2){
          $latitude = $marker['location'][0];
          $longitude = $marker['location'][1];
        }
        if(isset($latitude) && isset($longitude)){
          if(preg_match('/^[0-9]+(\.[0-9]*)?$/', $latitude) && preg_match('/^[0-9]+(\.[0-9]*)?$/', $longitude)){
            $latitude = $this->cleanLatitude($latitude);
            $longitude = $this->cleanLongitude($longitude);
            $markerArray['location'] = $latitude.','.$longitude;
          }
        }
      }
    }
    // icon
    // @todo check if valid image URL
    if(!empty($marker['icon'])){
      $markerArray['icon'] = urlencode($marker['icon']);
    }
    // set parameter and return
    if(!empty($markerArray['location'])){
      $this->parameters['markers'][$index]['markers'][] = $markerArray;
      return $markerArray;
    }
    return false;
  }
  /**
   * Set markers
   * @access public
   * @param array $markers
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#markers
   */
  public function setMarkers($markers, $index = 0){
    $markersArray = array();
    if(is_array($markers)){
      if(!empty($markers['markerStyles'])){
        if($return = $this->setMarkerStyles($markers['markerStyles'])){
          $markersArray['markerStyles'] = $return;
        }
      }
      if(!empty($markers['markers'])){
        foreach($markers['markers'] as $marker){
          if($return = $this->setMarker($marker, $index)){
            $markersArray['markers'][] = $return;
          }
        }
      }
    }
    if(!empty($markersArray['markers'])){
      return $markersArray;
    }
    return false;
  }
  /**
   * Set pathStyles
   * @access public
   * @param array $pathStyles
   * @param int $index
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#PathStyles
   */
  public function setPathStyles($pathStyles, $index = 0){
    $pathStylesArray = array();
    if(is_array($pathStyles)){
      foreach($pathStyles as $key => $value){
        if($key == 'weight'){
          if(preg_match('/^[0-9]+$/', $value)){
            $pathStylesArray['weight'] = $value;
          }
        }
        else if($key == 'color'){
          $color = strtolower($value);
          if($this->isValidColor($color)){
            $pathStylesArray['color'] = $color;
          }
        }
        else if($key == 'fillcolor'){
          $fillcolor = strtolower($value);
          if($this->isValidColor($fillcolor)){
            $pathStylesArray['fillcolor'] = $fillcolor;
          }
        }
      }
    }
    if($pathStylesArray){
      $pathStylesString = '';
      // %7C = urlencode |
      foreach($pathStylesArray as $key => $value){
        $pathStylesString .= $key.':'.$value.'%7C';
      }
      // remove trailing urlencoded pipe (%7C)
      $pathStylesString = preg_replace('/\%7C$/', '', $pathStylesString);
      $this->parameters['paths'][$index]['pathStyles'] = $pathStylesString;
      return $pathStylesString;
    }
    return false;
  }
  /**
   * Set path
   * @access public
   * @param array $path
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#Paths
   * @todo check if path has at least two points
   * @todo encoded polylines
   */
  public function setPath($path, $index = 0){
    $pathArray = array();
    if(is_array($path)){
      if(!empty($path['points'])){
        foreach($path['points'] as $point){
          // Address
          if(is_string($point)){
            $pathArray['points'][] = urlencode($point);
          }
          // Latitude, Longitude
          else if(is_array($point)){
            if(!empty($point['latitude']) && !empty($point['longitude'])){
              $latitude = $point['latitude'];
              $longitude = $point['longitude'];
            }
            else if(count($point) >= 2){
              $latitude = $point[0];
              $longitude = $point[1];
            }
            if(isset($latitude) && isset($longitude)){
              if(preg_match('/^[0-9]+(\.[0-9]*)?$/', $latitude) && preg_match('/^[0-9]+(\.[0-9]*)?$/', $longitude)){
                $latitude = $this->cleanLatitude($latitude);
                $longitude = $this->cleanLongitude($longitude);
                $pathArray['points'][] = $latitude.','.$longitude;
              }
            }
          }
        }
      }
    }
    if($pathArray){
      $pathString = '';
      foreach($pathArray['points'] as $point){
        $pathString .= $point.'%7C';
      }
      // remove trailing urlencode pipe (%7C)
      $pathString = preg_replace('/%7C$/', '', $pathString);
      $this->parameters['paths'][$index]['paths'][] = $pathString;
      return $pathString;
    }
    return false;
    /**
     * @todo
     * Encoded polylines
     */
  }
  /**
   * Set paths
   *
   * @access public
   * @param array $paths
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#Paths
   */
  public function setPaths($paths, $index = 0){
    $pathsArray = array();
    if(is_array($paths)){
      if(!empty($paths['pathStyles'])){
        if($return = $this->setPathStyles($paths['pathStyles'], $index)){
          $pathsArray['pathStyles'] = $return;
        }
      }
      if(!empty($paths['paths'])){
        foreach($paths['paths'] as $path){
          if($return = $this->setPath($path, $index)){
            $pathsArray['paths'][] = $return;
          }
        }
      }
    }
    if(!empty($pathsArray['paths'])){
      return $pathsArray;
    }
    return false;
  }
  /**
   * Set visible
   * @access public
   * @param array $visible
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#Viewports
   */
  public function setVisible($visible){
    $visibleArray = array();
    if(is_array($visible) && !empty($visible)){
      foreach($visible as $address){
        $visibleArray[] = urlencode($address);
      }
    }
    if($visibleArray){
      $this->parameters['visible'] = $visibleArray;
      return $visibleArray;
    }
    return false;
  }
  /**
   * Set style
   * @access public
   * @param array $style
   * @return array / boolean
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#StyledMaps
   * @todo Check feature
   */
  public function setStyle($style){
    if(is_array($style)){
      $styleArray = '';
      if(!empty($style['feature'])){
        /**
         * @todo check feature against http://code.google.com/apis/maps/documentation/javascript/reference.html#maptypestylefeaturetype
         */
        $styleArray['feature'] = urlencode($style['feature']);
      }
      if(!empty($style['element'])){
        $element = strtolower($style['element']);
        if(preg_match('/(all|geometry|labels)/', $element)){
          $styleArray['element'] = $element;
        }
      }
      if(!empty($style['rules'])){
        foreach($style['rules'] as $key => $value){
          $rule = strtolower($key);
          $value = strtolower($value);
          if($rule == 'hue'){
            if($this->isValidColor($value, false, false)){
              $styleArray['rules'][] = 'hue:'.$value;
            }
          }
          if($rule == 'lightness'){
            if($value < 100 && $value > -100){
              $styleArray['rules'][] = 'lightness:'.$value;
            }
          }
          if($rule == 'saturation'){
            if($value < 100 && $value > -100){
              $styleArray['rules'][] = 'saturation:'.$value;
            }
          }
          if($rule == 'gamma'){
            if($value < 10 && $value > 0.01){
              $styleArray['rules'][] = 'gamma:'.$value;
            }
          }
          if($rule == 'inverse_lightness'){
            if(!$value || $value == 'false'){
              $styleArray['rules'][] = 'inverse_lightness:false';
            }
            else{
              $styleArray['rules'][] = 'inverse_lightness:true';
            }
          }
          if($rule == 'visibility'){
            if(preg_match('/(on|off|simplified)/', $value)){
              $styleArray['rules'][] = 'visibility:'.$value;
            }
          }
        }
      }
      if($styleArray){
        $this->parameters['style'] = $styleArray;
        return $styleArray;
      }
    }
    return false;
  }
  /**
   * Set sensor
   * @access public
   * @param boolean / string $sensor
   * @return string
   * @link http://code.google.com/apis/maps/documentation/staticmaps/#Sensor
   */
  public function setSensor($sensor){
    if($sensor && $sensor !== 'false'){
      $sensor = 'true';
    }
    else{
      $sensor = 'false';
    }
    $this->parameters['sensor'] = $sensor;
    return $sensor;
  }
  /**
   * Set parameters
   * @access public
   * @param array $parameters
   * @return array
   * @todo check if markers and paths has multiple or just one record
   */
  public function setParameters($parameters){
    $returnArray = array();
    foreach($this->featuredParameters as $parameter){
      if(!empty($parameters[$parameter])){
        // create functionname according to parametername
        $func = 'set'.ucwords($parameter);
        // @todo check if markers and paths has multiple or just one record
        if($parameter == 'markers'){
          $markersArray = array();
          $index = 0;
          foreach($parameters['markers'] as $markers){
            if($return = $this->$func($markers, $index)){
              $markersArray[] = $return;
            }
            $index++;
          }
          if($markersArray){
            $returnArray['markers'] = $markersArray;
          }
        }
        else if($parameter == 'paths'){
          $pathsArray = array();
          $index = 0;
          foreach($parameters['paths'] as $paths){
            if($return = $this->$func($paths, $index)){
              $pathsArray[] = $return;
            }
            $index++;
          }
          if($pathsArray){
            $returnArray['paths'] = $pathsArray;
          }
        }
        else{
          if($return = $this->$func($parameters[$parameter])){
            $returnArray[$parameter] = $return;
          }
        }
      }
    }
    return $returnArray;
  }
  /**
   * Return parameter
   * Return paramater if set else return null
   * @access public
   * @param string $key
   * @return string / array / null
   */
  public function getParameter($key){
    if(!empty($this->parameters[$key])){
      return $this->parameters[$key];
    }
    return null;
  }
  /**
   * Return parameters array
   * @access public
   * @return array
   */
  public function getParameters(){
    return $this->parameters;
  }
  /**
   * Reset parameters array
   * @access public
   * @return void
   */
  public function resetParameters(){
    $this->parameters = array(
      'sensor' => 'false'
    );
  }
  /**
   * Check if to be generated image will be valid
   * Some parameters are required. This function checks if these are set.
   * @access public
   * @return boolean
   */
  public function isValidMap(){
    // check if size is set
    if(empty($this->parameters['size'])){
      return false;
    }
    // check if center, markers, paths or visible is set
    if(empty($this->parameters['center']) && empty($this->parameters['markers']) && empty($this->parameters['paths']) && empty($this->parameters['visible'])){
      return false;
    }
    return true;
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
   * Static map
   * Return output url or image
   * @access public
   * @param array $parameters
   * @param array $htmlAttributes
   * @param boolean $createImage
   * @return string
   */
  public function map($parameters = null, $htmlAttributes = null, $createImage = false, $checkIsValid = true, $resetParameters = false){
    // reset parameters
    if($resetParameters){
      $this->resetParameters();
    }
    // set parmaters
    if(is_array($parameters)){
      $this->setParameters($parameters);
    }
    // check if valid paramters and return empty string if not
    if($checkIsValid && !$this->isValidMap()){
      return $this->output('');
    }
    // return map
    else{
      $url = $this->baseUrl.$this->generateParametersString();
      if($checkIsValid && !$this->isValidUrl($url)){
        return $this->output('');
      }
      if($createImage){
        return $this->output($this->Html->image($url, $htmlAttributes));
      } else{
        return $this->output($url);
      }
    }
  }
  /**
   * Generate parameters
   * @access protected
   * @return string
   */
  protected function generateParametersString(){
    $url = '';
    foreach($this->featuredParameters as $parameter){
      if(!empty($this->parameters[$parameter])){
        if($parameter == 'markers'){
          $markersStr = '';
          foreach($this->parameters['markers'] as $markers){
            $str = '&markers=';
            if(!empty($markers['markerStyles'])){
              $str .= $markers['markerStyles'].'%7C';
            }
            foreach($markers['markers'] as $marker){
              if(!empty($marker['location'])){
                $str .= $marker['location'].'%7C';
              }
              if(!empty($marker['icon'])){
                $str .= 'icon:'.$marker['icon'].'%7C';
              }
            }
            // remove trailing urlencode pipe (%7C)
            $str = preg_replace('/%7C$/', '', $str);
            $markersStr .= $str;
          }
          // remove trailing urlencode pipe (%7C)
          $url .= $markersStr;
        }
        else if($parameter == 'paths'){
          foreach($this->parameters['paths'] as $paths){
            $str = '&path=';
            if(!empty($paths['pathStyles'])){
              $str .= $paths['pathStyles'].'%7C';
            }
            foreach($paths['paths'] as $path){
              $str .= $path.'%7C';
            }
            // remove trailing urlencode pipe (%7C)
            $str = preg_replace('/%7C$/', '', $str);
            $url .= $str;
          }
        }
        else if($parameter == 'style'){
          $str = '&style=';
          foreach($this->parameters['style'] as $key => $value){
            if($key == 'feature'){
              $str .= 'feature:'.$value.'%7C';
            }
            if($key == 'element'){
              $str .= 'element:'.$value.'%7C';
            }
            if($key == 'rules'){
              foreach($value as $rule){
                $str .= $rule.'%7C';
              }
            }
          }
          // remove trailing urlencode pipe (%7C)
          $str = preg_replace('/%7C$/', '', $str);
          $url .= $str;
        }
        else{
          $url .= '&'.$parameter.'='.$this->parameters[$parameter];
        }
      }
    }
    $url;
    // replace first ampersand for a questionmark
    $url = '?'.preg_replace('/^&/', '', $url);
    return $url;
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
  /**
   * Is color
   * Checks if color is valid HEX color (0xFED012) or a HTML string color
   * @access protected
   * @param string $color
   * @param boolean $name
   * @param boolean $hex6
   * @param boolean $hex8
   * @return boolean
   */
  protected function isValidColor($color, $name = true, $hex8 = true, $hex6 = true){
    if($name && preg_match('/^(black|brown|green|purple|yellow|blue|gray|orange|red|white)$/', $color)){
      return true;
    }
    if($hex6 && preg_match('/^0x[0-9a-fA-F]{6}$/', $color)){
      return true;
    }
    if($hex8 && preg_match('/^0x[0-9a-fA-F]{8}$/', $color)){
      return true;
    }
    return false;
  }
}