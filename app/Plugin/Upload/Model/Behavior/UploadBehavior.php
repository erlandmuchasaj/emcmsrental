<?php
/**
* 2007-2018 EMCMS
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@emcmsrental.erlandmuchasaj.com/ so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade EMCMS Rental to newer
* versions in the future. If you wish to customize EMCMS REntal for your
* needs please refer to http://emcmsrental.erlandmuchasaj.com/ for more information.
*
*  @version    1.0.0
*  @author 	   Erland Muchasaj <erland.muchasaj@gmail.com>
*  @copyright  2007-2018 Copyright (c) ErlandMuchasaj
*  @link       http://erlandmuchasaj.com - Web Developer
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of Erland Muchasaj
*/

class UploadBehavior extends ModelBehavior {

	/**
	* variables for images
	*/
	private $ALLOWED_EXTENTIONS = array('jpg', 'jpeg', 'png');

	private $FILE_LIMIT    		= 5242880;  // 5*1024*1024 = 5MB;
	private $USE_THUMBNAIL 		= false;
	private $USE_WATERMARK 		= false;
	private $MEMORY_TO_ALLOCATE = '256M';
	private $TMP_IMG_DIR		= '/tmp';

	private $directory = null;
	private $directories = [
		'thumb' => null,
		'xsmall' => null,
		'small' => null,
		'medium' => null,
		'large' => null,
		'xlarge' => null
	];

	private $dirSizes = [
		'thumb' => 75,
		'xsmall' => 150,
		'small' => 300,
		'medium' => 600,
		'large' => 1024,
		'xlarge' => 2048
	];

	/*
	* Here we set default value of the model.
	*/
	private $defaultOptions = [
		'fields' => [
			'image_path' => '',
		],
		'use_thumbnails' => false,
		'watermark' => false,
	];

	public function setup(Model $Model, $settings = array()) {
		if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = $this->defaultOptions;
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);

		// main directory
		$this->directory = $this->normalizeDirectory(Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS . $Model->alias . DS);
		$this->__makeDirectory($this->directory);

		// create an array with all directories ready for thumbnails
		if ($this->settings[$Model->alias]['use_thumbnails'] == true) {
			foreach ($this->directories as $type => $dir) {
				$dirPath = $this->directory . $type . DS;
				$this->directories[$type] = $dirPath;
				$this->__makeDirectory($dirPath);
			}
		}
	}

	public function fileExtension(Model $model, $check, $extensions, $allowEmpty = true) {
		$file = current($check);
		if ($allowEmpty && empty($file['tmp_name'])) {
			return true;
		}
		$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		return in_array($extension, $extensions);
	}

	public function fileMaxSize(Model $model, $check, $fileSize, $allowEmpty = true) {
		$file = current($check);
		if ($allowEmpty && empty($file['tmp_name'])) {
			return true;
		}

		return ($file['size'] <= $fileSize);
	}

/*****************************************************
* 		PROCESS MEDIA UPLOAD FOR AVATAR
******************************************************/
	public function processMediaUpload(Model $model, $mediacheck = []) {
		$isValid = true;
		foreach ($this->settings[$model->alias]['fields'] as $field => $path) {

			if (!isset($mediacheck[$field]['name']) || empty($mediacheck[$field]['name'])) {
				$model->invalidate($field, __('You must upload a file before you continue!'));
				$isValid = false;
				continue;
			}

			if (
				!$this->isRealImage($mediacheck[$field]['tmp_name'], $mediacheck[$field]['type']) ||
				!$this->isCorrectImageFileExt($mediacheck[$field]['name'], $this->ALLOWED_EXTENTIONS) ||
				preg_match('/\%00/', $mediacheck[$field]['name'])
			) {
				$model->invalidate($field, __('Image format not recognized, allowed formats are: %s', implode(", ",$this->ALLOWED_EXTENTIONS)));
				$isValid = false;
				continue;
			}

			$errorMessage = $this->checkUploadError($mediacheck[$field]["error"]);
			if ($errorMessage) {
				$model->invalidate($field, $errorMessage);
				$isValid = false;
				continue;
			}

			$post_max_size = $this->getPostMaxSizeBytes();
			$upload_max_filesize = $this->convertBytes(ini_get('upload_max_filesize'));
			$size = $this->getSize();

			if ($size == 0) {
				$model->invalidate($field, __('File is empty.'));
				$isValid = false;
				continue;
			}

			if ($post_max_size && ($size > $post_max_size)) {
				$model->invalidate($field, __('The uploaded file exceeds the post_max_size directive in php.ini'));
				$isValid = false;
				continue;
			}

			if ($upload_max_filesize && ($size > $upload_max_filesize)) {
				$model->invalidate($field, __('The uploaded file exceeds the upload_max_filesize directive in php.ini'));
				$isValid = false;
				continue;
			}

			if (preg_match('/\%00/', $mediacheck[$field]['name'])) {
				$model->invalidate($field, __('Invalid file name'));
				$isValid = false;
				continue;
			}

			$extension = $this->strtolower(pathinfo($mediacheck[$field]['name'], PATHINFO_EXTENSION));
			if (isset($extension) && !in_array($extension, $this->ALLOWED_EXTENTIONS)) {
				$model->invalidate($field, __('Invalid file format!'));
				$isValid = false;
				continue;
			}

			if ($mediacheck[$field]['size'] > intval($this->FILE_LIMIT)) {
				$model->invalidate($field, __('File (size : %s) is biger then the limit! (max : %s)', $mediacheck[$field]['size'],  $this->__humanFileSize($this->FILE_LIMIT)));
				$isValid = false;
				continue;
			}

			if (file_exists($this->directory.$mediacheck[$field]['name']) && is_file($this->directory.$mediacheck[$field]['name'])) {
				$model->invalidate($field, __('File allredy exists!'));
				$isValid = false;
				continue;
			}
		}
		return $isValid;
	}

