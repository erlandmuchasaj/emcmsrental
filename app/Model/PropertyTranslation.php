<?php
App::uses('AppModel', 'Model');
/**
 * PropertyTranslation Model
 *
 * @property Property $Property
 * @property Language $Language
 */
class PropertyTranslation extends AppModel {
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
				'message' => "You can not access this attribute directly!",
				'on' => 'create',
			),
		),
		'title' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 75),
				'message' => 'title can not have more then 75 characters.',
				'allowEmpty' => true,
				'required' => false
			),
		),
		'seo_title' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 75),
				'message' => 'Meta title can not have more then 75 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'seo_description' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'Meta description can not have more then 160 characters.',
				'allowEmpty' => true,
				'required' => false
			),
		)
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Property' => array(
			'className' => 'Property',
			'foreignKey' => 'property_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);



	/**
	 * BeforeSave Method
	 *
	 * @return array
	 */
	public function beforeSave($options = array()) {
		// only on create
		if (isset($this->data[$this->alias]['title']) && empty($this->data[$this->alias]['seo_title'])) {
			$this->data[$this->alias]['seo_title'] = EMCMS_substr(stripAllHtmlTags($this->data[$this->alias]['title']), 0, 75);
		}

		if (isset($this->data[$this->alias]['description']) && empty($this->data[$this->alias]['seo_description'])) {
			$this->data[$this->alias]['seo_description'] = EMCMS_substr(stripAllHtmlTags($this->data[$this->alias]['description']), 0, 160);
		}

		return parent::beforeSave($options);
	}

}
