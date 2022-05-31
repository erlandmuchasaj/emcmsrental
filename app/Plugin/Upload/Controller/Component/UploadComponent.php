<?php
/**
 * StripeComponent
 *
 * A component that handles payment processing using Stripe.
 *
 * PHP version 5
 *
 * @package		StripeComponent
 * @author		Gregory Gaskill <gregory@chronon.com>
 * @license		MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link		https://github.com/chronon/CakePHP-StripeComponent-Plugin
 */

App::uses('Component', 'Controller');
/**
 * StripeComponent
 *
 * @package		StripeComponent
 */
class UploadComponent extends Component {

	/**
	** variables for images
	**/
	private $ALLOWED_EXTENTIONS = array('jpg', 'jpeg', 'png');
	private $XSMALL_THUMBNAIL 	= 150;
	private $SMALL_THUMBNAIL  	= 300;
	private $MEDIUM_THUMBNAIL 	= 600;
	private $LARGE_THUMBNAIL 	= 1024;
	private $XLARGE_THUMBNAIL 	= 2048;
	private $FILE_LIMIT    		= 5242880;  // 5*1024*1024 = 5MB;
	private $USE_THUMBNAIL 		= false;
	private $USE_WATERMARK 		= false;
	private $MEMORY_TO_ALLOCATE = '256M';
	private $UPLOAD_FOLDER 		= 'uploads';
	const ERROR_FILE_NOT_EXIST = 1;


	/**
	 * The current controller.
	 *
	 * @var string
	 */
		public $controller = '';

	/**
	 * Initialization to get controller variable
	 *
	 * @param Controller $controller The controller to use.
	 * @param array $settings Array of settings.
	 */
	function initialize(Controller $controller, $settings = array()) { 
		$this->controller =& $controller; 
	}


