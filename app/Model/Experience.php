<?php
App::uses('AppModel', 'Model');
/**
 * Experience Model
 *
 * @property User $User
 * @property City $City
 * @property Language $Language
 * @property Timezone $Timezone
 * @property Currency $Currency
 * @property Category $Category
 * @property Subcategory $Subcategory
 */
class Experience extends AppModel {


/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Experience';

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
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'A numeric value is required',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => false,
			),
		),
		'city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'A numeric value is required',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => false,
			),
		),
		'language_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'A numeric value is required',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => false,
			),
		),
		'timezone_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'A numeric value is required',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => false,
			),
		),
		'currency_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'A numeric value is required',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => false,
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'A numeric value is required',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => false,
			),
		),
		'subcategory_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'A numeric value is required',
				'allowEmpty' => true,
			),
		),

		'title' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Experience title can not be empty.',
				'allowEmpty' => false
			),
			'between' => array(
				'rule' => array('lengthBetween', 10, 42),
				'message' => 'Title shoulf be between 10 to 42 characters'
			),
		),
		'tagline' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Experience tagline can not be empty.',
				'allowEmpty' => false
			),
			'maxLength' => array(
				'rule' => array('maxLength', 64),
				'message' => 'Experience title can not have more then 64 characters.',
			),
		),
	    'start_time' => array(
	    	'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Experience Start time can not be empty.',
				'allowEmpty' => false,
			),
			'time' => array(
				'rule' => array('time'),
				'message' => 'Experience title can not have more then 64 characters.',
			),
	    ),
	    'end_time' => array(
	    	'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Experience end time can not be empty.',
				'allowEmpty' => false,
			),
	    ),
        'what_will_do' => array(
        	'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Experience summary can not be empty.',
				'allowEmpty' => false
			),
			'between' => array(
			    'rule' => array('lengthBetween', 200, 1200),
			    'message' => 'Description should be between 200 to 1200 characters'
			),
        ),
		'where_will_be' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Experience summary can not be empty.',
				'allowEmpty' => false
			),
			'between' => array(
			    'rule' => array('lengthBetween', 100, 450),
			    'message' => 'Description should be between 100 to 450 characters'
			),
		),
		'about_you' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Host bio can not be empty.',
				'allowEmpty' => false
			),
			'between' => array(
			    'rule' => array('lengthBetween', 150, 500),
			    'message' => 'Description should be between 150 to 500 characters'
			),
		),
		'notes' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 200),
				'message' => 'Experience note can not have more then 200 characters.',
				'allowEmpty' => true,
			),
		),
		'guests' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'only numbers allowed',
				'allowEmpty' => true,
				'required' => false,
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'price' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'only numbers allowed',
			),
		),
		'need_notes' =>  'boolean',
		'need_provides' =>  'boolean',
		'need_packing_lists' =>  'boolean',
		'last_minute_guest' =>  'boolean',
		'includes_alcohol' =>  'boolean',
		'is_free_under_2' =>  'boolean',
		'hosting_standards_reviewed' => 'boolean',
		'experience_standards_reviewed' =>  'boolean',
		'quality_standards_reviewed' =>  'boolean',
		'local_laws_reviewed' =>  'boolean',
		'terms_service_reviewed' =>  'boolean',
		'is_approved' =>  'boolean',
		'is_featured' =>  'boolean',
		'status' =>  'boolean',
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Address' => [
			'className' => 'Address',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => [
				// 'Address.model_id = Experience.id',
				'Address.model' => 'Experience',
			],
			'fields' => '',
			'order' => '',
		],
	);

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
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
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
		),
		'Timezone' => array(
			'className' => 'Timezone',
			'foreignKey' => 'timezone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => array(
				'Category.model' => 'Experience',
				'Category.status' => true
			),
			'fields' => '',
			'order' => ''
		),
		'Subcategory' => array(
			'className' => 'Category',
			'foreignKey' => 'subcategory_id',
			'conditions' => array(
				'Category.model' => 'Experience',
				'Category.status' => true
			),
			'fields' => '',
			'order' => ''
		)
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
			'conditions' => array(
				'Image.model' => 'Experience',
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SeasonalPrice' => array(
			'className' => 'SeasonalPrice',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => array(
				'SeasonalPrice.model' => 'Experience',
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Review' => array(
			'className' => 'Review',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => array(
				'Review.model' => 'Experience'
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserWishlist' => array(
			'className' => 'UserWishlist',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => array(
				'UserWishlist.model' => 'Experience',
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeFind($query) {
		if (!isset($query['contain']) || !in_array('Currency', $query['contain'], true)) {
			$query['contain'][] = 'Currency';
		}
		return parent::beforeFind($query);
	}

	public function afterFind($results, $primary = false) {

		if (!$primary) {
			return parent::afterFind($results, $primary);
		}
		
		// parent::afterFind($results, $primary);

	    App::import('Component', 'CurrencyConverter.CurrencyConverter');
		$CurrencyConverter = new CurrencyConverterComponent(new ComponentCollection);
		$localeCurrency = $this->Currency->getLocalCurrency();
	    $localeSymbol = $this->Currency->findCurrencySymbolByCode($localeCurrency);
	    $currency_format = Configure::read('Website.currency_position');

	    foreach ($results as $key => &$experience) {
	    	$experience[$this->alias]['packing_list'] = json_decode($experience[$this->alias]['packing_list'], true);

	    	// default keep experience price
	    	$price_converted = isset($experience['Experience']['price']) ? $experience['Experience']['price'] : 0;

	    	// format property price
	    	if (isset($experience['Currency']['code']) || isset($experience['Experience']['Currency']['code'])) {
	    		if (isset($experience['Currency']['code'])) {
	    			$code = trim($experience['Currency']['code']);
	    		} elseif (isset($experience['Experience']['Currency']['code'])) {
	    			$code = trim($experience['Experience']['Currency']['code']);
	    		}
	    		$price_converted = $CurrencyConverter->convert($code, $localeCurrency, $experience['Experience']['price'], 1, 4);
	    	}

			$experience['Experience']['price_converted'] = sprintf($currency_format, $localeSymbol, EMCMS_safeCharEncodePrice($price_converted));
	    }

	    return $results;
	}

	/**
	 * Converts array data for template vars into a json serialized string
	 *
	 * @param array $options
	 * @return boolean
 	 */
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['packing_list']) && !empty($this->data[$this->alias]['packing_list'])) {
			$this->data[$this->alias]['packing_list'] = json_encode($this->data[$this->alias]['packing_list']);
		}
		return parent::beforeSave($options);
	}

	/**
	 * getExperience
	 * @param  int $id
	 * @return mixed array | null
	 */
	public function getExperience($id = null) {
		$options =  array(
		    'contain' => array(
		    	# BelongsTo
		        'User',
		        'Language',
		        'Timezone',
		        'Currency',
		        'Category',
		        'Subcategory',
		        # HasMany
		        'Image',
		        # HasOne
		        'Address' => [
		        	'Country',
		        ],
		    ),
		    'conditions' => array(
		        'Experience.' . $this->primaryKey => $id,
		        'Experience.is_approved' => 'approved',
		        'Experience.is_featured' => 1,
		        'Experience.status' => 1,
		    ),
		    'recursive' => 0,
		);
		$experience = $this->find('first', $options);


        return $experience;
	}

	/**
	 * getExperience
	 * @param  int $id
	 * @return mixed array | null
	 */
	public function getReviews($id = null) {
		$options = [
			'conditions' => [
				'Review.model_id' => $id,
				'Review.model' => 'Experience',
				'Review.status' => 1,
			],
			'order' => [
				'Review.id ASC',
			],
			'recursive' => 0,
		];
		$reviews = $this->Review->find('all', $options);
	}
}