/*****************************************************
* 		BEFORE SAVE & AFTER SAVE
******************************************************/
	private $oldFile = null;
	public function beforeSave(Model $model, $options = array()) {
		$isValid = true;

		if (empty($this->settings[$model->alias]['fields'])) {
			// no fields to save
			return true;
		}

		foreach ($this->settings[$model->alias]['fields'] as $field => $path) {

			if (!isset($model->data[$model->alias][$field])) {
				continue;
			}

			// lets check that there is a primary key passed
			if ($model->id) {
				// this is a edit, so we delete the old file
				$model->oldFile = $model->field($field);
			}

			$file	   = $model->data[$model->alias][$field];
			$file_name = $this->__sanitizeFilename($file['name']);
			$full_name = time() . "_" . $file_name;
			$mainFile  = $this->directory.$full_name;

			if (isset($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
				if (($tmpName = @tempnam($this->TMP_IMG_DIR, 'EMCMS')) && move_uploaded_file($file['tmp_name'], $mainFile)) {

					if ($this->settings[$model->alias]['use_thumbnails'] === true) {
						// create all thumbnails
						foreach ($this->directories as $type => $dir) {
							$this->__createThumbnailUpload($full_name, $this->dirSizes[$type], $this->directory, $dir);
						}
					}

					if ($this->settings[$model->alias]['watermark'] === true) {
						$this->__addWatermark($this->directory, $full_name);
						// add watermark to thumbnails
						if ($this->settings[$model->alias]['use_thumbnails'] === true) {
							foreach ($this->directories as $type => $dir) {
								$this->__addWatermark($dir, $full_name);
							}
						}
					}

					$model->data[$model->alias][$field] = $full_name;
					$isValid = true;
				} else {
					$model->invalidate($field, __('An error occurred during the image upload!, Please try again.'));
					$isValid = false;
				}

				if (isset($tmpName)) {
					@unlink($tmpName);
				}
			} else {
				/**
				 * Handle file uploads via XMLHttpRequest
				 * Non-multipart uploads (PUT method support)
				 */
				$input = fopen("php://input", "r");
				try {
					file_put_contents($mainFile, $input);
				} catch(Exception $ex) {
					//Process the exception
					$model->invalidate($field, __('File did not Upload succesfully, Please try again!'));
					$isValid = false;
				}
			}

			$file_size = $this->_getFileSize($mainFile, true);
			if (isset($file['size']) && $file_size === $file['size']) {
				$file['save_path'] = $mainFile;
			} else {
				unlink($mainFile);
				$model->invalidate($field, __('Server file size is different from local file size!'));
				$isValid = false;
			}
		}

		return $isValid;
	}

	public function afterSave(Model $model, $created, $options = array()) {

		foreach ($this->settings[$model->alias]['fields'] as $field => $path) {
			if (empty($model->data[$model->alias][$field])) {
				continue;
			}

			if (!empty($model->oldFile)) {
				$this->__deleteFile($this->directory.$model->oldFile);

				if ($this->settings[$model->alias]['use_thumbnails'] == true) {
					foreach ($this->directories as $type => $dir) {
						$this->__deleteFile($dir . $model->oldFile);
					}
				}
			}

		}
	   return true;
	}

/*****************************************************
* 		BEFORE DELETE & AFTER DELETE
******************************************************/
	private  $fileName = null;
	public function beforeDelete(Model $model, $cascade = true) {
		foreach ($this->settings[$model->alias]['fields'] as $field => $path) {
			if (isset($model->id) && !empty($model->id)) {
				$model->fileName = $model->field($field);
			}
			// $model->fileName = $model->field($field);
		}
		return true;
	}

	public function afterDelete(Model $model) {
		foreach ($this->settings[$model->alias]['fields'] as $field => $path) {
			if (empty($model->fileName)) {
				continue;
			}

			$this->__deleteFile($this->directory.$model->fileName);

			if ($this->settings[$model->alias]['use_thumbnails'] == true) {
				foreach ($this->directories as $type => $dir) {
					$this->__deleteFile($dir . $model->fileName);
				}
			}

		}
		return true;
	}

	public function beforeValidate(Model $Model, $options = array()) {
		if (empty($Model->data[$Model->alias]['id'])) {
			return true;
		} else {
			foreach ($this->settings[$Model->alias]['fields'] as $field => $path) {
				if (empty($Model->data[$Model->alias][$field]['name'])) {
					unset($Model->data[$Model->alias][$field]);
				}
			}
			return true; //this is required, otherwise validation will always fail
		}
	}


	/**
	 * return a generalised lowercase of string
	 *
	 * @param string $str,
	 * @return string
	 */
	public function normalizeDirectory($dir) {
		return $dir;
	}

	/**
	 * return a generalised lowercase of string
	 *
	 * @param string $str,
	 * @return string
	 */
	public static function strtolower($str) {
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
	protected function checkUploadError($error_code) {
		$error = 0;
		switch ($error_code) {
			case 1:
				$error = __('The uploaded file exceeds %s', ini_get('upload_max_filesize'));
				break;
			case 2:
				$error = __('The uploaded file exceeds %s the upload limit defined in your form.', ini_get('post_max_size'));
				break;
			case 3:
				$error = __('The uploaded file was only partially uploaded');
				break;
			case 4:
				$error = __('No file was uploaded');
				break;
			case 6:
				$error = __('Missing temporary folder. The file could not be written on disk.');
				break;
			case 7:
				$error = __('File could not be uploaded: missing temporary directory.');
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
	public function getPostMaxSizeBytes() {
		$post_max_size = ini_get('post_max_size');
		$bytes         = (int) trim($post_max_size);
		$last          = $this->strtolower($post_max_size[strlen($post_max_size) - 1]);

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
	 * Convert a shorthand byte value from a PHP configuration directive to an integer value
	 * @param string $value value to convert
	 * @return int
	 */
	public function convertBytes($value) {
		if (is_numeric($value)) {
			return $value;
		} else {
			$value_length = strlen($value);
			$qty = (int)substr($value, 0, $value_length - 1);
			$unit = $this->strtolower(substr($value, $value_length - 1));
			switch ($unit) {
				case 'k':
					$qty *= 1024;
					break;
				case 'm':
					$qty *= 1048576;
					break;
				case 'g':
					$qty *= 1073741824;
					break;
			}
			return $qty;
		}
	}

	/**
	 * Get A Server variable
	 *
	 * @return  int
	 */
	protected function _getServerVars($var) {
		return (isset($_SERVER[$var]) && !empty($_SERVER[$var]) ? $_SERVER[$var] : '');
	}

	/**
	 * Get filesize
	 *
	 * @return int
	 */
	protected function _getFileSize($file_path, $clear_stat_cache = false) {
		if ($clear_stat_cache) {
			clearstatcache(true, $file_path);
		}
		return filesize($file_path);
	}

	protected function getSize() {
		if (isset($_SERVER['CONTENT_LENGTH']) || isset($_SERVER['HTTP_CONTENT_LENGTH'])) {
			if (isset($_SERVER['HTTP_CONTENT_LENGTH'])) {
				return (int)$_SERVER['HTTP_CONTENT_LENGTH'];
			} else {
				return (int)$_SERVER['CONTENT_LENGTH'];
			}
		}
		return false;
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
	public function isRealImage($filename, $file_mime_type = null, $mime_type_list = null) {
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
	public function isCorrectImageFileExt($filename, $authorized_extensions = null) {
		// Filter on file extension
		if ($authorized_extensions === null) {
			$authorized_extensions = array('gif', 'jpg', 'jpeg', 'jpe', 'png');
		}
		$name_explode = explode('.', $filename);
		if (count($name_explode) >= 2) {
			$current_extension = $this->strtolower($name_explode[count($name_explode) - 1]);
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
	public function __createThumbnailUpload($filename, $dst_width, $originalDirectory, $thumbnailDirectory, $compression=7) {
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

		if(is_resource($SrcImage)) {
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
	public function __addWatermark($imageDirectory, $filename, $x = 0, $y = 0) {
		$watermark = Configure::read('App.www_root').'img'.DS.'general'.DS.'static'.DS.'watermark.png';
		$sourceImage = $imageDirectory.$filename;
		// $watermark = $this->getWatermarkLogo();
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

				if ($img == 'png' || $img == 'gif') {
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
		if (is_null($path)) {
			return false;
		}

		if (!isset($path) || empty($path)) {
			return false;
		}

		if (!file_exists($path) || !is_file($path)) {
			return false;
		}

		$a = getimagesize($path);
		if (!isset($a) || empty($a) || !is_array($a)) {
			return false;
		}
		$image_type = $a[2];
		if (in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP))) {
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
		if (is_null($imagetype)) {
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
	public function getMemoryLimit() {
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
	public function write($type, $resource, $filename) {
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
	 * getWatermarkLogo
	 *
	 * @return strin [base64_encode data image]
	 */
	private function getWatermarkLogo() {
		$img_encoded = 'data:image/png;base64,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';

		return $img_encoded;
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
	private function __deleteFile($filename = null) {
		if(is_null($filename)) {
			return true;
		}

		if (!isset($filename) || empty($filename) || trim($filename) == '') {
			return true;
		}

		if (file_exists($filename) && is_file($filename)) {
			@chmod($filename, 0777); // NT ?
			if(unlink($filename)) {
				return true;
			}
		}
		return true;
	}

}
