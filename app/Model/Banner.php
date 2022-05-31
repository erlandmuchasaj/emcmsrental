<?php
App::uses('AppModel', 'Model');
/**
 * Banner Model
 *
 * @property User $User
 * @property Category $Category
 */
class Banner extends AppModel {


/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Banner';


/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';


/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not modify directly this property',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Banner title can not be empty.',
				'allowEmpty' => false
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'An Banner with the same title alredy exists.',
			),
			'maxLength' => array(
        		'rule' => array('maxLength', 75),
        		'message' => 'Title can not have more then 60 characters.',
        	),
		),
        'description' => array(
        	'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Banner summary can not be empty.',
				'allowEmpty' => false
			),
			'maxLength' => array(
        		'rule' => array('maxLength', 160),
        		'message' => 'Description can not have more then 160 characters.',
        		'allowEmpty' => true
        	),
        ),
        'button_text' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 60),
        		'message' => 'Button text can not have more then 60 characters.',
        		'allowEmpty' => true
        	),
        ),
        'url' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 255),
        		'message' => 'URL can not be more then 255 characters.',
        		'allowEmpty' => true
        	),
        ),
		'image_path' => array(
			'fileExtension' => array(
				'rule' => array('fileExtension', array('png','jpg','jpeg')),
				'message' => 'Please supply a valid image (PNG , JPEG, JPG only).',
				'allowEmpty' => true,
				'required' => false,
			),
			'extension' => array(
				'rule' => array('extension', array('jpeg', 'png', 'jpg')),
				'message' => 'Please supply a valid image.',
				'allowEmpty' => true,
				'required' => false,
			),
			'fileSize' => array(
				'rule' => array('fileSize', '<=', '5MB'),
				'message' => 'Image must be less than 5MB',
				'allowEmpty' => true,
				'required' => false,
			),
			'uploadError' => array(
				'rule' => array('uploadError'),
				'message' => 'Something went wrong with the upload.',
				'allowEmpty' => true,
				'required' => false,
			),
		    'processMediaUpload' => array(
		        'rule' => 'processMediaUpload',
		        'message' => 'Unable to process image upload.',
				'required' => false,
				'allowEmpty' => true,
		    ),
		),
	);

/**
 * ActsAs
 *
 * @var array
 */
	public $actsAs = array(
		'Upload.Upload' => array('fields' => array('image_path'=>''),'use_thumbnails'=>false)
	);

	/**
	 * [getSiteSetting Get site setting for a specific key]
	 * @param  string $key [identification key]
	 * @return Array|json  [Returned data as json type which can late be turned as array]
	 */
		public function getBanners($imit = 5) {
			$banners = $this->find('all', [
				'conditions' => array('status' => 1), 
				'order' => array('sort' => 'asc'),
				'limit' => $imit,
				'recursive' => -1,
			]);

			return $banners;
		}

	// /**
	//  * Converts options back into a php array
	//  *
	//  * @param array $results
	//  * @param boolean $primary
	//  * @return array
	//  **/
	// 	public function afterFind($results, $primary = false) {
	// 		if (!$primary) {
	// 			return parent::afterFind($results, $primary);
	// 		}
	// 		foreach ($results as &$r) {
	// 			if (isset($r[$this->alias]['image_path']) && !empty($r[$this->alias]['image_path'])) {
	// 				$r[$this->alias]['image_path'] = 'uploads/Banner/'. $r[$this->alias]['image_path'];
	// 			}
	// 		}
	// 		return $results;
	// 	}

}