	public function processMediaUpload(Model $model, $mediacheck = array()) {
		$directory 	  = Configure::read('App.www_root'). 'img' .DS. $this->UPLOAD_FOLDER .DS. $model->name . DS;
		$directoryXSm = Configure::read('App.www_root'). 'img' .DS. $this->UPLOAD_FOLDER .DS. $model->name . DS .'xsmall'.DS;
		$directorySm  = Configure::read('App.www_root'). 'img' .DS. $this->UPLOAD_FOLDER .DS. $model->name . DS .'small' .DS;
		$directoryMd  = Configure::read('App.www_root'). 'img' .DS. $this->UPLOAD_FOLDER .DS. $model->name . DS .'medium'.DS;
		$directoryLg  = Configure::read('App.www_root'). 'img' .DS. $this->UPLOAD_FOLDER .DS. $model->name . DS .'large' .DS;
		$directoryXLg = Configure::read('App.www_root'). 'img' .DS. $this->UPLOAD_FOLDER .DS. $model->name . DS .'xlarge'.DS;

		foreach ($this->options[$model->name]['fields'] as $field => $path) {
			if (!isset($mediacheck[$field]['name']) || empty($mediacheck[$field]['name'])) {
				$model->invalidate($field, __('You must upload a file before you continue!'));  
				return false;
			}
			
			if (!$this->isRealImage($mediacheck[$field]['tmp_name'], $mediacheck[$field]['type']) || !$this->isCorrectImageFileExt($mediacheck[$field]['name'], $this->ALLOWED_EXTENTIONS) || preg_match('/\%00/', $mediacheck[$field]['name'])) {
				$model->invalidate($field, __('Image format not recognized, allowed formats are: .gif, .jpg, .png'));	
				return false;
			}

			$errorMessage = $this->checkUploadError($mediacheck[$field]["error"]);
			if ($errorMessage) {
				$model->invalidate($field, $errorMessage);
				return false;
			}

			$post_max_size = $this->getPostMaxSizeBytes();
			if ($post_max_size && ($this->_getServerVars('CONTENT_LENGTH') > $post_max_size)) {
				$model->invalidate($field, __('The uploaded file exceeds the post_max_size directive in php.ini'));	
				return false;
			}

			if (preg_match('/\%00/', $mediacheck[$field]['name'])) {
				$model->invalidate($field, __('Invalid file name'));	
				return false;
			}

			$allower_ext = $this->ALLOWED_EXTENTIONS;
			$extension = $this->strtolower(pathinfo($mediacheck[$field]['name'], PATHINFO_EXTENSION));	
			if (isset($allower_ext) && !in_array($extension, $allower_ext)) {
				$model->invalidate($field, __('Invalid file format!'));	
				return false;
			}	

			if ($mediacheck[$field]['size'] > intval($this->FILE_LIMIT)) {
				$model->invalidate($field, __('File (size : %s) is biger then the limit! (max : %s)', $mediacheck[$field]['size'],  $this->__humanFileSize($this->FILE_LIMIT)));	
				return false;
			}

			if (file_exists($directory.$mediacheck[$field]['name']) && is_file($directory.$mediacheck[$field]['name'])) { 
				$model->invalidate($field, __('File allredy exists!'));
				return false;
			}

			$this->__makeDirectory($directory);
			if ($this->options[$model->name]['use_thumbnails']==true) {
				$this->__makeDirectory($directorySm);
				$this->__makeDirectory($directoryMd);
				$this->__makeDirectory($directoryLg);
			}
		}
		return true; 
	}	



/**
 * return a generalised lowercase of string
 *
 * @param string $str,
 * @return string
 */
	public static function strtolower($str){
		if (is_array($str)) {
			return false;
		}
		if (function_exists('mb_strtolower')) {
			return mb_strtolower($str, 'utf-8');
		}
		return strtolower($str);
	}

/**
 * return description for an error code
 *
 * @param int $error_code,
 * @return string | int
 */
	protected function checkUploadError($error_code){
		$error = 0;
		switch ($error_code) {
			case 1:
				$error = __('The uploaded file exceeds %s', ini_get('upload_max_filesize'));
				break;
			case 2:
				$error = __('The uploaded file exceeds %s', ini_get('post_max_size'));
				break;
			case 3:
				$error = __('The uploaded file was only partially uploaded');
				break;
			case 4:
				$error = __('No file was uploaded');
				break;
			case 6:
				$error = __('Missing temporary folder');
				break;
			case 7:
				$error = __('Failed to write file to disk');
				break;
			case 8:
				$error = __('A PHP extension stopped the file upload');
				break;
			default:
				//$error = __('There is no error, the file uploaded with success');
				break;
		}
		return $error;
	}

/**
 * Get Maximum size that a file can be posted
 *
 * @return  int
 */
	public function getPostMaxSizeBytes(){
		$post_max_size = ini_get('post_max_size');
		$bytes         = trim($post_max_size);
		$last          = strtolower($post_max_size[strlen($post_max_size) - 1]);

		switch ($last) {
			case 'g': $bytes *= 1024;
			case 'm': $bytes *= 1024;
			case 'k': $bytes *= 1024;
		}

		if ($bytes == '') {
			$bytes = null;
		}
		return $bytes;
	}

/**
 * Get A Server variable
 *
 * @return  int
 */
	protected function _getServerVars($var){
		return (isset($_SERVER[$var]) && !empty($_SERVER[$var]) ? $_SERVER[$var] : '');
	}

/**
 * Get filesize
 *
 * @return int
 */
	protected function _getFileSize($file_path, $clear_stat_cache = false){
		if ($clear_stat_cache) {
			clearstatcache(true, $file_path);
		}
		return filesize($file_path);
	}

/**
 * Normalize the data 
 * Replace Special character from filename 
 * Sanitize filename 
 * @author Erland Muchasaj
 * @param string $filename
 * @return string
 */	
	public function __sanitizeFilename($filename = '') {
		// a combination of various methods
		// we don't want to convert html entities, or do any url encoding
		// we want to retain the "essence" of the original file name, if possible
		// char replace table found at:
		// http://www.php.net/manual/en/function.strtr.php#98669
		$replace = array(
			'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'Ae', 'Å'=>'A', 'Æ'=>'A', 'Ă'=>'A', 'Ą' => 'A', 'ą' => 'a',
			'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'ae', 'å'=>'a', 'ă'=>'a', 'æ'=>'ae',
			'þ'=>'b', 'Þ'=>'B',
			'Ç'=>'C', 'ç'=>'c', 'Ć' => 'C', 'ć' => 'c',
			'Ð'=>'Dj', 
			'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ę' => 'E', 'ę' => 'e',
			'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e',
			'ƒ'=>'f', 
			'Ğ'=>'G', 'ğ'=>'g',
			'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'İ'=>'I', 'ı'=>'i', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i',
			'Ł' => 'L', 'ł' => 'l',
			'Ñ'=>'N', 'Ń' => 'N', 'ń' => 'n',
			'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe', 'Ø'=>'O', 'ö'=>'oe', 'ø'=>'o',
			'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
			'Š'=>'S', 'š'=>'s', 'Ş'=>'S', 'ș'=>'s', 'Ș'=>'S', 'ş'=>'s', 'ß'=>'ss', 'Ś' => 'S', 'ś' => 's',
			'ț'=>'t', 'Ț'=>'T',
			'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'Ue',
			'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'ue', 
			'Ý'=>'Y',
			'ý'=>'y', 'ý'=>'y', 'ÿ'=>'y',
			'Ž'=>'Z', 'ž'=>'z', 'Ż' => 'Z', 'ż' => 'z', 'Ź' => 'Z', 'ź' => 'z'
		);

		$search = array(
			'@<script[^>]*?>.*?</script>@si',   /* strip out javascript */
			'@<[\/\!]*?[^<>]*?>@si',            /* strip out HTML tags */
			'@<style[^>]*?>.*?</style>@siU',    /* strip style tags properly */
			'@<![\s\S]*?--[ \t\n\r]*>@'         /* strip multi-line comments */
		);
				

		$cyr = array('ж', 'ч', 'щ',  'ш', 'ю',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я', 'Ж',  'Ч',  'Щ',   'Ш',  'Ю',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я');

		$lat = array("l", "s", 'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'q', 'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Q');

		$filename = str_replace($cyr, $lat, $filename);
		$filename = strtr($filename, $replace);
		$filename = preg_replace($search, '', $filename);	/* Replace these elements with empty */
	
		// convert & to "and", @ to "at", and # to "number"
		$filename = preg_replace(array('/[\&]/', '/[\@]/', '/[\#]/'), array('-and-', '-at-', '-number-'), $filename);
		$filename = preg_replace('/[^(\x20-\x7F)]*/','', $filename); // removes any special chars we missed
		$filename = str_replace(' ', '-', $filename); // convert space to hyphen 
		$filename = str_replace('\'', '', $filename); // removes apostrophes
		$filename = preg_replace('/[^\w\-\.]+/', '', $filename); // remove non-word chars (leaving hyphens and periods)
		$filename = preg_replace('/[\-]+/', '-', $filename); // converts groups of hyphens into one
		$filename = trim($filename, '-'); // remove hyphen from begining or end of the string

		//return strtolower($filename);
		return mb_strtolower($filename,'UTF-8');
	}


/**
 * Check if file is a real image
 *
 * @param string $filename File path to check
 * @param string $file_mime_type File known mime type (generally from $_FILES)
 * @param array $mime_type_list Allowed MIME types
 * @return bool
 */
	public function isRealImage($filename, $file_mime_type = null, $mime_type_list = null){
		// Detect mime content type
		$mime_type = false;
		if (!$mime_type_list) {
			$mime_type_list = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
		}

		// Try 4 different methods to determine the mime type
		if (function_exists('getimagesize')) {
			$image_info = @getimagesize($filename);

			if ($image_info) {
				$mime_type = $image_info['mime'];
			} else {
				$file_mime_type = false;
			}
		} elseif (function_exists('finfo_open')) {
			$const = defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME;
			$finfo = finfo_open($const);
			$mime_type = finfo_file($finfo, $filename);
			finfo_close($finfo);
		} elseif (function_exists('mime_content_type')) {
			$mime_type = mime_content_type($filename);
		} elseif (function_exists('exec')) {
			$mime_type = trim(exec('file -b --mime-type '.escapeshellarg($filename)));
			if (!$mime_type) {
				$mime_type = trim(exec('file --mime '.escapeshellarg($filename)));
			}
			if (!$mime_type) {
				$mime_type = trim(exec('file -bi '.escapeshellarg($filename)));
			}
		}

		if ($file_mime_type && (empty($mime_type) || $mime_type == 'regular file' || $mime_type == 'text/plain')) {
			$mime_type = $file_mime_type;
		}

		// For each allowed MIME type, we are looking for it inside the current MIME type
		foreach ($mime_type_list as $type) {
			if (strstr($mime_type, $type)) {
				return true;
			}
		}
		return false;
	}

/**
 * Check if image file extension is correct
 *
 * @param string $filename Real filename
 * @param array|null $authorized_extensions
 * @return bool True if it's correct
 */
	public function isCorrectImageFileExt($filename, $authorized_extensions = null){
		// Filter on file extension
		if ($authorized_extensions === null) {
			$authorized_extensions = array('gif', 'jpg', 'jpeg', 'jpe', 'png');
		}
		$name_explode = explode('.', $filename);
		if (count($name_explode) >= 2) {
			$current_extension = strtolower($name_explode[count($name_explode) - 1]);
			if (!in_array($current_extension, $authorized_extensions)) {
				return false;
			}
		} else {
			return false;
		}
		return true;
	}

/**
 * Create Thumbnails
 *
 * @throws NotFoundException
 * @param string $filename, number $width, string $originalDirectory, string $thumbnailDirectory
 * @return Image created 
 */
	public function __createThumbnailUpload($filename, $dst_width, $originalDirectory, $thumbnailDirectory, $compression=7){
		ini_set('memory_limit', $this->MEMORY_TO_ALLOCATE);

		$image = $originalDirectory.$filename;
		$DestFolder = $thumbnailDirectory.$filename;

		if (PHP_VERSION_ID < 50300) {
			clearstatcache();
		} else {
			clearstatcache(true, $image);
		}

		if (!file_exists($image) || !filesize($image)) {
			return '';
		}

		// Evaluate the memory required to resize the image: if it's too much, you can't resize it.
		if (!$this->checkImageMemoryLimit($image)) {
			return false;
		}

		$imageData = getimagesize($image);
		if (!isset($imageData) || empty($imageData) || !is_array($imageData)) {
			return false;
		}

		$tmp_width  = $imageData[0];
		$tmp_height = $imageData[1];
		$type 		= $imageData[2];
		$rotate 	= 0;

		// $x = $imageData[0];
		// $y = $imageData[1];
		// $max_x = $dst_width * 3;

		if (function_exists('exif_read_data') && function_exists('mb_strtolower')) {
			$exif = @exif_read_data($image);

			if ($exif && isset($exif['Orientation'])) {
				switch ($exif['Orientation']) {
					case 3:
						$src_width = $tmp_width;
						$src_height = $tmp_height;
						$rotate = 180;
						break;

					case 6:
						$src_width = $tmp_height;
						$src_height = $tmp_width;
						$rotate = -90;
						break;

					case 8:
						$src_width = $tmp_height;
						$src_height = $tmp_width;
						$rotate = 90;
						break;

					default:
						$src_width = $tmp_width;
						$src_height = $tmp_height;
				}
			} else {
				$src_width = $tmp_width;
				$src_height = $tmp_height;
			}
		} else {
			$src_width = $tmp_width;
			$src_height = $tmp_height;
		}

		// If IMAGE_QUALITY is activated, the generated image will be a PNG with .jpg as a file extension.
		// This allow for higher quality and for transparency. JPG source files will also benefit from a higher quality
		// because JPG reencoding by GD, even with max quality setting, degrades the image.
		$file_type = $this->__imageTypeToExtension($type);

		if (!$src_width) {
			return '';
		}
		if (!$dst_width) {
			$dst_width = $src_width;
		}

		$dst_height = $src_height;

		$SrcImage = $this->create($type, $image);
		if ($rotate) {
			$SrcImage = imagerotate($SrcImage, $rotate, 0);
		}
		// sorce width and height
		$ox = imagesx($SrcImage);
		$oy = imagesy($SrcImage);
		
		// Destination widht and height
		$nx = $dst_width;
		$ny = floor($oy * ($dst_width / $ox));		
		$NewImage = imagecreatetruecolor($nx, $ny);

		// If image is a PNG and the output is PNG, fill with transparency. Else fill with white background.
		if ($file_type == 'png' && $type == IMAGETYPE_PNG ) {

			if ( function_exists('imagealphablending') && function_exists('imagesavealpha') ) {
				imagealphablending($NewImage, false);
				imagesavealpha($NewImage, true);
			}
			$transparent = imagecolorallocatealpha($NewImage, 255, 255, 255, 127);
			imagefilledrectangle($NewImage, 0, 0, $dst_width, $dst_height, $transparent);
		} else {
			$white = imagecolorallocate($NewImage, 255, 255, 255);
			imagefilledrectangle($NewImage, 0, 0, $dst_width, $dst_height, $white);
		}


		if ($dst_width >= $src_width && $dst_height >= $src_height) {
			imagecopyresized($NewImage, $SrcImage, 0, 0, 0, 0, $nx, $ny, $ox, $oy );
		} else {
			$this->imagecopyresampled($NewImage, $SrcImage, 0, 0, 0, 0, $nx, $ny, $ox, $oy);
		}

		$write_file = $this->write($file_type, $NewImage, $DestFolder);

		if(is_resource($NewImage)) { 
			@imagedestroy($NewImage); 
		} 

		if(is_resource($SrcImage)){
			@imagedestroy($SrcImage);
		}
		return $write_file;
	}

/**
 * Create watermark
 *
 * @throws NotFoundException
 * @param string $filename, number $x, number $y, string $imageDirectory
 * @return Image create watermark 
 */
	// $this->__addWatermark($directory, $imagename);
	public function __addWatermark($imageDirectory, $filename, $x = 0, $y = 0){
		$watermark = Configure::read('App.www_root').'img'.DS.'general'.DS.'static'.DS.'watermark.png';
		$sourceImage = $imageDirectory.$filename;
		// $watermark = $this->WATERMARK_IMAGE;
		if(file_exists($watermark) && is_file($watermark)) {
			if(file_exists($sourceImage) && is_file($sourceImage)) {
				
				$image_extension = @end(explode(".", $filename));
				$imageSize = getimagesize($sourceImage);
				if (!isset($imageSize) || empty($imageSize) || !is_array($imageSize)) {
					return false;
				}
				$imgtype = image_type_to_mime_type($imageSize[2]);
				switch($imgtype) {
					case 'image/jpeg':
						$im = imagecreatefromjpeg($sourceImage);
						$img = 'jpeg';
						break;
					case 'image/gif': 
						$im = imagecreatefromgif($sourceImage);
						$img = 'gif';
						$blending = true;  
						break;
					case 'image/png':
						$im = imagecreatefrompng($sourceImage);
						$img = 'png';
						$blending = false; 
						break;
					default:
						$im = false;
				}

				if (!$im) {
					return false;
				}

				if ($img == 'png' || $img == 'gif'){
					// allocate a color for thumbnail
					$background = imagecolorallocate($im, 255, 255, 255);
					// define a color as transparent
					imagecolortransparent($im, $background);
					// set the blending mode for thumbnail
					imagealphablending($im, $blending);
					// set the flag to save alpha channel
					$alfa = !$blending;
					imagesavealpha($im, $alfa);
				}

				// watermark Creation
				$stamp = @imagecreatefrompng($watermark);
				// margin attributes
				$marge_right  = 0;
				$marge_bottom = 0;	
				// watermark dimensions
				$watermark_o_width = imagesx($stamp);
				$watermark_o_height = imagesy($stamp);	
				// watermark position on image
				$dest_x = ($imageSize[0] - $watermark_o_width) / 2 - $marge_right;
				$dest_y = ($imageSize[1] - $watermark_o_height) / 2 - $marge_bottom;
				imagealphablending($stamp, true);
				imagecopy($im, $stamp, $dest_x, $dest_y, 0, 0, $watermark_o_width, $watermark_o_height);

				// WATERMARK CORNER IMAGE
				// $newWidth = $imageSize[0]/4;  
				// $newHeight = $watermark_o_height * $newWidth / $watermark_o_width; 
				// $dest_x = ($imageSize[0] - $newWidth) / 2 - $marge_right;
				// $dest_y = ($imageSize[1] - $newHeight) / 2 - $marge_bottom;
				// imagecopy($im, $stamp, $dest_x, $dest_y, 0, 0, $newWidth, $newHeight);

				switch($image_extension) {
					case "jpg": 
						header('Content-type: image/jpeg');
						imagejpeg($im, $sourceImage, 100);
						break;
					case "jpeg":
						header('Content-type: image/jpeg');
						imagejpeg($im, $sourceImage, 100);
						break;
					case "png":
						header('Content-type: image/png');
						imagepng($im, $sourceImage);
						break;
					case "gif":
						header('Content-type: image/gif');
						imagegif($im, $sourceImage);
						break;
				}
				imagedestroy($im);
				imagedestroy($stamp);
			}
		}
		return true;
	}

/**
 * Get file extention
 *
 * @param string $file,
 * @return string 
 */
	private function __getExt($filename) {
		return mb_strtolower(trim(mb_strrchr($filename, '.'), '.'));
		//return mb_strtolower(pathinfo($filename, PATHINFO_EXTENSION));
	}

/**
 * check if a file is image
 *
 * @param string $path,
 * @return boolean 
 */
	private function __isImage($path = null) {
		if(is_null($path)) {
			return false; 
		}

		if (!isset($path) || empty($path)) {
			return false; 
		}

		if(!file_exists($path) || !is_file($path)) {	
			return false;
		}

		$a = getimagesize($path);
		if (!isset($a) || empty($a) || !is_array($a)) {
			return false;
		}
		$image_type = $a[2];
		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))){
			return true;
		}
		return false;
	}

