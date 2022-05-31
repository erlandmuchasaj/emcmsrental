<?php
App::uses('AppModel', 'Model');
/**
 * Article Model
 *
 * @property User $User
 * @property Category $Category
 */
class Article extends AppModel {


/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Article';


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
				'message' => 'Article title can not be empty.',
				'allowEmpty' => false
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'An article with the same title alredy exists.',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'article title can not have more then 160 characters.',
			),
		),
		'slug' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'Slug can not have more then 160 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Slug should be unique',
				'allowEmpty' => true,
				'required' => false,
			),
        ),
        'summary' => array(
        	'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Article summary can not be empty.',
				'allowEmpty' => false
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'summary can not have more then 255 characters. charcters include even the formating parts such as <p>, <span> etc.',
			),
        ),
        'featured_image' => array(
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
        'meta_title' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 60),
        		'message' => 'Meta title can not have more then 60 characters.',
        		'allowEmpty' => true
        	),
        ),
        'meta_description' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 160),
        		'message' => 'Meta description can not have more then 160 characters.',
        		'allowEmpty' => true
        	),
        )
	);

/**
 * ActsAs
 *
 * @var array
 */
	public $actsAs = array(
		'Upload.Upload' => array('fields' => array('featured_image'=>''),'use_thumbnails'=>true)
	);

//The Associations below have been created with all possible keys, those that are not needed can be removed
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => array(
				'Category.model' => 'Article',
			),
			'fields' => '',
			'order' => ''
		),
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Image' => array(
			'className' => 'Image',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => '',
			'conditions' => array(
				// 'Image.model_id' => 'Article.id',
				'Image.model' => 'Article',
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	/**
	 * Override parent before save for slug generation
	 * Also handles ordering of the page
	 *
	 * @return boolean Always true
	 */
	public function beforeSave($options = array()) {
		// If user updates the slug manually
		if (isset($this->data['Article']['slug']) && !empty($this->data['Article']['slug'])) {
			$this->data['Article']['slug'] = $this->generateSlug($this->data['Article']['slug']);
		}

		// only on create
		if (isset($this->data[$this->alias]['title']) && empty($this->data[$this->alias]['meta_title'])) {
			$this->data[$this->alias]['meta_title'] = EMCMS_substr(stripAllHtmlTags($this->data[$this->alias]['title']), 0, 75);
		}

		if (isset($this->data[$this->alias]['summary']) && empty($this->data[$this->alias]['meta_description'])) {
			$this->data[$this->alias]['meta_description'] = EMCMS_substr(stripAllHtmlTags($this->data[$this->alias]['summary']), 0, 160);
		}

		return parent::beforeSave($options);
	}

}