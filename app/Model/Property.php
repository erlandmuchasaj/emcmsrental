<?php
App::uses('AppModel', 'Model');
App::uses('CakeEvent', 'Event');

/**
 * Property Model
 *
 * @property User $User
 * @property Currency $Currency
 * @property RoomType $RoomType
 * @property Calendar $Calendar
 * @property PropertyPicture $PropertyPicture
 * @property PropertyTranslation $PropertyTranslation
 * @property Reservation $Reservation
 * @property Review $Review
 * @property Characteristic $Characteristic
 * @property Extra $Extra
 * @property Security $Security
 * @property Service $Service
 */
class Property extends AppModel {

/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Property';

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
	public $displayField = 'address';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'Your can not modify directly the ID',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank, Property belongs to a user',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'address' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'latitude' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'longitude' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'country' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'city' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'locality' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'district' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'state_province' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'zip_code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'capacity' => array(
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
		'bathroom_number' => array(
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
		'bedroom_number' => array(
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
		'bed_number' => array(
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
		'garages' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'only numbers allowed',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'contract_type' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be left blank',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'surface_area' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'only numbers allowed',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'minimum_days' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'only numbers allowed',
				'allowEmpty' => true,
				'required' => false,
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'maximum_days' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'only numbers allowed',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'currency_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'This field can not be empty',
				'allowEmpty' => false,
				'required' => false,
			),
		),
		'is_featured' => array(
	        'rule' => array('boolean'),
	        'message' => 'Incorrect value for is_featured'
    	)
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
		'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CancellationPolicy' => array(
			'className' => 'CancellationPolicy',
			'foreignKey' => 'cancellation_policy_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RoomType' => array(
			'className' => 'RoomType',
			'foreignKey' => 'room_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AccommodationType' => array(
			'className' => 'AccommodationType',
			'foreignKey' => 'accommodation_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Calendar' => array('dependent' => true),
		'Price' => [
			'className' => 'Price',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => [
				// 'Price.model_id = Property.id',
				'Price.model' => 'Property'
			],
			'fields' => '',
			'order' => ''
		],
		'Address' => [
			'className' => 'Address',
			'foreignKey' => 'model_id',
			'dependent' => true,
			'conditions' => [
				// 'Address.model_id = Property.id',
				'Address.model' => 'Property',
				// 'Address.status' => 1
			],
			'fields' => '',
			'order' => ''
		]
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'PropertyPicture' => array(
			'className' => 'PropertyPicture',
			'foreignKey' => 'property_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => array('sort' => 'asc'),
			'limit' => 30, // grab only the last 25 images
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PropertyTranslation' => array(
			'className' => 'PropertyTranslation',
			'foreignKey' => 'property_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '', // we only need one translation
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
				'SeasonalPrice.model' => 'Property',
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Reservation' => array(
			'className' => 'Reservation',
			'foreignKey' => 'property_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => 10,
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
				'Review.model' => 'Property',
			),
			'fields' => '',
			'order' => '',
			'limit' => 10,
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
				'UserWishlist.model' => 'Property',
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

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Characteristic' => array(
			'className' => 'Characteristic',
			'joinTable' => 'characteristics_properties',
			'foreignKey' => 'property_id',
			'associationForeignKey' => 'characteristic_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Safety' => array(
			'className' => 'Safety',
			'joinTable' => 'properties_safeties',
			'foreignKey' => 'property_id',
			'associationForeignKey' => 'safety_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	/**
	 * Returns an array of restaurants based on a kitchen id
	 * @param string $characteristic_id - the id of a kitchen
	 * @return array of restaurants
	 */
	public function getPropertiesByCharacteristics($characteristic_id = null) {
	    if (empty($characteristic_id)) return false;
	    $properties = $this->find('all', array(
	        'joins' => array(
	             array('table' => 'characteristics_properties',
	                'alias' => 'CharacteristicsProperty',
	                'type' => 'INNER',
	                'conditions' => array(
	                    'CharacteristicsProperty.characteristic_id' => $characteristic_id,
	                    'CharacteristicsProperty.property_id = Property.id'
	                )
	            )
	        ),
	        'group' => 'Property.id'
	    ));
	    return $properties;
	}


	/********************************************/
	/* Finding the person who created this item */
	/********************************************/
	public function isOwnedBy($property_id, $user_id) {
		return (bool)($this->field('Property.id', array('Property.id' => $property_id, 'Property.user_id' => $user_id)) === $property_id);
	}

	/* HERE WE FIND $fild of an ITEM based on ID */
	public function getField($field = 'address', $id) {
		return $this->field($field, array('Property.id' => $id));
	}

	/* HERE WE FIND STATUS of an ITEM. */
	public function isPublished($id) {
		return (bool)$this->field('Property.status', array('Property.id' => $id));
	}

	public function instantBook($id) {
		return (bool)$this->field('Property.allow_instant_booking', array('Property.id' => $id));
	}

	/* Check if property is accepted. */
	public function isAccepted($id) {
		return (bool)$this->field('Property.is_approved', array('Property.id' => $id));
	}

	public function isDeleted($id) {
		return (bool)$this->field('Property.deleted', array('Property.id' => $id));
	}

	/* Find featured properties. */
	public function findFeatured($number = 5, $recursive =-1) {
		return $this->find('all',
			array('conditions' => array('Property.is_featured'=>1, 'Property.status'=>1, 'Property.is_approved'=>1, 'Property.deleted' => null), 'recursive'=>$recursive, 'limit' => $number));
	}

	/* Find featured properties. */
	public function findRecent($number = 1, $recursive =-1) {
		return $this->find('all', array('conditions' => array('Property.status'=>1, 'Property.is_approved'=>1, 'Property.deleted' => null),'order'=>array('Property.created'=>'desc'), 'recursive'=>$recursive, 'limit' => $number));
	}

	/* Find the Owner ID of this property. */
	public function findUserId($id) {
		return (int)$this->field('Property.user_id', array('id' => $id));
	}

	public function getProperty($id = null, $language_id) {
        $this->unbindModel([
        	'hasMany'=>['PropertyTranslation'],
        	'belongsTo' => ['RoomType', 'AccommodationType']
        ]);
        $this->bindModel(array(
        	'hasOne' => array(
        		'RoomType' => array(
        			'foreignKey' => false,
        			'conditions' => array(
        				'RoomType.room_type_id = Property.room_type_id',
        				'RoomType.language_id' => $language_id
        			),
        			'className' => 'RoomType'
        		),
        		'AccommodationType' => array(
        			'foreignKey' => false,
        			'conditions' => array(
        				'AccommodationType.accommodation_type_id = Property.accommodation_type_id',
        				'AccommodationType.language_id' => $language_id
        			),
        			'className' => 'AccommodationType'
        		),
        		'PropertyTranslation' => array(
        		    'foreignKey' => false,
        		    'conditions' => array(
        		    	'PropertyTranslation.property_id = Property.id',
        		    	'PropertyTranslation.language_id' => $language_id
        		    ),
        		    'className' => 'PropertyTranslation'
        		),
        	)
        ));

        $conditions = [
        	'Property.'.$this->primaryKey => $id,
        	'Property.status' => 1,
        	'Property.is_approved' => 1,
        	'Property.deleted' => null,
        ];

		$conditions['AND'] = [
            'OR' => array(
                'Property.availability_type' => ['always', 'sometimes', null],
                'AND' => array(
                    'Property.availability_type' => 'one_time',
                    'Property.available_from <= ' => date('Y-m-d'),
                    'Property.available_to >=' => date('Y-m-d'),
                ),
            ),
	    ];

        $options =  array(
            'contain' => array(
            	# Belongs to
                'RoomType',
                'AccommodationType',
                'CancellationPolicy',
                'Currency',
                'User',

                # Has many
                'PropertyTranslation',
                'PropertyPicture',
                // 'UserWishlist',
                
                # Has one
                'Address',
                'Price',

                #has and belongs to many
                'Characteristic',
                'Safety'
            ),
            'conditions' => $conditions,
            'recursive' => 0
        );
        $property = $this->find('first', $options);

        if (!$property) {
        	return null;
        }

        // format address of the property
        $buildAddress = '';
        if (!empty($property['Property']['locality'])) {
        	$buildAddress .= ', '.$property['Property']['locality'];
        }

        if (!empty($property['Property']['state_province'])) {
        	$buildAddress .= ', '.$property['Property']['state_province'];
        }

        if (!empty($property['Property']['country'])) {
        	$buildAddress .= ', '.$property['Property']['country'];
        }

        $location = ltrim($buildAddress, ", ");
        $property['Property']['location'] = h($location) .'&nbsp;<i class="fa fa-map-marker" aria-hidden="true"></i>.';

        // add review related info
        $property['Property']['total_reviews'] = $this->Review->getReviewCount($property['Property']['user_id'], $id, $this->alias);
        $property['Rating'] = $this->Review->getReviewRating($property['Property']['user_id'], $id, $this->alias);
        $property['Review'] = $this->Review->getReviews($property['Property']['user_id'], $id, $this->alias);

        // adding default wishlist variables
		$property['Property']['short_listed'] = false;
		$property['Property']['count_wishlist'] = 0;
		// if user is logged in find the property wishlist
		if (AuthComponent::user('id')):
			$options = [
				'conditions' => [
					'user_id' => AuthComponent::user('id'),
					'model_id' => $id,
					'model' => $this->alias,
				],
				'recursive' => -1,
				'callbacks' => false,
			];
			$userWishlist = $this->UserWishlist->find('count', $options);
			if ($userWishlist) {
				$property['Property']['short_listed'] = true;
				$property['Property']['count_wishlist'] = $userWishlist;
			}
		endif;

        return $property;
	}

	public function optimiseMapResult($properties = []) {
		$propertyMarkersArray = [];
		foreach ($properties as $key => $property) {
			$propertyLink  = Router::Url(array('controller' => 'properties', 'action' => 'view', $property['Property']['id']), true);

			$directoryMdURL  = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$property['Property']['id'].DS.'PropertyPicture'.DS.'small'.DS.$property['Property']['thumbnail'];

			$directoryMdPATH = '/img/uploads/Property/'.$property['Property']['id'].'/PropertyPicture/small/'.$property['Property']['thumbnail'];

			if (file_exists($directoryMdURL) && is_file($directoryMdURL)) {
				$propertyThumbnailMap = Router::url($directoryMdPATH, true);
			} else {
				$propertyThumbnailMap = Router::url('/img/map/no-img-available.png', true);
			}
			
			$propertyMarkersArray[$key]['id'] 		= $property['Property']['id'];
			$propertyMarkersArray[$key]['title'] 	= addslashes(h($property['PropertyTranslation']['title']));
			$propertyMarkersArray[$key]['type'] 	= addslashes(h($property['Property']['type_formated']));
			$propertyMarkersArray[$key]['address'] 	= addslashes(h($property['Property']['state_province']));
			$propertyMarkersArray[$key]['allow_instant_booking'] = (bool) $property['Property']['allow_instant_booking'];
			$propertyMarkersArray[$key]['contract_type'] = $property['Property']['contract_type'];
			$propertyMarkersArray[$key]['price'] 	= $property['Property']['price_converted'];
			$propertyMarkersArray[$key]['bedrooms'] = $property['Property']['bedroom_number'];
			$propertyMarkersArray[$key]['bed_number']= $property['Property']['bed_number'];
			$propertyMarkersArray[$key]['bathrooms']= $property['Property']['bathroom_number'];
			$propertyMarkersArray[$key]['capacity'] = $property['Property']['capacity'];
			$propertyMarkersArray[$key]['area'] 	= $property['Property']['surface_area'];
			$propertyMarkersArray[$key]['hits'] 	= $property['Property']['hits'];
			$propertyMarkersArray[$key]['view'] 	= $propertyLink;
			$propertyMarkersArray[$key]['image'] 	= $propertyThumbnailMap;
			$propertyMarkersArray[$key]['position']['lat'] = $property['Property']['latitude'];
			$propertyMarkersArray[$key]['position']['lng'] = $property['Property']['longitude'];
			$propertyMarkersArray[$key]['markerIcon'] = $this->webroot.'img/map/marker-new.png';
			unset($propertyThumbnailMap);
		}
		return $propertyMarkersArray;
	}

	public function getFeaturedProperties($language_id, $limit = 6) {
		// Room Type
		$this->unbindModel([
			'hasMany'=>['PropertyTranslation'],
			'belongsTo' => ['RoomType', 'AccommodationType']
		]);
		$this->bindModel(array(
			'hasOne' => array(
				'RoomType' => array(
					'foreignKey' => false,
					'conditions' => array(
						'RoomType.room_type_id = Property.room_type_id',
						'RoomType.language_id' => $language_id
					),
					'className' => 'RoomType'
				),
				'AccommodationType' => array(
					'foreignKey' => false,
					'conditions' => array(
						'AccommodationType.accommodation_type_id = Property.accommodation_type_id',
						'AccommodationType.language_id' => $language_id
					),
					'className' => 'AccommodationType'
				),
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			)
		));
		// Most visited properties
		return $this->find('all', [
			'contain' => [
				'PropertyTranslation',
				'AccommodationType',
				'RoomType',
				'Currency',
				'Price',
				'User'
			],
			'conditions' => [
				'Property.status'=> 1,
				'Property.is_approved'=> 1,
				'Property.is_featured'=> 1,
				'Property.deleted'=> null
			],
			'limit' => (int) $limit,
			'order' => [
				'Property.sort' => 'ASC', 
				'Property.created'=> 'DESC'
			],
			'recursive' => -1
		]);
	}

	/**
	 * BeforeSave Method
	 *
	 * @return array
	 */
	public function beforeSave($options = array()) {
		// only on create
		return parent::beforeSave($options);
	}

	public function afterSave($created, $options = array()) {
		// sent an email to the user after a property has been
		// created
		if ($created === true) {
			// $ecentName, $eventSubject, $passedData
			$Event = new CakeEvent('Model.Property.created', $this, [
				'id' => $this->id,
				'data' => $this->data[$this->alias]
			]);
			$this->getEventManager()->dispatch($Event);
		}
		return parent::afterSave($created, $options);
	}

	public function beforeFind($query) {
		if (!isset($query['contain']) || !in_array('Currency', $query['contain'], true)) {
			$query['contain'][] = 'Currency';
		}

		return parent::beforeFind($query);
	}

	public function afterFind($results, $primary = false) {
		parent::afterFind($results, $primary);

	    App::import('Component','CurrencyConverter.CurrencyConverter');
		$CurrencyConverter = new CurrencyConverterComponent(new ComponentCollection);
		$localeCurrency = $this->Currency->getLocalCurrency();
	    $localeSymbol = $this->Currency->findCurrencySymbolByCode($localeCurrency);
	    $currency_format = Configure::read('Website.currency_position');

		$month = 60 * 60 * 24 * 30; // month in seconds
		
	    foreach ($results as $key => &$property) {
	    	// default keep property price
	    	$price_converted = isset($property['Property']['price']) ? $property['Property']['price'] : 0;

	    	// format property price
	    	if (isset($property['Currency']['code']) || isset($property['Property']['Currency']['code'])) {
	    		if (isset($property['Currency']['code'])) {
	    			$code = trim($property['Currency']['code']);
	    		} elseif(isset($property['Property']['Currency']['code'])) {
	    			$code = trim($property['Property']['Currency']['code']);
	    		}
	    		$price_converted = $CurrencyConverter->convert(
	    			$code,
	    			$localeCurrency,
	    			$property['Property']['price'],
	    			1,
	    			4
	    		);
	    	}

			$property['Property']['price_converted'] = sprintf($currency_format, $localeSymbol, EMCMS_safeCharEncodePrice($price_converted));

	    	$property['Property']['is_new'] = (isset($property['Property']['created']) && (time() - strtotime($property['Property']['created']) < $month)) ? true : false ;

	    	$property['Property']['type_formated'] = (isset($property['Property']['contract_type']) && $property['Property']['contract_type'] === 'rent') ? __('For rent') : __('For sale');
	    }
	    unset($property);

	    return $results;
	}

	public function beforeDelete($cascade = true) {
	    $propertyId = $this->id;
	    return parent::beforeDelete($cascade);
	}

	// perhaps after deleting a record from the database,
	// you also want to delete
	// an associated file
	public function afterDelete() {
		parent::afterDelete();

		$directoryToDelete = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$this->id.DS;
		$this->__deleteDirectory($directoryToDelete);
		return true;
	}

	/**
	 * deletDirectory Method
	 * @param string $directory
	 * @return void
	 */
	public function __deleteDirectory($dirname = '') {
		if (file_exists($dirname) && is_dir($dirname )) {
			$dir_handle = opendir($dirname);
		}

		if (!isset($dir_handle) || empty($dir_handle) || !$dir_handle){
			return false;
		}

		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file)){
					$file_to_delete = $dirname."/".$file;
					if (isset($file_to_delete) && !empty($file_to_delete) && trim($file_to_delete)!='') {
						if (file_exists($file_to_delete) && is_file($file_to_delete)) {
							unlink($file_to_delete);
						}
					}
				} else {
					self::__deleteDirectory($dirname.'/'.$file);
				}
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}

	/********************************************/
	/*		HABTM association function 			*/
	/********************************************/
	public function beforeValidate($options = array()) {
		foreach($this->hasAndBelongsToMany as $k=>$v) {
			if (isset($this->data[$k][$k])) {
				$this->data[$this->alias][$k] = $this->data[$k][$k];
			}
		}
		return parent::beforeValidate();
	}

	public function validateDate($date) {
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') == $date;
	}

}