/**
 * check if a file is image of any type
 *
 * @param string $path,
 * @return boolean 
 */
	private function __imageTypeToExtension($imagetype) {
		if(is_null($imagetype)) {
			return false; 
		}

		if (!isset($imagetype) || empty($imagetype)) {
			return false; 
		}
		switch($imagetype) {
			case IMAGETYPE_GIF      : return 'gif';
			case IMAGETYPE_JPEG     : return 'jpg';
			case IMAGETYPE_PNG      : return 'png';
			case IMAGETYPE_SWF      : return 'swf';
			case IMAGETYPE_PSD      : return 'psd';
			case IMAGETYPE_BMP      : return 'bmp';
			case IMAGETYPE_TIFF_II  : return 'tiff';
			case IMAGETYPE_TIFF_MM  : return 'tiff';
			case IMAGETYPE_JPC      : return 'jpc';
			case IMAGETYPE_JP2      : return 'jp2';
			case IMAGETYPE_JPX      : return 'jpf';
			case IMAGETYPE_JB2      : return 'jb2';
			case IMAGETYPE_SWC      : return 'swc';
			case IMAGETYPE_IFF      : return 'aiff';
			case IMAGETYPE_WBMP     : return 'wbmp';
			case IMAGETYPE_XBM      : return 'xbm';
			default                 : return false;
		}
	}


	/**
	 * Check if memory limit is too long or not
	 *
	 * @param $image
	 * @return bool
	 */
	public function checkImageMemoryLimit($image) {
		$infos = @getimagesize($image);

		if (!is_array($infos) || !isset($infos['bits'])) {
			return true;
		}

		$memory_limit = $this->getMemoryLimit();
		// memory_limit == -1 => unlimited memory
		if (function_exists('memory_get_usage') && (int)$memory_limit != -1) {
			$current_memory = memory_get_usage();
			$channel = isset($infos['channels']) ? ($infos['channels'] / 8) : 1;

			// Evaluate the memory required to resize the image: if it's too much, you can't resize it.
			// For perfs, avoid computing static maths formulas in the code. pow(2, 16) = 65536 ; 1024 * 1024 = 1048576
			if (($infos[0] * $infos[1] * $infos['bits'] * $channel + 65536) * 1.8 + $current_memory > $memory_limit - 1048576) {
				return false;
			}
		}

		return true;
	}


	/**
	 * getMemoryLimit allow to get the memory limit in octet
	 *
	 * @since 1.4.5.0
	 * @return int the memory limit value in octet
	 */
	public function getMemoryLimit(){
		$memory_limit = @ini_get('memory_limit');
		if (preg_match('/[0-9]+k/i', $memory_limit)) {
			return 1024 * (int)$memory_limit;
		}

		if (preg_match('/[0-9]+m/i', $memory_limit)) {
			return 1024 * 1024 * (int)$memory_limit;
		}

		if (preg_match('/[0-9]+g/i', $memory_limit)) {
			return 1024 * 1024 * 1024 * (int)$memory_limit;
		}

		return $memory_limit;
	}


	/**
	 * imagecopyresampled allow to copy an images of a certen
	 * destination folder to another one and resize it and compress.
	 *
	 * @since 1.0.0
	 * @return boolea
	 */
	public function imagecopyresampled(&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3) {
		// Plug-and-Play fastimagecopyresampled function replaces much slower imagecopyresampled.
		// Just include this function and change all "imagecopyresampled" references to "fastimagecopyresampled".
		// Typically from 30 to 60 times faster when reducing high resolution images down to thumbnail size using the default quality setting.
		// Author: Tim Eckel - Date: 09/07/07 - Version: 1.1 - Project: FreeRingers.net - Freely distributable - These comments must remain.
		//
		// Optional "quality" parameter (defaults is 3). Fractional values are allowed, for example 1.5. Must be greater than zero.
		// Between 0 and 1 = Fast, but mosaic results, closer to 0 increases the mosaic effect.
		// 1 = Up to 350 times faster. Poor results, looks very similar to imagecopyresized.
		// 2 = Up to 95 times faster.  Images appear a little sharp, some prefer this over a quality of 3.
		// 3 = Up to 60 times faster.  Will give high quality smooth results very close to imagecopyresampled, just faster.
		// 4 = Up to 25 times faster.  Almost identical to imagecopyresampled for most images.
		// 5 = No speedup. Just uses imagecopyresampled, no advantage over imagecopyresampled.

		if (empty($src_image) || empty($dst_image) || $quality <= 0) { return false; }

		if ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
			$temp = imagecreatetruecolor($dst_w * $quality + 1, $dst_h * $quality + 1);
			imagecopyresized($temp, $src_image, 0, 0, $src_x, $src_y, $dst_w * $quality + 1, $dst_h * $quality + 1, $src_w, $src_h);
			imagecopyresampled($dst_image, $temp, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $dst_w * $quality, $dst_h * $quality);
			imagedestroy($temp);
		} else {
			imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		}
		return true;
	}


	/**
	 * Create an image with GD extension from a given type
	 *
	 * @param string $type
	 * @param string $filename
	 * @return resource
	 */
	public function create($type, $filename) {
		switch ($type) {
			case IMAGETYPE_GIF :
				return imagecreatefromgif($filename);
			break;

			case IMAGETYPE_PNG :
				return imagecreatefrompng($filename);
			break;

			case IMAGETYPE_JPEG :
			default:
				return imagecreatefromjpeg($filename);
			break;
		}
	}

	/**
	 * Create an empty image with white background
	 *
	 * @param int $width
	 * @param int $height
	 * @return resource
	 */
	public function createWhiteImage($width, $height) {
		$image = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($image, 255, 255, 255);
		imagefill($image, 0, 0, $white);
		return $image;
	}

	/**
	 * Generate and write image
	 *
	 * @param string $type
	 * @param resource $resource
	 * @param string $filename
	 * @return bool
	 */
	public function write($type, $resource, $filename){
		static $ps_png_quality = 7;
		static $ps_jpeg_quality = 70;


		switch ($type) {
			case 'gif':
				$success = imagegif($resource, $filename);
			break;

			case 'png':
				$quality = ($ps_png_quality === false ? 7 : $ps_png_quality);
				$success = imagepng($resource, $filename, (int)$quality);
			break;

			case 'jpg':
			case 'jpeg':
			default:
				$quality = ($ps_jpeg_quality === false ? 90 : $ps_jpeg_quality);
				imageinterlace($resource, 1); /// make it PROGRESSIVE
				$success = imagejpeg($resource, $filename, (int)$quality);
			break;
		}
		imagedestroy($resource);
		@chmod($filename, 0777);
		return $success;
	}


/**
 * Return the mime type by the file extension
 *
 * @param string $file_name
 * @return string
 */
	private function getMimeTypeByExtension($file_name) {
		$types = array(
			'image/gif' => array('gif'),
			'image/jpeg' => array('jpg', 'jpeg'),
			'image/png' => array('png')
		);
		$extension = substr($file_name, strrpos($file_name, '.') + 1);

		$mime_type = null;
		foreach ($types as $mime => $exts) {
			if (in_array($extension, $exts)) {
				$mime_type = $mime;
				break;
			}
		}

		if ($mime_type === null) {
			$mime_type = 'image/jpeg';
		}
		return $mime_type;
	}

/**
 * Return Size of a type file 
 *
 * @param int $bytes,
 * @return string 
 */
	private function __humanFileSize($bytes, $decimals = 0) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1000, $factor)) . @$sz[$factor] . 'B';
	}

/**
 * Create Directory
 *
 * @param string $targetdir,
 * @return boolean 
 */
	private function __makeDirectory($targetdir) {
		if(!file_exists($targetdir) || !is_dir($targetdir)) {
			App::uses('Folder', 'Utility');
			$dir = new Folder($targetdir, true, 0777);
			if(!$dir) {
				return false;
			}
		}
		return true;
	}

/**
 * delete a file
 *
 * @param string $filename,
 * @return boolean 
 */
	// $this->__deleteFile$($full_filename);
	private function __deleteFile($filename = null) {
		if(is_null($filename)) {
			return true; 
		}

		if (!isset($filename) || empty($filename) || trim($filename) == '') {
			return true; 
		}

		if(file_exists($filename) && is_file($filename)) {	
			@chmod($filename, 0777); // NT ?
			if(unlink($filename)) {
				return true;
			}
		}
		return true;
	}

	private function deleteAll($directory, $empty = false) {
		if(substr($directory,-1) == "/") {
			$directory = substr($directory,0,-1);
		}
		if(!file_exists($directory) || !is_dir($directory)) {
			return false;
		} elseif(!is_readable($directory)) {
			return false;
		} else {
			$directoryHandle = opendir($directory);
			while ($contents = readdir($directoryHandle)) {
				if($contents != '.' && $contents != '..') {
					$path = $directory . "/" . $contents;
				   
					if(is_dir($path)) {
						deleteAll($path);
					} else {
						unlink($path);
					}
				}
			}
			closedir($directoryHandle);
			if($empty == false) {
				if(!rmdir($directory)) {
					@chmod($directory, 0777); // NT ?
					return false;
				}
			}
			return true;
		}
	}

	// Helper stuff
	private function removeDir($path){
		if (file_exists($path) && is_dir($path)) {
			$dirHandle = opendir($path);
			while (false !== ($file = readdir($dirHandle))) {
				if ($file!='.' && $file!='..') {
					$tmpPath=$path.'/'.$file;
					chmod($tmpPath, 0777);
					if (is_dir($tmpPath)) {
						$this->removeDir($tmpPath);
					} else {
						if (file_exists($tmpPath)) {
							@unlink($tmpPath);
						}
					}
				}
			}
			closedir($dirHandle);
			if (file_exists($path)) {
				@rmdir($path);
			}
		}
	}

	private function copyDir($source, $dest, $overwrite = false){
		if (!is_dir($dest)) {
			mkdir($dest);
		}
		if ($handle = opendir($source)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != '.' && $file != '..') {
					$path = $source . '/' . $file;

					if (is_file($path)) {
						if (!is_file($dest . '/' . $file) || $overwrite) {
							$ext = pathinfo($file, PATHINFO_EXTENSION);
							//if ('php' != $ext) {
								if (!@copy($path, $dest . '/' . $file)) {
								}
							//}
						}
					} elseif (is_dir($path)) {

						if (!is_dir($dest . '/' . $file)) {
							mkdir($dest . '/' . $file);
						}

						$this->copyDir($path, $dest . '/' . $file, $overwrite);
					}
				}
			}
			closedir($handle);
		}
	}

}