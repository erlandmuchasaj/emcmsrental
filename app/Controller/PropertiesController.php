<?php
App::uses('AppController', 'Controller');
App::uses('Paypal', 'Paypal.Lib');
/**
 * Properties Controller
 *
 * @property Property $Property
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PropertiesController extends AppController {

	/**
	 * Name
	 *
	 * @var string
	 */
	public $name = 'Properties';

	/**
	 * Uses
	 *
	 * @var array
	 */
	public $uses = [];

	/**
	 * Helpers
	 *
	 * @var array
	 */
	public $helpers = [];

	/**
	 * Month and week
	 * constants used for price calculation
	 */
	const WEEK = 7;
	const MONTH = 28;

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array(
		'Paginator',
		'Upload',
		'Stripe',
		// 'TwoCheckout',
		// 'BackUp',
        'CurrencyConverter.CurrencyConverter',
    );

	/**
	 * paginate setting
	 *
	 * @var array
	 */
	public $paginate = array(
    	'maxLimit' => 40,
    	'paramType' => 'querystring',
	);

	/**
	 * beforeFIlter method
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		/**
		 *	Making a jquery ajax call with Security component activated
		 *	$this->Security->unlockedActions = array('ajax_action');
		 */
		$this->Auth->allow(
			'index',
			'view',
			'search',
			'featured',
			'map_properties',
			'sitemap',
			'contactUs',
			'load',
			'ajax_refresh_subtotal',
			'maintenance',
			'paymentIpn'
		);
		$this->Auth->autoRedirect = false;
		if (isset($this->Security) && $this->action == 'paymentIpn') {
		  $this->Security->validatePost = false;
		}
	}

	/**
	 * user authorization method
	 *
	 * @return void
	 */
	public function isAuthorized($user = null) {
		// All registered users can add posts
		if (in_array($this->action, array('index', 'view', 'add'))) {
			return true;
		}

		// The owner of a post can edit and delete it
		if (in_array($this->action, array('edit', 'delete'))) {
			$property_id = $this->request->params['pass'][0];
			if (!$this->Property->isOwnedBy($property_id, $user['id'])) {
				$this->Auth->unauthorizedRedirect = Router::url(array('controller'=>'users', 'action'=>'dashboard'), true);
				return false;
			}
		}

		return parent::isAuthorized($user);
	}

	/**
	 * sitemap method
	 *
	 * @access public
	 * @return void
	 */
	public function sitemap(){
		$this->layout = 'xml/default';
		Configure::write('debug', 0);
		$this->RequestHandler->respondAs('xml');
		$properties = $this->Property->find('all',
			array(
				'conditions'=>array(
					'Property.status'=>1,
					'Property.is_approved'=>1,
					'Property.deleted'=> null
				),
				'order'=> array(
					'Property.modified'=>'DESC'
				),
				'recursive' => 0
			)
		);
		$this->set(compact('properties'));
	}

	/**
	 * Maintenance template
	 */
	public function maintenance(){
		$this->set('title_for_layout', 'Maintenance');
		$this->layout = 'commingsoon';
		return $this->render('/Pages/maintenance');	
	}

	/**
	 * index method
	 *
	 * @access public
	 * @return void
	 */
	public function index() {

		// $db = ConnectionManager::getDataSource('default');
		// $config  = $db->config;
		// $tables  = $db->listSources();
		// $db_name = $db->getSchemaName();
		// $prefix = $db->config['prefix'];
		// $id_lang_default = 1;
		// $id_lang = 18;
		// // $result = $db->query('SHOW TABLES FROM `'.$db_name.'`');
		// foreach ($tables as $table_name) {
		// 	// $table_name = $table['TABLE_NAMES']['Tables_in_'.$db_name];
		//     if (
		//     	(preg_match('/_translations/', $table_name) ||
		//     		$table_name == $config['prefix'].'accommodation_types' ||
		//     		$table_name == $config['prefix'].'room_types') &&
		//     	($table_name != $config['prefix'].'languages')
		//     ) {
		//         $result2 = $db->query('SELECT * FROM `'.$table_name.'` WHERE `language_id` = '.(int)$id_lang_default);
		//         if (!count($result2)) {
		//             continue;
		//         }
		//         // delete old language if there is any
		//     	$db->query('DELETE FROM `'.$table_name.'` WHERE `language_id` = '.(int)$id_lang);
		// 		$table 		= str_replace($config['prefix'], '', $table_name);
		// 		$ModelName 	= Inflector::classify($table);
		// 		$Model 		= ClassRegistry::init($ModelName);
		// 		// $keys = array_keys($result2[0][$table_name]);
		// 		// debug($Model->schema());
		// 		// debug($Model->getColumnTypes());
		// 		$fields = array_keys($Model->schema());
		// 		if (($key = array_search($Model->primaryKey, $fields)) !== false) {
		// 		    unset($fields[$key]);
		// 		}
		// 		$header = '`' . implode('`, `', $fields) . '`';
		// 		// debug($header);
		// 		// debug($result2);
		// 		// die;

		// 		// 'INSERT INTO `accommodation_types` (`id`, `accommodation_type_id`, `language_id`, `accommodation_type_name`) VALUES (3, 2, 1, 'Apartment')'


		//         $query = 'INSERT INTO `'.$table_name.'` ('.$header.') VALUES ';
		//         foreach ($result2 as $row2) {
		//             $query .= '(';
		//             $row2[$table_name]['language_id'] = $id_lang;
		//             foreach ($row2[$table_name] as $name => $field) {
		//             	// do not dublicate primary key.
		//             	if ($name === $Model->primaryKey) {
		//             		continue;
		//             	}
		//                 $query .= (!is_string($field) && $field == null) ? 'NULL,' : '\''.mysqlPrepare($field, true).'\',';
		//             }
		//             $query = rtrim($query, ',').'),';
		//         }
		//         $query = rtrim($query, ',');
		//         debug($query);
		//         die;
		//         $db->query($query);
		//     }
		// }

		// $message  = "\n".__('Hello');
		// $message .= "\n".__('This is a test email');
		// $optionsEmail = array(
		// 	'subject' => __('Email Test.'),
		// 	'content' => $message
		// );
		// parent::__sendMail('erland.muchasaj@gmail.com', $optionsEmail);


		// App::uses('CakeEmail', 'Network/Email');
		// $Email = new CakeEmail();
		// $Email->config('smtp') // smtp, default, fast, mailtrap
		//     ->from(['info@erlandmuchasaj.com' => 'EMCMS'])              
		//     ->to(['erland.muchasaj@gmail.com' => 'Erlandi'])
		//     ->subject('About');
		
		// if($Email->send('My message')){
		//     die("sent");
		// }else {
		//     die("error");
		// }

		$this->set('title_for_layout', __('Vacation Rentals, Homes, Apartments & Rooms for Rent'));
		$homeSettings = ClassRegistry::init('SiteSetting')->getSiteSetting('HOME_SETTINGS');
		$this->set(compact('homeSettings'));
	}

	/**
	 * featured method
	 *
	 * @access public
	 * @return void
	 */
	public function featured() {
        if (empty($this->request->params['requested'])) {
            throw new ForbiddenException();
        }
        $language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();
        // Most visited properties
        return $this->Property->getFeaturedProperties($language_id);
	}

	/**
	 * view method
	 * Prepare PTG redirect Post To Get
	 * so we load with ajax the search results
	 *
	 * @access public
	 * @throws NotFoundException
	 * @return void
	 */
	public function search() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$this->layout = null;
		} else {
			$this->layout = 'search';
		}


		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();
		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);

		$this->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);

		$conditions = [
			'Property.status' => 1,
			'Property.deleted' => null,
			'Property.is_approved' => 1,
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

		if (isset($this->request->data['Property']['check_in_out'])) {
			unset($this->request->data['Property']['check_in_out']);
		}

		if (isset($this->request->query['check_in_out'])) {
			unset($this->request->query['check_in_out']);
		}

		// this is used for named params
		// Inspect all the named parameters to apply the filters
		foreach($this->request->query as $param_name => $value) {
			// Don't apply the default named parameters used for pagination
			if (!in_array($param_name, array('page', 'sort', 'direction', 'limit'), true) && !empty($value)) {
				// You may use a switch here to make special filters
				// like "between dates", "greater than", etc
				if ($param_name === 'location') {

					$this->request->data['Property'][$param_name] = urldecode($value);

					$searchTerms = $this->Property->sanitize(urldecode($value));
					
					// $conditions['Property.address LIKE'] = $searchTerms;

					$terms = explode(' ', $searchTerms);
					$address = [];
					foreach($terms as $key => $eachAND) {

						// if string is empty and less then 3 characters do not process the search
						if (!empty($eachAND) && strlen($eachAND) >= (int)Configure::read('EMCMS_SEARCH_MIN_WORD_LENGTH')) {

						    $word = str_replace(array('%', '_'), array('\\%', '\\_'), $eachAND);
			                $start_search = Configure::check('EMCMS_SEARCH_START') ? Configure::read('EMCMS_SEARCH_START'): '';
			                $end_search = Configure::check('EMCMS_SEARCH_END') ? Configure::read('EMCMS_SEARCH_END'): '';

						    // build query string
						    $searchTerm = ($word[0] == '-' ? $start_search.EMCMS_escape(EMCMS_substr($word, 1, Configure::read('EMCMS_SEARCH_MAX_WORD_LENGTH'))).$end_search
						        : $start_search.EMCMS_escape(EMCMS_substr($word, 0, Configure::read('EMCMS_SEARCH_MAX_WORD_LENGTH'))).$end_search
						    );

						    $address[]["Property.address LIKE"] = $searchTerm;
						}  else {
						    unset($terms[$key]);
						}
					}
					$conditions['OR'] = $address;

				} elseif ($param_name === 'characteristics') {
					$habtmCharacteristicsSearch = [];
					foreach ($value as $key => $id) {
						$habtmCharacteristicsSearch[]['CharacteristicsProperty.characteristic_id'] = $id;
						$this->request->data['Property'][$param_name][] = urldecode($id);
					}
					// $conditions[] = $habtmCharacteristicsSearch;

				} elseif ($param_name === 'safeties') {
					$habtmSafetiesSearch = [];
					foreach ($value as $key => $id) {
						$habtmSafetiesSearch[]['PropertiesSafety.safety_id'] = $id;
						$this->request->data['Property'][$param_name][] = urldecode($id);
					}
					// $conditions[] = $habtmSafetiesSearch;

				} elseif (in_array($param_name, ['room_type_id', 'accommodation_type_id', 'contract_type'], true)) {
					$conditions['Property.'.$param_name] = urldecode($value);
					$this->request->data['Property'][$param_name] =  urldecode($value);

				} elseif (in_array($param_name, ['bathroom_number', 'bedroom_number', 'bed_number', 'garages', 'surface_area','capacity'], true)) {
					$conditions["Property.{$param_name} >="] = urldecode($value);
					$this->request->data['Property'][$param_name] =  urldecode($value);
				} elseif (in_array($param_name, ['checkin', 'checkout'])) {
					// here we can add logic for checkin and checkout search
					$this->request->data['Property'][$param_name] =  urldecode($value);
				} else {
					// add data to query
					$this->request->data['Property'][$param_name] =  urldecode($value);
				}
			}
		}

		$this->Paginator->settings = [
			'conditions' => $conditions,
			'limit' => 40,
			'order' => [
				'Property.sort' => 'ASC',
				'Property.id' => 'DESC'
			],
			'contain' => [
				'PropertyTranslation',
				'AccommodationType',
				'RoomType',
				'Calendar',
				'Currency',
				'Address',
				'Price',
				'User',
			],
			'paramType' => 'querystring',
			'maxLimit' => 100,
			// 'group' => 'Property.id',
		];

		if (isset($habtmCharacteristicsSearch) && !empty($habtmCharacteristicsSearch)) {
			$conditionsCharacteristics = [
				'CharacteristicsProperty.property_id = Property.id'
			];
			$conditionsCharacteristics['AND'][] = $habtmCharacteristicsSearch;

			$this->Paginator->settings['joins'][] = array(
				'table' => 'characteristics_properties',
				'alias' => 'CharacteristicsProperty',
				'type' => 'INNER',
				'foreignKey' => 'characteristic_id',
				'conditions' => $conditionsCharacteristics
			);
		}

		if (isset($habtmSafetiesSearch) && !empty($habtmSafetiesSearch)) {
			$conditionsSafeties = [
				'PropertiesSafety.property_id = Property.id'
			];
			$conditionsSafeties['AND'][] = $habtmSafetiesSearch;
			$this->Paginator->settings['joins'][] = array(
				'table' => 'properties_safeties',
				'alias' => 'PropertiesSafety',
				'type' => 'INNER',
				'foreignKey' => 'safety_id',
				'conditions' => $conditionsSafeties,
			);
		}

		try {
			$searchResults = $this->Paginator->paginate();
		} catch (NotFoundException $e) {
		    // Do something here like redirecting to first or last page.
		    // $this->request->params['paging'] will give you required info.
		    // $options =  $this->request->params['paging']['Property']['options'];
		    $this->Flash->error(__('%s %s, Page number exeded.', [$e->getCode(), $e->getMessage()]));
		    return $this->redirect(array('controller'=> 'properties', 'action' => 'search', '?' => ['page'=>1]));
		}

		$checkin = isset($this->request->query['checkin']) ? $this->request->query['checkin'] : null;
		$checkout = isset($this->request->query['checkout']) ? $this->request->query['checkout'] : null;

		if (!empty($checkin) && !empty($checkout)) {
			$searchResults = array_filter($searchResults, function($property) use ($checkin, $checkout) {
			    
				$calendar = !empty($property['Calendar']['calendar_data']) ? $property['Calendar']['calendar_data'] : false;
				if ($calendar) {

					$decoded = json_decode($calendar, true);

                    if (json_last_error()) {
                        return false;
                    }
            
                    if (!is_array($decoded)) {
                        return false;
                    }
   
					$checkout_time = strtotime($checkout);
					while (strtotime($checkin) < $checkout_time){ 
						if (isset($decoded[$checkin])){
							if ($decoded[$checkin]['status'] === 'booked' || $decoded[$checkin]['status'] === 'unavailable') {
								return false;
							}
						}
						$checkin = date("Y-m-d", strtotime("+1 day", strtotime($checkin)));
					}
				}
				return $property;
			});
		}


		if ($this->request->is('ajax')) {
			$response = [
				'error'   => 0,
				'message' => '',
				'data'    => null,
			];
			$response['data'] = $this->Property->optimiseMapResult(array_values($searchResults));
			// Also set the AJAX layout if needed
			return json_encode($response);
		}

		$roomTypes = $this->Property->RoomType->find('list',
			array(
				'conditions' => array('RoomType.language_id'=>$language_id),
				'fields' => array('RoomType.room_type_id', 'RoomType.room_type_name'),
				'recursive'=>-1
			)
		);

		$accommodationTypes = $this->Property->AccommodationType->find('list',
			array(
				'conditions' => array('AccommodationType.language_id'=>$language_id),
				'fields' => array('AccommodationType.accommodation_type_id', 'AccommodationType.accommodation_type_name'),
				'recursive'=>-1
			)
		);

		$characteristics = $this->Property->Characteristic->find('all', array(
			'joins' => array(
				array(
					'table' => 'characteristic_translations',
					'alias' => 'CharacteristicTranslation',
					'type' => 'LEFT',
					'conditions' => array('Characteristic.id = CharacteristicTranslation.characteristic_id')
				)
			),
			'conditions' => array('CharacteristicTranslation.language_id' => $language_id),
			'fields' => array('CharacteristicTranslation.id', 'CharacteristicTranslation.characteristic_name', 'Characteristic.icon_class'),
			'recursive' => 0
		));

		$safeties = $this->Property->Safety->find('all', array(
			'joins' => array(
				array(
					'table' => 'safety_translations',
					'alias' => 'SafetyTranslation',
					'type' => 'LEFT',
					'conditions' => array('Safety.id = SafetyTranslation.safety_id')
				)
			),
			'conditions' => array('SafetyTranslation.language_id' => $language_id),
			'fields' => array('SafetyTranslation.id', 'SafetyTranslation.safety_name', 'Safety.icon_class'),
			'recursive' => 0
		));

		$this->set(compact(
			'searchResults',
			'roomTypes', 'accommodationTypes',
			'safeties', 'characteristics'
		));
	}

	/**
	 * view method
	 *
	 * @access public
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->helpers[] = 'SocialShare.SocialShare';
		$this->helpers[] = 'Video';

		if (!$id) {
			throw new BadRequestException(__('Bad Request. Property id missing'));
		}

		$this->Property->id = $id;
		if (!$this->Property->exists()) {
			throw new NotFoundException(__('Property not found.'));
		}

		if (!$this->Property->isPublished($id)) {
			throw new NotFoundException(__('Property is not published.'));
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();
        // Get a single property to display
        $property = $this->Property->getProperty($id, $language_id);
        if (!$property) {
        	$this->Flash->error(__('This property is not published or has not been approved by admin yet!'));
        	return $this->redirect($this->referer());
        }

		$propertyCharacteristics = $this->Property->Characteristic->find('all', array(
			'joins' => array(
				array(
					'table' => 'characteristic_translations',
					'alias' => 'CharacteristicTranslation',
					'type' => 'LEFT',
					'conditions' => array('Characteristic.id = CharacteristicTranslation.characteristic_id')
				),
				array(
					'table' => 'characteristics_properties',
					'alias' => 'CharacteristicsProperty',
					'type' => 'LEFT',
					'conditions' => array('Characteristic.id = CharacteristicsProperty.characteristic_id')
				)
			),
			'conditions' => array(
				'CharacteristicTranslation.language_id' => $language_id,
				'CharacteristicsProperty.property_id' => $id,
			),
			'fields' => array('Characteristic.*', 'CharacteristicTranslation.*'),
			'recursive' => -1
		));
		$propertySafeties = $this->Property->Safety->find('all', array(
			'joins' => array(
				array(
					'table' => 'safety_translations',
					'alias' => 'SafetyTranslation',
					'type' => 'LEFT',
					'conditions' => array('Safety.id = SafetyTranslation.safety_id')
				),
				array(
					'table' => 'properties_safeties',
					'alias' => 'PropertySafeties',
					'type' => 'LEFT',
					'conditions' => array('Safety.id = PropertySafeties.safety_id')
				)
			),
			'conditions' => array(
				'SafetyTranslation.language_id' => $language_id,
				'PropertySafeties.property_id' => $id,
			),
			'fields' => array('Safety.*', 'SafetyTranslation.*'),
			'recursive' => -1
		));

		$this->set(
			compact(
				'property',
				'propertySafeties',
				'propertyCharacteristics'
			)
		);
	}

	/**
	 * load Calendar Data
	 *
	 * @access public
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function load($id= null) {
		$this->layout = null;
		$this->autoRender = false;
		$this->request->allowMethod('ajax');

		if ($this->Property->Calendar->exists($id)) {
			$calendar = $this->Property->Calendar->find('first', array('conditions' => array('Calendar.'.$this->Property->Calendar->primaryKey =>$id)));
			if (isset($calendar['Calendar']['calendar_data']) && !empty($calendar['Calendar']['calendar_data'])) {
				return $calendar['Calendar']['calendar_data'];
			}
		}
		return json_encode([]); // return an empty array
	}
////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////
	/**
	 * booking
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function book($id = null) {
		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__('This property does not exist.'));
		}

		// if (!$this->Auth->loggedIn()) {
		// 	$this->Flash->error(__('You Have to be logged in in order to make a booking!'));
		// 	return $this->redirect(['controller'=>'properties', 'action' => 'view', $id]);
		// }

		// if ($this->Property->isOwnedBy($id, $this->Auth->user('id'))) {
		// 	$this->Flash->error(__('You can not book your own property!'));
		// 	return $this->redirect(['controller'=>'properties', 'action' => 'view', $id]);
		// }

		App::uses('Country', 'Model');
		$Country = new Country();
		$countries = $Country->find('list', array(
	        'fields' => array('Country.iso_code', 'Country.name'),
	        'recursive' => -1,
	        'callbacks' => false
	    ));

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

        // Room Type
        $this->Property->unbindModel(array(
        	'belongsTo' => array('RoomType', 'AccommodationType'),
        	'hasMany' => array('PropertyTranslation' )
        ));
        $this->Property->bindModel(array(
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
        		    'foreignKey' => 'property_id',
        		    'conditions' => array(
        		    	'PropertyTranslation.property_id = Property.id',
        		    	'PropertyTranslation.language_id' => $language_id
        		    ),
        			'className' => 'PropertyTranslation'
        		),
        	)
        ));

        $options = array(
            'contain' => array(
				'PropertyTranslation',
				'CancellationPolicy',
				'AccommodationType',
				'RoomType',
				'Currency',
				'Address',
				'Price',
				'User'
            ),
            'conditions' => array(
                'Property.'.$this->Property->primaryKey => $id,
                'Property.status' => 1,
                'Property.is_approved' => 1,
                'Property.deleted' => null,
            ),
        );
        $property = $this->Property->find('first', $options);

        // $stripePublishableKey = $this->Stripe->getPublishableKey();

		$this->set(compact('property', 'countries'));
	}

	/**
	 * create_booking Method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function create_booking($id = null) {
		$this->autoRender = false;

		if ($this->request->is(['post', 'put'])) {

			if (!$this->Property->exists($id)) {
				throw new NotFoundException(__('This property does not exist.'));
			}

			if (!$this->Auth->loggedIn()) {
				throw new UnauthorizedException(__('You Have to be logged in in order to make a booking!'));
			}

			if ($this->Property->isOwnedBy($id, $this->Auth->user('id'))) {
				throw new ForbiddenException(__('You can not book your own property!'));
			}

			if (!$this->request->data['Booking']['terms_and_conditions']) {
				$this->Flash->error(__('You must agree to the Terms of Service and Privacy Policy in order to Continue!'));
				return $this->redirect($this->referer());
			}

			if (
				!isset($this->request->data['Booking']['checkin']) ||
				!$this->Property->validateDate($this->request->data['Booking']['checkin'])
			) {
				$this->Flash->error(__('Invalid checkin date format!'));
				return $this->redirect($this->referer());
			}

			if (
				!isset($this->request->data['Booking']['checkout']) ||
				!$this->Property->validateDate($this->request->data['Booking']['checkout'])
			) {
				$this->Flash->error(__('Invalid checkout date format!'));
				return $this->redirect($this->referer());
			}

			if (empty($this->request->data['Booking']['guests'])) {
				$this->Flash->error(__('Invalid guest number!'));
				return $this->redirect($this->referer());
			}

			$guests   = (int) $this->request->data['Booking']['guests'];
			$checkin  = trim($this->request->data['Booking']['checkin']);
			$checkout = trim($this->request->data['Booking']['checkout']);

			// This is used in case user tries to hack hidden data of the system
			$recalculatedData = $this->__getPrice($id, $checkin, $checkout, $guests);
			if ($recalculatedData['available'] === false) {
				$this->Flash->error(__('Sorry! Access denied: %s', $recalculatedData['message']));
				return $this->redirect($this->referer());
			}

			$instantBook = $this->Property->instantBook($id);

			// predefined data
			$reservationData = [];
			$reservationData['property_id'] = $id;
			$reservationData['checkin']  = $checkin;
			$reservationData['checkout'] = $checkout;
			$reservationData['guests'] 	 = $guests;
			$reservationData['user_by']  = $this->Auth->user('id');
			$reservationData['user_to']  = $this->Property->findUserId($id);
			$reservationData['type']  	 = 'site';
			$reservationData['cancellation_policy_id'] = $this->Property->getField('Property.cancellation_policy_id', $id);

			// reservation data
			$reservationData['reservation_status'] = ($instantBook) ? 'payment_pending' : 'pending_approval';

			// recalculated data to prevent hacking.
			$reservationData['currency'] 	      = $recalculatedData['data']['locale_currency'];
			$reservationData['price'] 			  = $recalculatedData['data']['price_per_night'];
			$reservationData['nights'] 			  = $recalculatedData['data']['days'];
			$reservationData['subtotal_price'] 	  = $recalculatedData['data']['subtotal_price'];
			$reservationData['cleaning_fee'] 	  = $recalculatedData['data']['cleaning_fee'];
			$reservationData['security_fee'] 	  = $recalculatedData['data']['security_fee'];
			$reservationData['service_fee'] 	  = $recalculatedData['data']['service_fee'];
			$reservationData['extra_guest_price'] = $recalculatedData['data']['extra_guest_price'];
			$reservationData['avarage_price'] 	  = $recalculatedData['data']['avarage_price_per_night'];
			$reservationData['total_price'] 	  = $recalculatedData['data']['total_price'];
			$reservationData['to_pay'] 			  = ($recalculatedData['data']['total_price'] - $recalculatedData['data']['service_fee']);
			$reservationData['book_date'] 		  = date('Y-m-d H:i:s');

			// App::uses('Coupon', 'Model');
			// $this->Coupon = new Coupon();
			// $todayDate = date('Y-m-d');
			// $options = array('conditions' => [
			// 	'Coupon.code' => 'ZC2QV57QF6TU',
			// 	'Coupon.status' => 1,
			// 	'Coupon.date_from <= ' => $todayDate,
			// 	'Coupon.date_to >=' => $todayDate,
			// ]);
			// $coupon = $this->Coupon->find('first', $options);
			// if ($coupon) {
			// 	$data['coupon_value'] = 0;
			// 	if ($coupon['Coupon']['price_type'] == 2) { // fixed
			// 		$total_price = $total_price - $coupon['Coupon']['price_value'];
			// 		$data['coupon_value'] = $coupon['Coupon']['price_value'];
			// 	} else { // percentage
			// 		$per  = $coupon['Coupon']['price_value'];
			// 		$camt = round(floatval(($total_price * $per) / 100), 2);
			// 		$total_price = $total_price - $camt;
			// 		$data['coupon_value'] = $camt;
			// 	}
			// }

			if ($instantBook) {
				$payment_method = 'not_defined';
				if (isset($this->request->data['Booking']['payment_method'])) {
					$payment_method = EMCMS_strtolower($this->request->data['Booking']['payment_method']);
				}

				if (!in_array($payment_method, ['paypal', 'twocheckout', 'stripe', 'credit_card'], true)) {
					throw new NotImplementedException(__('Payment method not implemented!'));
				}

				if ($payment_method === 'credit_card') {
					$this->Flash->warning(__('This payment method (%s) has not been implemented yet!', Inflector::humanize($payment_method)));
					return $this->redirect($this->referer());
				}

				// payment method (paypal/stripe/credit_card) and country
				$reservationData['payment_method'] 	= $payment_method;
				$reservationData['payment_country'] = $this->request->data['Booking']['payment_country'];
			}


			# Save Reservation into DB
			$this->Property->Reservation->create();
			if ($this->Property->Reservation->save($reservationData)) {

				$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();
				// Room Type
				$this->Property->unbindModel([
					'hasMany'=>['PropertyTranslation']
				]);
				$this->Property->bindModel([
					'hasOne' => [
						'PropertyTranslation' => [
						    'foreignKey' => 'property_id',
						    'conditions' => [
						    	'PropertyTranslation.property_id = Property.id',
						    	'PropertyTranslation.language_id' => $language_id
						    ],
						    'className' => 'PropertyTranslation'
						],
					]
				]);

				$options = [
					'contain' => [
						'Host',
						'Traveler',
						'Property' => [
							'Price',
							'Address',
							'Currency',
							'PropertyTranslation',
						],
						'CancellationPolicy',
					],
					'conditions' => [
						'Reservation.'.$this->Property->Reservation->primaryKey => $this->Property->Reservation->getLastInsertId(),
					],
				];
				$reservation = $this->Property->Reservation->find('first', $options);
			} else {
				$this->Flash->error(__('Reservation could not be processed. Please try again later!'));
				return $this->redirect($this->referer());
			}

			// send the custom message to host
			if (!empty($this->request->data['Booking']['message_to_host'])) {
				$insertData = array(
					'property_id'    => $reservation['Reservation']['property_id'],
					'reservation_id' => $reservation['Reservation']['id'],
					'user_by'        => $reservation['Reservation']['user_by'],
					'user_to'        => $reservation['Reservation']['user_to'],
					'subject'        => __('Message host.'),
					'message'        => EMCMS_escape($this->request->data['Booking']['message_to_host']),
					'message_type'   => 'reservation_request'
				);
				$insertData['Message'] = $insertData;
				$this->Property->Reservation->Message->sentMessage($insertData, 1);
			}

			/**
			 * if instant booking is not allowed then proceed reservation list
			 * if is not instant booking we sent reservation request 
			 * notification to traveler and host
			 */
			if (!$instantBook) {
				// Send Message Notification to Traveler
				$insertData = array(
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'conversation_id' => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_to'],
					'user_to'         => $reservation['Reservation']['user_by'],
					'subject'         => __('Request Sent.'),
					'message'         => __('You sent a new reservation request to %s for %s.', array($reservation['Host']['name'], $reservation['Property']['address'])),
					'message_type'   => 'request_sent'
				);
				$insertData['Message'] = $insertData;
				$this->Property->Reservation->Message->sentMessage($insertData);

				//Send Message Notification to the host
				$insertData = [
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_by'],
					'user_to'         => $reservation['Reservation']['user_to'],
					'subject'         => __('Reservation Request.'),
					'message'         => __('You have a new reservation request from  %s for %s.', array($reservation['Traveler']['name'], $reservation['Property']['address'])),
					'message_type'   => 'reservation_request'
				];
				$insertData['Message'] = $insertData;
				$this->Property->Reservation->Message->sentMessage($insertData);

				//Send Mail To Traveller
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Traveler']['name']);
				$message .= "\n".__('Your reservation request is successfully sent to the appropriate host');
				$message .= "\n".__('Please wait for his confirmation.');
				$message .= "\n".__('Thanks and Regards.');
				$message .= "\n".__('%s Team.', Configure::read('Website.name'));
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,
					'subject' => __('Reservation notification for traveller.'),
					'content' => $message
				);
				parent::__sendMail($reservation['Traveler']['email'], $optionsEmail);

				//Send Mail To Host
				$viewVars = array('reservation' => $reservation);
				$message  = "\n".__('Hello %s,', $reservation['Host']['name']);
				$message .= "\n".__('%s booked the %s place on %s at %s.', array($reservation['Traveler']['name'], $reservation['Property']['address'], date('m/d/Y'), date('g:i A',time())));
				$message .= "\n".__('Thanks and Regards');
				$message .= "\n".__('%s Team.', Configure::read('Website.name'));
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,
					'subject' => __('Reservation notification for host'),
					'content' => $message
				);
				parent::__sendMail($reservation['Host']['email'], $optionsEmail);

				$this->Flash->success(__('Booking request has been sent to %s!', $reservation['Host']['name']));
				return $this->redirect(['controller'=>'reservations', 'action' => 'my_trips']);
			}

			if ('paypal' === $payment_method) {
				try {

					$this->Paypal = new Paypal([
						'sandboxMode' => Configure::read('PayPal.SANDBOX_flag'),
						'nvpUsername' => Configure::read('PayPal.API_username'),
						'nvpPassword' => Configure::read('PayPal.API_password'),
						'nvpSignature'=> Configure::read('PayPal.API_signature'),
					]);

					$paypalCurrency = $reservation['Reservation']['currency'];
					// if (in_array($paypalCurrency, ['INR', 'MYR', 'ARS', 'CNY', 'IDR','KRW', 'VND', 'ZAR'], true)) {
					// 	$paypalCurrency = 'USD'; // Paypal Default Currency is USD
					// }

					$toBook = [
						'description'=> __('Booking from %s Site', Configure::read('Website.name')),
						'currency'	=> $paypalCurrency,
						'return' 	=> Configure::read('PayPal.RETURN_url') . '/' . $reservation['Reservation']['id'],
						'cancel' 	=> Configure::read('PayPal.CANCEL_url') . '/' . $reservation['Reservation']['id'],
						'shipping' 	=> '0',
						'locale' 	=> $this->Property->PropertyTranslation->Language->getActiveLanguageCode(),
						// 'custom' 	=> 'Erland Muchasaj',
					];

					$temp_product = [
						'name'		=> isset($reservation['Property']['PropertyTranslation']['title']) ? h($reservation['Property']['PropertyTranslation']['title']) : 'Transaction.',
						'description'=> isset($reservation['Property']['PropertyTranslation']['description']) ? stripAllHtmlTags($reservation['Property']['PropertyTranslation']['description']) : 'Booking transaction.',
						'number'	=> $reservation['Reservation']['id'],
						'subtotal'	=> $reservation['Reservation']['total_price'],
						'tax'		=> 0,
						'qty'		=> 1,
					];
					$toBook['items'][] = $temp_product;

					$this->Session->write('reservation_id', $reservation['Reservation']['id']);

					$redirectUrl = $this->Paypal->setExpressCheckout($toBook);

					return $this->redirect($redirectUrl);
				} catch (Exception $e) {
					$this->Flash->error(__("PayPal misconfigured: %s. Please contact support.", $e->getMessage()));
					return $this->redirect(array('controller'=>'properties', 'action' => 'view', $id));
				}
			} elseif ('stripe' === $payment_method) {
				// $stripe = isset($this->request->data['Stripe']) ? $this->request->data['Stripe'] : null;
				// $card = [
				// 	'number' => $stripe['card_number'],
				// 	'exp_month' => $stripe['expire']['month'],
				// 	'exp_year' => $stripe['expire']['year'],
				// 	'cvc' => $stripe['security_code'], // cvc
				// ];
				// $token = $this->Stripe->createCardToken($card);
				// debug($token);
				// die();
				// $stripe = isset($this->request->data['Booking']['token']) ? $this->request->data['Booking']['token'] : null;

				$stripe = isset($this->request->data['Stripe']) ? $this->request->data['Stripe'] : null;
				return $this->stripe($reservation, $stripe);
			} elseif ('twocheckout' === $payment_method) {
				// # code...
				// App::uses('HttpSocket', 'Network/Http');
				// $HttpSocket = new HttpSocket();
				// $endPoint = 'https://sandbox.2checkout.com/checkout/purchase';
				// $body = [
				// 	'sid' => $this->TwoCheckout->getSellerId(),
				// 	'mode' => '2CO',
				// 	'li_0_type' => 'product',
				// 	'li_0_name' => isset($reservation['Property']['PropertyTranslation']['title']) ? $reservation['Property']['PropertyTranslation']['title'] : 'Transaction.',
				// 	'li_0_quantity' => 1,
				// 	'li_0_price' => $reservation['Reservation']['total_price'],
				// 	'li_0_tangible' => 'N',

				// 	'li_0_product_id' => $reservation['Property']['id'],
				// 	'li_0_description' => isset($reservation['Property']['PropertyTranslation']['description']) ? stripAllHtmlTags($reservation['Property']['PropertyTranslation']['description']) : 'Booking transaction.',

				// 	'currency_code' => $this->TwoCheckout->getSellerId(),
				// 	'lang' => $this->Property->PropertyTranslation->Language->getActiveLanguageCode(),
				// ];

				// $response = $HttpSocket->post($endPoint, $body);
				// debug($response);
				// die();
			} else {
				$this->Flash->error(__('This payment method (%s) has not been implemented yet.', h($payment_method)));
				return $this->redirect($this->referer());

				// throw new BadRequestException(__('This payment method (%s) has not been implemented yet.', h($payment_method)));
			}
		} else {
			throw new MethodNotAllowedException(__('Method not allowed. Only POST and PUT methods are allowed.'));
		}
	}

	/**
	 * Stripe
	 * Handle strupe payment workflow;
	 * @param  array $reservation
	 * @param  array $stripe     
	 * @return void
	 */
	public function stripe($reservation = null, $stripe = null) {
		$this->autoRender = false;

		$datasource = $this->Property->getDataSource();

		try {
		    $datasource->begin();

			// we check availability within these dates
			if (!$this->Property->Calendar->checkAvailability($reservation['Property']['id'], $reservation['Reservation']['checkin'], $reservation['Reservation']['checkout'])) {

				$this->Property->Reservation->id = $reservation['Reservation']['id'];
				$this->Property->Reservation->saveField('reservation_status', 'expired');

				// if these dates has alredy been booked by someone else
				// we expire this request for reservation
				$this->Reservation->expire($reservation['Reservation']['id']);

				$this->Flash->error(__('Those dates are no longer available.'));
				return $this->redirect(array('controller' => 'properties', 'action' => 'view', $reservation['Property']['id']));
			}

			// if we do have availability then proceed with the money collection
			$card = [
				'number' => $stripe['card_number'],
				'exp_month' => $stripe['expire']['month'],
				'exp_year' => $stripe['expire']['year'],
				'cvc' => $stripe['security_code'], // cvc
			];
			$token = $this->Stripe->createCardToken($card);
			if ($token['status'] !== 'success') {

				$datasource->rollback();

				$this->Flash->error($token['message']);
				return $this->redirect(['controller' => 'properties', 'action' => 'view', $reservation['Property']['id']]);
			}

			$data = [
				'card' 		  => $token['response']['id'],
				'currency'    => EMCMS_strtolower($reservation['Reservation']['currency']),
				'amount'      => $this->Stripe->getCents($reservation['Reservation']['total_price']),
				'description' => __('Booking from %s Site', Configure::read('Website.name')),
				'reservation' => $reservation['Reservation'],
				// Whether to immediately capture the charge. Defaults to true. 
				// 'capture' => true, 
				// Many objects contain the ID of a related object in their response properties. 
				// 'expand' => ['customer'],
			];
			$charge = $this->Stripe->charge($data);

			if ($charge['status'] !== 'success') {

				$datasource->rollback();

				$this->Property->Reservation->id = $reservation['Reservation']['id'];
				$this->Property->Reservation->saveField('reservation_status', 'payment_error');

				$this->Flash->error($charge['message']);
				return $this->redirect(['controller' => 'properties', 'action' => 'view', $reservation['Property']['id']]);
			}

			/**
			 * @todo Implement or test later
			 */
			$reservation['Reservation']['transaction_id'] = $charge['response']['id'];

			$reservation['Reservation']['payer_id'] = $charge['response']['customer'];
			$reservation['Reservation']['payer_email'] = $charge['response']['receipt_email'];

			// populate data comming from stripe
			if ($charge['response']['captured'] != true) {

				$datasource->rollback();

				$this->Flash->success(__('Reservation Completed! Proceed with the payment.'));
				$this->set(compact('reservation'));
				return $this->render('success');
			}

			$reservation['Reservation']['is_payed'] = true;
			$reservation['Reservation']['payed_date'] = date('Y-m-d H:i:s');
			$reservation['Reservation']['reservation_status'] = 'payment_completed';

			$today   = get_gmt_time(strtotime(date("Y-m-d")));
			$checkin = get_gmt_time(strtotime($reservation['Reservation']['checkin']));
			if ($checkin <= $today) {
				$reservation['Reservation']['reservation_status'] = 'awaiting_checkin';
			}


			$date1 = new DateTime(date('Y-m-d H:i:s', strtotime($reservation['Reservation']['checkin'])));
			$date2 = new DateTime(date('Y-m-d H:i:s', strtotime($reservation['Reservation']['checkout'])));
			$interval = $date1->diff($date2);
			if ($interval->days >= self::MONTH) {
				$reservation['Reservation']['cancellation_policy_id'] = 5;
			} else {
				$reservation['Reservation']['cancellation_policy_id'] = $reservation['Property']['cancellation_policy_id'];
			}

			$calendar = $this->Property->Calendar->find('first', ['conditions' => array('Calendar.property_id'=> $reservation['Property']['id'])]);
			if (isset($calendar['Calendar']['calendar_data']) && !empty($calendar['Calendar']['calendar_data'])) {
				$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
			} else {
				$decoded = [];
			}
			$start_date = $reservation['Reservation']['checkin'];
			$checkout_time = strtotime($reservation['Reservation']['checkout']);
			while (strtotime($start_date) < $checkout_time) {
				if (isset($decoded[$start_date])) {
					$decoded[$start_date]['status'] = 'booked';
				} else {
					$temp_product = array(
						"bind" 	  => 0,
						"info" 	  => "",
						"notes"   => "",
						"price"   => "",
						"promo"   => "",
						"status"  => "booked",
						"booked_using" =>"portal",
						"user_id" => $reservation['Traveler']['id'],
					);
					$decoded[$start_date] = $temp_product;
				}
				if (isset($temp_product)) {
					unset($temp_product);
				}
				$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
			}
			$encoded = json_encode($decoded);

			//Construct Calendar object to save in DB
			$calendar['Calendar']['id'] = $reservation['Property']['id'];
			$calendar['Calendar']['property_id'] = $reservation['Property']['id'];
			$calendar['Calendar']['calendar_data'] = $encoded;
			if ($this->Property->Reservation->save($reservation) && $this->Property->Calendar->save($calendar)) {

				//Send Message Notification to Host
				$insertData = array(
					'property_id'     => $reservation['Reservation']['property_id'],
					'reservation_id'  => $reservation['Reservation']['id'],
					'user_by'         => $reservation['Reservation']['user_by'],
					'user_to'         => $reservation['Reservation']['user_to'],
					'subject'         => __('Reservation Request.'),
					'message'         => __('You have a new reservation from %s for %s.', array($reservation['Traveler']['name'], $reservation['Property']['address'])),
					'message_type'   => 'reservation_request'
				);
				$insertData['Message'] = $insertData;
				$this->Property->Reservation->Message->sentMessage($insertData);

				$datasource->commit();

				$this->Flash->success(__('Reservation Completed! Enjoy your staying.'));
			} else {
				
				$datasource->rollback();

				$this->Flash->error(__('Reservation Completed with errors, (Data could not be saved on Database)!'));
			}


			$this->set(compact('reservation'));
			$this->render('success');
		} catch (Exception $e) {

			$datasource->rollback();

			$this->Flash->error($e->getMessage());
			return $this->redirect(['controller' => 'properties', 'action' => 'view', $reservation['Property']['id']]);
		}
	}

	/**
	 * Process general payment method
	 *
	 * @throws NotFoundException
	 * @param int $reservation_id
	 * @return void
	 */
	public function success($reservation_id = null) {
		// We check here if we have set the payments data on session
		if (!$reservation_id) {
			throw new BadRequestException(__('Payment could not be processed, missing reservation id. Please try again'));
		}

		if (!$this->Property->Reservation->exists($reservation_id)) {
			throw new NotFoundException(__('Reservation not found.'));
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();
		// Room Type
		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			]
		]);
		$reservation = $this->Property->Reservation->find('first', [
			'contain' => array(
				'Traveler',
				'Host',
				'Property' => [
					'PropertyTranslation',
					'Currency',
					'Price',
				],
				'CancellationPolicy',
			),
			'conditions' => [
				'Reservation.'.$this->Property->Reservation->primaryKey => $reservation_id,
			],
			'limit' => 1
		]);

		$this->set(compact('reservation'));
	}

	/**
	 *Process data for paypal
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function paymentSuccess($id = null) {

		if (!isset($this->request->query['token']) || !isset($this->request->query['PayerID'])) {
			throw new BadRequestException(__('Token Or PayerID is not Set. Please try again'));
		}

		$reservation_id = (int) $this->Session->read('reservation_id');
		if (!$reservation_id) {
			$reservation_id = $id;
		}

		if (!$this->Property->Reservation->exists($reservation_id)) {
			throw new NotFoundException(__('Reservation not found.'));
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();
		// Room Type
		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			]
		]);
		$reservation = $this->Property->Reservation->find('first', [
			'contain' => array(
				'Host',
				'Traveler',
				'Property' => [
					'Price',
					'Address',
					'Currency',
					'PropertyTranslation',
				],
				'CancellationPolicy',
			),
			'conditions' => [
				'Reservation.'.$this->Property->Reservation->primaryKey => $reservation_id,
			],
		]);

		// we check availability within these dates
		if (!$this->Property->Calendar->checkAvailability($reservation['Property']['id'], $reservation['Reservation']['checkin'], $reservation['Reservation']['checkout'])) {

			$this->Property->Reservation->id = $reservation['Reservation']['id'];
			$this->Property->Reservation->saveField('reservation_status', 'expired');

			// if these dates has alredy been booked by someone else
			// we expire this request for reservation
			$this->Reservation->expire($reservation['Reservation']['id']);

			$this->Flash->error(__('Those dates are no longer available.'));
			return $this->redirect(array('controller' => 'properties', 'action' => 'view', $reservation['Property']['id']));
		}

		$datasource = $this->Property->getDataSource();
		// $datasource->useNestedTransactions = true;
		try {
			
			$datasource->begin();

			$this->Paypal = new Paypal([
				'sandboxMode' => Configure::read('PayPal.SANDBOX_flag'),
				'nvpUsername' => Configure::read('PayPal.API_username'),
				'nvpPassword' => Configure::read('PayPal.API_password'),
				'nvpSignature'=> Configure::read('PayPal.API_signature')
			]);

			$token 	  = $this->request->query['token'];
			$payer_id = $this->request->query['PayerID'];

			$getExpressCheckoutReturn = $this->Paypal->getExpressCheckoutDetails($token);

			$payer_email = isset($getExpressCheckoutReturn['EMAIL']) ? $getExpressCheckoutReturn['EMAIL'] : '';
			// populate and save user data related to paypal payments details
			$reservation['Reservation']['payer_id'] = $payer_id;
			$reservation['Reservation']['payer_email'] = $payer_email;

			$order = [
				'description' => __('Booking from %s Site', Configure::read('Website.name')),
				'return'  => Configure::read('PayPal.RETURN_url').'/'.$reservation['Reservation']['id'],
				'cancel'  => Configure::read('PayPal.CANCEL_url').'/'.$reservation['Reservation']['id'],
				'ipn_url' => Configure::read('PayPal.IPN_url'),
				'shipping'=> '0',
				'currency'=> $getExpressCheckoutReturn['PAYMENTREQUEST_0_CURRENCYCODE'],
				'locale'  => $this->Property->PropertyTranslation->Language->getActiveLanguageCode(),
				// 'custom' 	=> 'Erland Muchasaj',
			];

			$tmp_product = [
				'name'		=> isset($reservation['Property']['PropertyTranslation']['title']) ? $reservation['Property']['PropertyTranslation']['title'] : 'Transaction.',
				'description'=> isset($reservation['Property']['PropertyTranslation']['description']) ? stripAllHtmlTags($reservation['Property']['PropertyTranslation']['description']) : 'Booking transaction.',
				'number'	=> $reservation['Reservation']['id'],
				'subtotal'	=> $getExpressCheckoutReturn['PAYMENTREQUEST_0_AMT'],
				'tax'		=> 0,
				'qty'		=> 1,
			];
			$order['items'][] = $tmp_product;

			try {

				$datasource->begin();

				$doExpressCheckoutReturn = $this->Paypal->doExpressCheckoutPayment($order, $token, $payer_id);

				if (
					isset($doExpressCheckoutReturn['L_SHORTMESSAGE0']) &&
					($doExpressCheckoutReturn['L_SHORTMESSAGE0'] === 'Duplicate Request')
				) {
					// if user hits refresh and the request is dublicated.
					throw new Exception($doExpressCheckoutReturn['L_LONGMESSAGE0'], 1);
					
					// $datasource->rollback();
					// $this->Flash->error($doExpressCheckoutReturn['L_LONGMESSAGE0']);
					// return $this->redirect(array('controller' => 'properties', 'action' => 'view', $reservation['Property']['id']));
				}
				
				$reservation['Reservation']['transaction_id'] = (isset($doExpressCheckoutReturn['PAYMENTINFO_0_TRANSACTIONID'])) ? $doExpressCheckoutReturn['PAYMENTINFO_0_TRANSACTIONID'] : '';

				// populate data comming from paypal
				$reservation['Reservation']['reservation_status'] = 'payment_completed';

				$today   = get_gmt_time(strtotime(date("Y-m-d")));
				$checkin = get_gmt_time(strtotime($reservation['Reservation']['checkin']));
				if ($checkin <= $today) {
					$reservation['Reservation']['reservation_status'] = 'awaiting_checkin';
				}

				$reservation['Reservation']['payed_date'] = date('Y-m-d H:i:s');
				$reservation['Reservation']['is_payed']   = true;

				$date1 = new DateTime(date('Y-m-d H:i:s', strtotime($reservation['Reservation']['checkin'])));
				$date2 = new DateTime(date('Y-m-d H:i:s', strtotime($reservation['Reservation']['checkout'])));
				$interval = $date1->diff($date2);
				if($interval->days >= self::MONTH) {
					$reservation['Reservation']['cancellation_policy_id'] = 5;
				} else {
					$reservation['Reservation']['cancellation_policy_id'] = $reservation['Property']['cancellation_policy_id'];
				}

				$calendar = $this->Property->Calendar->find('first', array('conditions' => array('Calendar.property_id'=> $reservation['Property']['id'])));
				if (isset($calendar['Calendar']['calendar_data']) && !empty($calendar['Calendar']['calendar_data'])) {
					$decoded = json_decode($calendar['Calendar']['calendar_data'], true);
				} else {
					$decoded = [];
				}
				$start_date = $reservation['Reservation']['checkin'];
				$checkout_time = strtotime($reservation['Reservation']['checkout']);
				while (strtotime($start_date) < $checkout_time) {
					if (isset($decoded[$start_date])) {
						$decoded[$start_date]['status'] = 'booked';
					} else {
						$temp_product = array(
							"bind" 	  => 0,
							"info" 	  => "",
							"notes"   => "",
							"price"   => "",
							"promo"   => "",
							"status"  => "booked",
							"booked_using" =>"portal",
							"user_id" => $reservation['Traveler']['id'],
						);
						$decoded[$start_date] = $temp_product;
					}
					if (isset($temp_product)) {
						unset($temp_product);
					}
					$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
				}
				$encoded = json_encode($decoded);

				// Here are other STEPS to follow such as
				/*	1) Send Reservation Notification To Host
				*	2) Send Reservation Notification To Traveller
				* 	3) Send Reservation Notification To Administrator (Global portal e-mail)
				*	4) Save Reservation Model
				*	5) Update Calendar
				*/

				//Construct Calendar object to save in DB
				$calendar['Calendar']['id'] = $reservation['Property']['id'];
				$calendar['Calendar']['property_id'] = $reservation['Property']['id'];
				$calendar['Calendar']['calendar_data'] = $encoded;
				if ($this->Property->Reservation->save($reservation) && $this->Property->Calendar->save($calendar)) {
					/*	SEND MESSAGE TO THE HOST	*/
					/*	SEND MESSAGE TO THE TRAVELER	*/
					/*	SEND MESSAGE TO THE ADMIN	*/

					// //Send Message
					// $insertData = array(
					// 	'property_id'     => $reservation['Reservation']['property_id'],
					// 	'reservation_id'  => $reservation['Reservation']['id'],
					// 	'conversation_id' => $reservation['Reservation']['id'],
					// 	'user_by'         => $reservation['Reservation']['user_to'],
					// 	'user_to'         => $reservation['Reservation']['user_by'],
					// 	'subject'         => __('Your reservation is successfully done.'),
					// 	'message_type'   => 'message'
					// );
					// $insertData['Message'] = $insertData;
					// $this->Property->Reservation->Message->sentMessage($insertData);

					//Send Message Notification to Host
					$insertData = array(
						'property_id'     => $reservation['Reservation']['property_id'],
						'reservation_id'  => $reservation['Reservation']['id'],
						'user_by'         => $reservation['Reservation']['user_by'],
						'user_to'         => $reservation['Reservation']['user_to'],
						'subject'         => __('Reservation Request.'),
						'message'         => __('You have a new reservation from %s for %s.', array($reservation['Traveler']['name'], $reservation['Property']['address'])),
						'message_type'   => 'reservation_request'
					);
					$insertData['Message'] = $insertData;
					$this->Property->Reservation->Message->sentMessage($insertData);

					$datasource->commit();

					$this->Session->delete('reservation_id');
					$this->Flash->success(__('Reservation Completed! Enjoy your staying.'));
				} else {
					$datasource->rollback();

					$this->Flash->warning(__('Reservation Completed with errors, (Data could not be saved on Database)!'));
				}

				$this->set(compact('reservation'));

			} catch (PaypalRedirectException $e) {

				$datasource->rollback();

				return $this->redirect($e->getMessage());
			} catch (Exception $e) {

				$datasource->rollback();

				$this->Flash->error(__("Error at DoExpressCheckout: %s.", $e->getMessage()));
				return $this->redirect(array('controller' => 'properties', 'action' => 'view', $reservation['Property']['id']));
			}
		} catch (Exception $e) {
			
			$datasource->rollback();

			$this->Flash->error(__("Error at GetExpressCheckout: %s.", $e->getMessage()));
			return $this->redirect(array('controller' => 'properties', 'action' => 'view', $reservation['Property']['id']));
		}
	}

	/**
	 * return cancel payment
	 * here is the return point if a payment has been canceled
	 *
	 * @return void
	 */
	public function paymentCancel($id = null) {
		if ($id && $this->Property->Reservation->exists($id)) {
			// update Reservation status
			$this->Property->Reservation->id = $id;
			$this->Property->Reservation->saveField('reservation_status', 'payment_error');
		}

		// If cpayment is cancelled from the paypal
		$this->Flash->error(__('Payment could not be processed!'));
	}

	/**
	 * paypalIpn put ipn data retrivet from paypal to a file
	 * @return void
	 */
	public function paymentIpn() {
		$this->layout = null;
		$this->autoRender = false;

		if ($this->request->is('post')) {

			$this->Paypal = new Paypal();

			$verified = $this->Paypal->verifyIPN();

			if ($verified) {
			    /*
			     * Process IPN
			     * A list of variables is available here:
			     * \
			     */
			    $paypal = $_POST;
			    $this->log('POST: ' . print_r($_POST, true), 'paypal');

			    // called statically
			    CakeLog::write('debug', 'POST: ' . print_r($_POST, true));
			    //$logfile = 'ipnlog/' . uniqid() . '.html';
			    //$logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
			    //file_put_contents($logfile, $logdata);
			}
			// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
			header("HTTP/1.1 200 OK");
		}

		$this->Flash->info(__('PayPal IPN log processed!'));
	}

	/**
	 * refresh Subtotal method
	 *
	 * @throws NotFoundException
	 * @param string
	 * @return void
	 */
	public function ajax_refresh_subtotal() {
		$this->layout = null;
		$this->autoRender = false;
		$this->request->allowMethod('ajax');

		$response = array(
			'error' 	=> 0,		// 0 | 1
			'message' 	=> '',
			'available' => false,
			'data' 		=> null
		);

		if (
			!isset($this->request->query['property_id']) ||
			empty($this->request->query['property_id'])
		) {
			$response['available'] = false;
			$response['message'] = __('Property ID is not set. Please refresh the page and try again.');
			return json_encode($response);
		}

		if (
			!isset($this->request->query['checkin']) ||
			!$this->Property->validateDate($this->request->query['checkin'])
		) {
			$response['available'] = false;
			$response['message'] = __('Checkin date is not in the correct format.');
			return json_encode($response);
		}

		if (
			!isset($this->request->query['checkout']) ||
			!$this->Property->validateDate($this->request->query['checkout'])
		) {
			$response['available'] = false;
			$response['message'] = __('Checkout date is not in the correct format.');
			return json_encode($response);
		}

		if (
			!isset($this->request->query['guests']) ||
			(int) $this->request->query['guests'] <= 0
		) {
			$guests = 1;
		} else {
			$guests	= (int) $this->request->query['guests'];
		}

		$property_id = (int) $this->request->query['property_id'];
		$checkin	 = trim($this->request->query['checkin']);
		$checkout	 = trim($this->request->query['checkout']);

		if (!$this->Property->exists($property_id)) {
			$response['available'] = false;
			$response['message'] = __('Invalid Property.');
			return json_encode($response);
		}

		// This is used in case user tries to hack hidden data of the system
		$recalculatedData = $this->__getPrice($property_id, $checkin, $checkout, $guests);

		// return data
		$response['available'] = $recalculatedData['available'];
		$response['message']   = $recalculatedData['message'];
		$response['data'] 	   = $recalculatedData['data'];

		return json_encode($response);
	}

	/**
	 * __getPrice method
	 * Price is calculated as follow:
	 * - 
	 * @throws NotFoundException
	 * @param  int  $property_id
	 * @param  string  $checkin
	 * @param  string  $checkout
	 * @param  integer $guests
	 * @return array
	 */
	public function __getPrice($property_id = null, $checkin = null, $checkout = null, $guests = 1) {

		$response = [
			'available' => false,
			'message' 	=> null,
			'data' 		=> null,
		];

		// we check availability within these dates
		if (!$this->Property->Calendar->checkAvailability($property_id, $checkin, $checkout)) {
			$response['available'] = false;
			$response['message'] = __('These dates are not available. Please select other dates.');
			return $response;
		}

		try {
			$property = $this->Property->find('first', [
				'contain' => array(
					'Price',
					'Currency',
					'SeasonalPrice',
					'Calendar',
					'User',
					'Address',
				),
				'conditions' => array(
					'Property.' . $this->Property->primaryKey => $property_id
				)
			]);
		} catch (Exception $ex) {
			$response['available'] = false;
			$response['message'] = $ex->getMessage();
			return $response;
		}

		$currency_format = Configure::read('Website.currency_position');

		// NUMBER OF DAYS
		$diffDay = abs(strtotime($checkout) - strtotime($checkin));
		$days 	 = ceil($diffDay/(86400));
		if ($days <= 0) {
			$days = 1;
		}

		// Site fee
		$general_fee 		= 0;
		$general_fee_type 	= 'flat';

		$refundable_fee 	= 0;
		$refundable_fee_type= 'flat';

		App::uses('SiteSetting', 'Model');
		$SiteSetting = new SiteSetting();
		$generalSiteSetting = $SiteSetting->getSiteSetting('SITE_FEE');
		if (!empty($generalSiteSetting)) {
			$general_fee 		= $generalSiteSetting['SiteSetting']['general_fee'];
			$general_fee_type 	= $generalSiteSetting['SiteSetting']['general_fee_type'];
			// $refundable_fee 	= $generalSiteSetting['SiteSetting']['refundable_fee'];
			// $refundable_fee_type= $generalSiteSetting['SiteSetting']['refundable_fee_type'];
		}

		$capacity		  = (int) $property['Property']['capacity'];
		$per_night		  = (float) $property['Property']['price'];
		$startingPrice	  = $per_night;

		$localeCurrency   = $this->Property->Currency->getLocalCurrency();
		$defaultCurrency  = $this->Property->Currency->getDefaultCurrencyCode();
		$propertyCurrency = $defaultCurrency;
		if (isset($property['Currency']['code']) && !empty($property['Currency']['code']) && trim($property['Currency']['code'])!='') {
		   $propertyCurrency = trim($property['Currency']['code']);
		}

		// check if number of guests is grater then capaticy
		if ($guests > $capacity) {
			$response['available'] = false;
			$response['message'] = __('Maximum of %d guest(s) allowed.', $capacity);
			return $response;
		}

		// check if days are less then min day
		if ($days < $property['Property']['minimum_days']) {
			$response['available'] = false;
			$response['message'] = __('Minimum days allowed to book is: %d', $property['Property']['minimum_days']);
			return $response;
		}

		// check if maximum days is set and if days is grater than that
		if (!empty($property['Property']['maximum_days'])) {
			if ($days > $property['Property']['maximum_days']) {
				$response['available'] = false;
				$response['message'] = __('Maximum days allowed to book is: %d', $property['Property']['maximum_days']);
				return $response;
			}
		}

		// additional prices
		$extra_price = $property['Price'];

		if (isset($extra_price['cleaning'])) {
			$cleaning = $extra_price['cleaning'];
		} else {
			$cleaning = 0;
		}

		if (isset($extra_price['security_deposit'])) {
			$security = $extra_price['security_deposit'];
		} else {
			$security = 0;
		}

		if (isset($extra_price['guests'])) {
			$guest_count = (int) $extra_price['guests'];
		} else {
			$guest_count = 0;
		}

		if (isset($extra_price['addguests']) && !empty($extra_price['addguests'])) {
			$addguests_price = $extra_price['addguests'];
		} else {
			$addguests_price = 0;
		}

		if (!empty($property['Property']['price']) && $property['Property']['price']>0) {
			$price = $property['Property']['price'];
		} else {
			$price = 0;
		}

		if (!empty($property['Property']['weekly_price']) && $property['Property']['weekly_price']>0) {
			$Wprice = $property['Property']['weekly_price'];
		} else {
			$Wprice = 0;
		}

		if (!empty($property['Property']['monthly_price']) && $property['Property']['monthly_price']>0) {
			$Mprice = $property['Property']['monthly_price'];
		} else {
			$Mprice = 0;
		}

		// // property related data if needed
		// $data['property_currency'] 		= $property['Currency'];
		// $data['property_id'] 			= $property['Property']['id'];
		// $data['property_user_id'] 		= $property['Property']['user_id'];
		// $data['property_price']			= $property['Property']['price'];
		// $data['property_weekly_price']	= $property['Property']['weekly_price'];
		// $data['property_monthly_price']	= $property['Property']['monthly_price'];
		// $data['property_price_converted'] = $property['Property']['price_converted'];
		// $data['property_type_formated'] = $property['Property']['type_formated'];
		// $data['property_capacity'] 		= $property['Property']['capacity'];
		// $data['property_minimum_days'] 	= $property['Property']['minimum_days'];
		// $data['property_maximum_days'] 	= $property['Property']['maximum_days'];
		// $data['allow_instant_booking']	= (bool)$property['Property']['allow_instant_booking'];

		// booking relation data
		$data['property_id'] = $property_id;
		$data['checkin']  = $checkin;
		$data['checkout'] = $checkout;
		$data['guests']   = $guests;
		$data['days']     = $days;

		// site fee
		$data['general_fee'] 		= $general_fee;
		$data['general_fee_type'] 	= $general_fee_type;
		$data['refundable_fee'] 	= $refundable_fee;
		$data['refundable_fee_type'] = $refundable_fee_type;

		// other aditional prices
		// $data['additional_price'] = $extra_price;

		$data['default_currency'] = $defaultCurrency;
		$data['locale_currency']  = $localeCurrency;
		$symbol = $this->Property->Currency->findCurrencySymbolByCode($localeCurrency);

		// //check admin premium condition and apply so for
		// $results = $this->Property->query('select * from paymode where id=2 limit 1');
		// $paymode = $results[0]['paymode'];
		// $data['paymode'] = $paymode;

		//set default to 0
		$data['service_fee'] = 0;
		$data['security_fee'] = 0;
		$data['cleaning_fee'] = 0;

		//Seasonal Price
		$start_date  = $checkin;
		//1. Store all the dates between checkin and checkout in an array
		// $checkin_time		= get_gmt_time(strtotime($start_date));
		// $checkout_time		= get_gmt_time(strtotime($checkout));
		$checkin_time	 = strtotime($start_date);
		$checkout_time	 = strtotime($checkout);
		$travel_dates	 = array();
		$seasonal_prices = array();
		$total_nights	 = 1;
		$total_price	 = 0;
		$is_seasonal	 = false;

		while ($checkin_time < $checkout_time) {
			$travel_dates[$total_nights] = date('Y-m-d', $checkin_time);
			$checkin_time				 = strtotime('+1 day', $checkin_time);
			$total_nights++;
		}


		for ($i=1; $i<$total_nights; $i++) {
			$seasonal_prices[$travel_dates[$i]] = null;
		}

		//Store seasonal price of a list in an array
		if (!empty($property['SeasonalPrice'])) {
			// grab all days of seasonal prices
			foreach ($property['SeasonalPrice'] as $time) {
				//Get Seasonal price
				$seasonalprice = $time['price'];

				// as was on DPIN not quite right in my opionion
				// $sesonalQuery = $this->Property->SeasonalPrice->find('first', array(
				// 	'conditions' => array(
				// 		'SeasonalPrice.property_id' => $property_id,
				// 		'SeasonalPrice.start_date' => $time['start_date'],
				// 		'SeasonalPrice.end_date' => $time['end_date']
				// 	)
				// ));

				//Days between start date and end date -> seasonal price
				$start_time	= strtotime($time['start_date']);
				$end_time	= strtotime($time['end_date']);
				while($start_time<=$end_time) {
					$s_date					  = date('Y-m-d',$start_time);
					$seasonal_prices[$s_date] = $seasonalprice;
					$start_time				  = strtotime('+1 day',$start_time);
				}
			}

			//Total Price
			for ($i=1; $i<$total_nights; $i++) {
				if ($seasonal_prices[$travel_dates[$i]] == "") {
					$total_price = $total_price+$price;
				} else {
					$total_price = $total_price+$seasonal_prices[$travel_dates[$i]];
					$is_seasonal = true;
				}
			}

			// subtotal price
			$data['subtotal_price'] = $total_price;
			$data['subtotal_price_per_night'] = round(floatval($total_price / $days), 2);

			//Additional Guests
			if ($guests > $guest_count) {
				$sesonal_days = $total_nights-1;
				$diff_guests = $guests - $guest_count;
				$total_price = $total_price + ($sesonal_days * $addguests_price * $diff_guests);
				$extra_guest = 1;
				$extra_guest_price = ($addguests_price*$diff_guests); // price for one extra guest for one day
			}

			//Cleaning
			if ($cleaning != 0) {
				$data['cleaning_fee'] = $cleaning;
				$total_price = $total_price + $cleaning;
			}

			// security deposit
			if ($security != 0) {
				$data['security_fee'] = $security;
				$total_price = $total_price + $security;
			}

			// //Admin service_fee
			// $data['service_fee'] = 0;
			// if($paymode['is_premium'] == 1) {
			// 	if($paymode['is_fixed'] == 1) {
			// 		$fix                = $paymode['fixed_amount'];
			// 		$amt                = $total_price + $fix;
			// 		$data['service_fee'] = $fix;
			// 	} else {
			// 		$per                = $paymode['percentage_amount'];
			// 		$camt               = floatval(($total_price * $per) / 100);
			// 		$amt                = $total_price + $camt;
			// 		$data['service_fee'] = $camt;
			// 	}
			// }

			// general fee
			$data['service_fee'] = 0;
			if ($general_fee_type === 'flat') {
				$fix 				 = $general_fee;
				$amt 				 = $total_price + $fix;
				$data['service_fee'] = $fix;
				$Fprice				 = $amt;
			} else {
				$per 				 = $general_fee;
				$camt 				 = round(floatval(($total_price * $per) / 100), 2);
				$amt 				 = $total_price + $camt;
				$data['service_fee'] = $camt;
				$Fprice				 = $amt;
			}

			// after we apply the commition we recalculate week and month price
			// as part of statistics
			if ($Wprice == 0) {
				$data['Wprice']  = $price * self::WEEK;
			} else {
				$data['Wprice']  = $Wprice;
			}

			if ($Mprice == 0) {
				$data['Mprice']  = $price * self::MONTH;
			} else {
				$data['Mprice']  = $Mprice;
			}
		}

		if ($is_seasonal === true) {
			// Total days
			// // they have been inicialised above on the begining of script
			// $days = $total_nights - 1;

			//Final price
			$data['price'] = $total_price;
		} else  {

			if (isset($property['Calendar']['calendar_data']) && !empty($property['Calendar']['calendar_data'])) {
				$decoded = json_decode($property['Calendar']['calendar_data'], true);

				// we check calendar if we have modified dates
				if ($this->Property->Calendar->isModified($property_id, $checkin, $checkout, $per_night)) {
					$calculatePrice = 0;
					$checkout_time	= strtotime($checkout);
					while (strtotime($start_date) < $checkout_time) {
						if (isset($decoded[$start_date])) {
							if (trim($decoded[$start_date]['price']) !='' && ($decoded[$start_date]['price'] != $per_night) && $decoded[$start_date]['price']>0) {
								$calculatePrice += $decoded[$start_date]['price'];
							} else {
								$calculatePrice += $startingPrice;
							}
						} else {
							$calculatePrice += $startingPrice;
						}

						$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
					}
					$price = $calculatePrice;
				} else {
					$price = $price * $days;
				}
			} else {
				$price = $price * $days;
			}

			// subtotal price with the property currency
			$data['subtotal_price'] = $price;
			$data['subtotal_price_per_night'] = round(($price / $days), 2);

			// adding price for each Additional guests
			if ($guests > $guest_count) {
				$additional_guest = $guests - $guest_count;
				$price     = $price + ($days * $addguests_price * $additional_guest);
				$extra_guest = 1;
				$extra_guest_price = ($addguests_price * $additional_guest);
			}

			if ($Wprice == 0) {
				$data['Wprice']  = $price * self::WEEK;
			} else {
				$data['Wprice']  = $Wprice;
			}

			if ($Mprice == 0) {
				$data['Mprice']  = $price * self::MONTH;
			} else {
				$data['Mprice']  = $Mprice;
			}

			if ($days >= self::WEEK && $days < self::MONTH) {
				if (!empty($Wprice)) {
					$finalAmount     = $Wprice;
					$differNights    = $days - self::WEEK;
					$perDay          = $Wprice / self::WEEK;
					$per_night       = round($perDay, 2);
					if ($differNights > 0) {
						$addAmount     = $differNights * $per_night;
						$finalAmount   = $Wprice + $addAmount;
					}

					$price = $finalAmount;

					// add to price the Additional guests amount
					if ($guests > $guest_count) {
						$additional_guest = $guests - $guest_count;
						$price     = $price + ($days * $addguests_price * $additional_guest);
						$extra_guest = 1;
						$extra_guest_price = ($addguests_price * $additional_guest);
					}
				}
			}

			if ($days >= self::MONTH) {
				if(!empty($Mprice))	{
					$finalAmount     = $Mprice;
					$differNights    = $days - self::MONTH;
					$perDay          = $Mprice / self::MONTH;
					$per_night       = round($perDay, 2);
					if ($differNights > 0) {
						$addAmount     = $differNights * $per_night;
						$finalAmount   = $Mprice + $addAmount;
					}
					$price = $finalAmount;

					// add to price the Additional guests amount
					if($guests > $guest_count){
						$additional_guest = $guests - $guest_count;
						$price     = $price + ($days * $addguests_price * $additional_guest);
						$extra_guest = 1;
						$extra_guest_price = ($addguests_price * $additional_guest);
					}
				}
			}

			// // paymode fee
			// if($paymode['is_premium'] == 1) {
			// 	if($paymode['is_fixed'] == 1) {
			// 		$fix                = $paymode['fixed_amount'];
			// 		$amt                = $price + $fix;
			// 		$data['service_fee'] = $fix;
			// 		$Fprice             = $amt;
			// 	} else {
			// 		$per                = $paymode['percentage_amount'];
			// 		$camt               = floatval(($price * $per) / 100);
			// 		$amt                = $price + $camt;
			// 		$data['service_fee'] = $camt;
			// 		$Fprice             = $amt;
			// 	}

			// 	if ($Wprice == 0) {
			// 		$data['Wprice']  = $price * self::WEEK;
			// 	} else {
			// 		$data['Wprice']  = $Wprice;
			// 	}

			// 	if ($Mprice == 0) {
			// 		$data['Mprice']  = $price * self::MONTH;
			// 	} else {
			// 		$data['Mprice']  = $Mprice;
			// 	}
			// }

			// general fee
			$data['service_fee'] = 0;
			if (trim($general_fee_type) === 'flat') {
				$fix 				 = $general_fee;
				$amt 				 = $price + $fix;
				$data['service_fee'] = $fix;
				$Fprice				 = $amt;
			} else {
				$per 				 = $general_fee;
				$camt 				 = round(floatval(($price * $per) / 100), 2);
				$amt 				 = $price + $camt;
				$data['service_fee'] = $camt;
				$Fprice 			 = $amt;
			}

			// after we apply the commition we recalculate the price
			if ($Wprice == 0) {
				$data['Wprice']  = $price * self::WEEK;
			} else {
				$data['Wprice']  = $Wprice;
			}

			if ($Mprice == 0) {
				$data['Mprice']  = $price * self::MONTH;
			} else {
				$data['Mprice']  = $Mprice;
			}

			// $price = $Fprice;

			//cleaning
			if ($cleaning != 0) {
				$data['cleaning_fee'] = $cleaning;
				$price = $price + $cleaning;
			}

			// security deposit
			if ($security != 0) {
				$data['security_fee'] = $security;
				$price = $price + $security;
			}

			$data['price'] = $price;
		}

		$data['price_per_night'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $per_night, 1, 4);
		$data['subtotal_price'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['subtotal_price'], 1, 4);
		$data['subtotal_price_per_night'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['subtotal_price_per_night'], 1, 4);

		$data['cleaning_fee'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['cleaning_fee'], 1, 4);
		$data['security_fee'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['security_fee'], 1, 4);
		$data['service_fee'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['service_fee'], 1, 4);

		$data['Wprice'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['Wprice'], 1, 4);
		$data['Mprice'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['Mprice'], 1, 4);

		# this is the price including all the fees, except the service fee of the portal
		$data['price'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $data['price'], 1, 4);

		// here we convert the booking price to local currency //price or subtotal_price
		$data['avarage_price_per_night'] = ($data['price'] / $days);

		$data['extra_guest'] = false;
		$data['extra_guest_price'] = 0;
		$data['extra_guest_price_html'] = '';
		if (isset($extra_guest) && (int)$extra_guest == 1) {
			$data['extra_guest'] = true;
			$data['extra_guest_price'] = $this->CurrencyConverter->convert($propertyCurrency, $localeCurrency, $extra_guest_price, 1, 4);
			$data['extra_guest_price_html'] = EMCMS_priceHtml($currency_format, $symbol, $data['extra_guest_price']);
		}

		// calculate the total price of the reservation
		$totPrice = (double)$data['price'] + (double)$data['service_fee'];
		$data['total_price'] = $totPrice;

		# Now we add Price HTML.
		$data['subtotal_price_html'] = EMCMS_priceHtml($currency_format, $symbol, $data['subtotal_price']);
		$data['subtotal_price_per_night_html'] = EMCMS_priceHtml($currency_format, $symbol, $data['subtotal_price_per_night']);
		$data['avarage_price_per_night_html']  = EMCMS_priceHtml($currency_format, $symbol, $data['avarage_price_per_night']);
		$data['cleaning_fee_html'] = EMCMS_priceHtml($currency_format, $symbol, $data['cleaning_fee']);
		$data['security_fee_html'] = EMCMS_priceHtml($currency_format, $symbol, $data['security_fee']);
		$data['service_fee_html'] = EMCMS_priceHtml($currency_format, $symbol, $data['service_fee']);
		$data['total_price_html'] = EMCMS_priceHtml($currency_format, $symbol, $data['total_price']);

		#local currency symbl
		$data['locale_currency_symbol'] = $symbol;

		// this is used if we want to check booking amount
		$data['check_amount'] = $this->CurrencyConverter->convert($localeCurrency, $defaultCurrency, $data['total_price'], 1, 4);
		$data['check_amount_currency'] = $defaultCurrency;

		// return data
		$response['available'] = true;
		$response['data'] 	   = $data;

		return $response;
	}

////////////////////////////////////////////////////////////////////////////////////
/**
 * User area.
 *
 * @since 1.0.0
 * @file User panel for properties
 * @support <http://www.erlandmuchasaj.com>
 * @email  <erland.muchasaj@gmail.com>
 * @author EMCMS rentals <Erland Muchasaj>
 * @license MIT <http://opensource.org/licenses/MIT>
 */
////////////////////////////////////////////////////////////////////////////////////

	/**
	 * index method
	 *
	 * @return void
	 */
	public function listings($search = null) {

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if ($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = array(
			'Property.deleted' => null,
			'Property.user_id' => $this->Auth->user('id')
		);

		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'listings', $this->request->data['Property']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array(
				'Property.address LIKE' => '%' . $search . '%',
				'PropertyTranslation.title LIKE' => '%' . $search . '%',
				'PropertyTranslation.description LIKE' => '%' . $search . '%'
			);
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		$this->Property->unbindModel(array(
			'hasMany' => array('PropertyTranslation')
		));

		$this->Property->bindModel(array(
			'hasOne' => array(
				'PropertyTranslation' => array(
					'foreignKey' => 'property_id',
					'conditions' => array(
						'PropertyTranslation.property_id = Property.id',
						'PropertyTranslation.language_id' => $language_id
					),
					'className' => 'PropertyTranslation'
				),
			),
		));

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Property.sort' => 'ASC'),
			'contain' => array(
				'PropertyTranslation',
				'User',
			),
			'maxLimit' => 100,
			'paramType' => 'querystring'
			// 'recursive' => 1
		);

		$properties = $this->Paginator->paginate();
		$this->set(compact('properties', 'search'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {

		$this->helpers[] = 'Froala.Froala';

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		if (!$this->Property->User->canAddProperty($this->Auth->user('id'))) {
			$this->Flash->error(__('You can not add more then 5 Properties. Please upgrade your account to agency in order to proceed.'));
			return $this->redirect(array('action'=>'index'));
		}

		if ($this->request->is('post')) {
			$this->Property->create();
			$this->request->data['Property']['user_id'] = $this->Auth->user('id');

			/**
			 * Here we can grab default language and dublicate 
			 * to all the fields if they are emtpy
			 */
			$id_lang_default = $this->Property->PropertyTranslation->Language->getDefaultLanguageId();
			$defaultTitle = $defaultDescription = $defaultLocationdesc = $defaultSeoTitle = $defaultSeoDescription = '';
			if (isset($this->request->data['PropertyTranslation'][$id_lang_default])) {
				$defaultTitle = $this->request->data['PropertyTranslation'][$id_lang_default]['title'];
				$defaultDescription = $this->request->data['PropertyTranslation'][$id_lang_default]['description'];
				$defaultLocationdesc = $this->request->data['PropertyTranslation'][$id_lang_default]['location_description'];
				$defaultSeoTitle = $this->request->data['PropertyTranslation'][$id_lang_default]['seo_title'];
				$defaultSeoDescription = $this->request->data['PropertyTranslation'][$id_lang_default]['seo_description'];
			}
			foreach ($this->request->data['PropertyTranslation'] as $id_lang => &$propTrans) {
				if (empty($propTrans['title'])) {
					$propTrans['title'] = $defaultTitle;
				}

				if (empty($propTrans['description'])) {
					$propTrans['description'] = $defaultDescription;
				}

				if (empty($propTrans['location_description'])) {
					$propTrans['location_description'] = $defaultLocationdesc;
				}

				if (empty($propTrans['seo_title'])) {
					$propTrans['seo_title'] = $defaultSeoTitle;
				}

				if (empty($propTrans['seo_description'])) {
					$propTrans['seo_description'] = $defaultSeoDescription;
				}
			}
			unset($propTrans);


			# Populate Prices
			$this->request->data['Price']['model']    = $this->Property->alias;
			$this->request->data['Price']['night']    = $this->request->data['Property']['price'];
			$this->request->data['Price']['week']     = $this->request->data['Property']['weekly_price'];
			$this->request->data['Price']['month']    = $this->request->data['Property']['monthly_price'];
			$this->request->data['Price']['currency'] = $this->Property->Currency->findCurrencyCodeById((int)$this->request->data['Property']['currency_id']);

			if ($this->Property->saveAll($this->request->data, ['validate'=>'first', 'deep' => true])) {
				$viewVars = array();
				$message  = "\n".__('Hello %s, thank you for using our portal.', $this->Auth->user('name'));
				$message .= "\n".__('Your property has been added successfully. We will review your property and it will be listed within 24 hours.');
				$message .= "\n".__('Thanks and Regards,');
				$message .= "\n".__('%s Team.', h(Configure::read('Website.name')));
				$message .= "\n";
				$optionsEmail = array(
					'viewVars' => $viewVars,		 // variables passed to the view
					'subject' => __('New Property'), // email subject,
					'content' => $message
				);
				parent::__sendMail($this->Auth->user('email'), $optionsEmail);

				$this->Flash->success(__('The property has been saved.'));
				return $this->redirect(array('controller' => 'properties', 'action' => 'edit', $this->Property->getLastInsertId(), '?' => ['step_num' => 2]));
			} else {
				$this->Flash->error(__('The property could not be saved. Please, try again.'));
			}
		}

		$currencies = $this->Property->Currency->find('list',array('conditions' => array('Currency.status'=>1), 'order' => array('Currency.id ASC')));

		$languages = $this->Property->PropertyTranslation->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));

		$cancellationPolicies = $this->Property->CancellationPolicy->find('list',array('order' => array('CancellationPolicy.id ASC')));

		$roomTypes = $this->Property->RoomType->find('list',
			array(
				'conditions' => array('RoomType.language_id' => $language_id),
				'fields' => array('RoomType.room_type_id', 'RoomType.room_type_name'),
				'recursive'=>-1
			)
		);
		$accommodationTypes = $this->Property->AccommodationType->find('list',
			array(
				'conditions' => array('AccommodationType.language_id' => $language_id),
				'fields' => array('AccommodationType.accommodation_type_id', 'AccommodationType.accommodation_type_name'),
				'recursive'=>-1
			)
		);
		$AllCharacteristics = $this->Property->Characteristic->find('all', array(
			'joins' => array(
				array(
					'table' => 'characteristic_translations',
					'alias' => 'CharacteristicTranslation',
					'type' => 'LEFT',
					'conditions' => array(
						'CharacteristicTranslation.characteristic_id = Characteristic.id',
						'CharacteristicTranslation.language_id' => $language_id
					)
				)
			),
			'fields' => array(
				'CharacteristicTranslation.id',
				'CharacteristicTranslation.characteristic_name',
				'Characteristic.icon_class'
			),
			'recursive' => 0
		));
		$AllSafeties = $this->Property->Safety->find('all', array(
			'joins' => array(
				array(
					'table' => 'safety_translations',
					'alias' => 'SafetyTranslation',
					'type' => 'LEFT',
					'conditions' => array(
						'SafetyTranslation.safety_id = Safety.id',
						'SafetyTranslation.language_id' => $language_id
					)
				)
			),
			'fields' => array(
				'SafetyTranslation.id',
				'SafetyTranslation.safety_name',
				'Safety.icon_class'
			),
			'recursive' => 0
		));

		$this->set(
			compact(
				'currencies', 'languages',
				'cancellationPolicies', 'roomTypes', 'accommodationTypes',
				'AllCharacteristics', 'AllSafeties'
			)
		);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->helpers[] = 'Froala.Froala';

		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__('Invalid property'));
		}

		if ($this->Property->isDeleted($id)) {
			throw new NotFoundException(__('Invalid property'));
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		if ($this->request->is(array('post', 'put'))) {

			if (isset($this->request->data['Property']['image_caption'])) {
				unset($this->Property->validate['image_caption']);
				unset($this->request->data['Property']['image_caption']);
			}

			# Populate Prices
			$this->request->data['Price']['model_id'] = $id;
			$this->request->data['Price']['model']    = $this->Property->alias;
			$this->request->data['Price']['night']    = $this->request->data['Property']['price'];
			$this->request->data['Price']['week']     = $this->request->data['Property']['weekly_price'];
			$this->request->data['Price']['month']    = $this->request->data['Property']['monthly_price'];
			$this->request->data['Price']['currency'] = $this->Property->Currency->findCurrencyCodeById((int)$this->request->data['Property']['currency_id']);

			if ($this->Property->saveAll($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The property has been updated.'));
				return $this->redirect(array('controller' => 'properties', 'action' => 'listings'));
			} else {
				$this->Flash->error(__('The property could not be updated. Please, try again.'));
			}
		} else {

			$this->request->data = $this->Property->find('first', array(
				'contain' => array(
					'Characteristic',
					'Safety',
					'PropertyPicture',
					'Calendar',
					'Currency',
					'Price',
					'Address',
					'PropertyTranslation.Language',
				),
				'conditions' => array(
					'Property.'.$this->Property->primaryKey => $id,
					'Property.user_id' => $this->Auth->user('id'),
					'Property.deleted' => null,
				)
			));
		}

		$currencies = $this->Property->Currency->find('list',array('conditions' => array('Currency.status'=>1),'order' => array('Currency.id ASC')));

		$languages = $this->Property->PropertyTranslation->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));

		$cancellationPolicies = $this->Property->CancellationPolicy->find('list',array('order' => array('CancellationPolicy.id ASC')));

		$roomTypes = $this->Property->RoomType->find('list',
			array(
				'conditions' => array('RoomType.language_id'=>$language_id),
				'fields' => array('RoomType.room_type_id', 'RoomType.room_type_name'),
				'recursive'=>-1
			)
		);
		$accommodationTypes = $this->Property->AccommodationType->find('list',
			array(
				'conditions' => array('AccommodationType.language_id'=>$language_id),
				'fields' => array('AccommodationType.accommodation_type_id', 'AccommodationType.accommodation_type_name'),
				'recursive'=>-1
			)
		);
		$AllCharacteristics = $this->Property->Characteristic->find('all', array(
			'joins' => array(
				array(
					'table' => 'characteristic_translations',
					'alias' => 'CharacteristicTranslation',
					'type' => 'LEFT',
					'conditions' => array(
						'CharacteristicTranslation.characteristic_id = Characteristic.id',
						'CharacteristicTranslation.language_id' => $language_id
					)
				)
			),
			'fields' => array(
				'CharacteristicTranslation.id',
				'CharacteristicTranslation.characteristic_name',
				'Characteristic.icon_class'
			),
			'recursive' => 0
		));
		$AllSafeties = $this->Property->Safety->find('all', array(
			'joins' => array(
				array(
					'table' => 'safety_translations',
					'alias' => 'SafetyTranslation',
					'type' => 'LEFT',
					'conditions' => array(
						'SafetyTranslation.safety_id = Safety.id',
						'SafetyTranslation.language_id' => $language_id
					)
				)
			),
			'fields' => array('SafetyTranslation.id', 'SafetyTranslation.safety_name', 'Safety.icon_class'),
			'recursive' => 0
		));

		$this->set(
			compact(
				'currencies', 'languages',
				'cancellationPolicies', 'roomTypes', 'accommodationTypes',
				'AllCharacteristics', 'AllSafeties'
			)
		);
	}

	/**
	 * view method
	 *
	 * @return void
	 */
	public function ajax_preview($id = null) {
		if ($this->request->is('ajax')){
			$this->autoRender = false;
			$this->layout = null;
		}

		if (!$id) {
			throw new BadRequestException(__('Property ID is not set. Please refresh the page and try again!'));
		}

		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__('Property that you are trying to access does not exist. Please refresh the page and try again!'));
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);

		$this->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);

		$option = [
			'conditions' => [
				'Property.'.$this->Property->primaryKey => $id,
			],
			'limit' => 1,
			'contain' => [
				'PropertyTranslation',
				'CancellationPolicy',
				'PropertyPicture',
				'Price',
				'User',
				'Currency',
				'Address',
				'Review' => [
					'UserBy'
				],
			],
		];
		$property = $this->Property->find('first', $option);

		$this->set('property', $property);
		$this->render('admin_view', 'ajax');
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$this->request->allowMethod('post', 'delete');

		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__('Invalid property'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Property->updateAll(['Property.deleted' => 'NOW()'],['Property.' . $this->Property->primaryKey => $id])) {
				$response['type'] = 'success';
				$response['message'] = __('Property has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Property could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} else {
			if ($this->Property->updateAll(['Property.deleted' => 'NOW()'],['Property.' . $this->Property->primaryKey => $id])) {
				$this->Flash->success(__('Property has been deleted.'));
			} else {
				$this->Flash->error(__('Property could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'listings'));
		}
	}

	/**
	 * load Calendar
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function loadCalendar($id = null) {
		$this->autoRender = false;
		$this->request->allowMethod('ajax');
		if ($this->Property->Calendar->exists($id)) {
			// If calendar ID is received.
			// Select and show the data from the database.
			$calendar = $this->Property->Calendar->find('first', array('conditions' => array('Calendar.property_id'=>$id)));
			if (isset($calendar['Calendar']['calendar_data']) && !empty($calendar['Calendar']['calendar_data'])) {
				echo $calendar['Calendar']['calendar_data'];
				exit;
			}
		}
	}

	/**
	 * save Calendar
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function saveCalendar($id = null) {
		$this->autoRender = false;
		$this->request->allowMethod('ajax');

		if (!$id) {
			throw new NotFoundException(__('Invalid property'));
		}

		if (isset($this->request->data['calendar_data']) && !empty($this->request->data['calendar_data'])) {
			$data = array();
			$data['Calendar']['id'] = $id;
			$data['Calendar']['property_id'] = $id;
			$data['Calendar']['calendar_data'] = trim($this->request->data['calendar_data']);
			if ($this->Property->Calendar->exists($id)) {
				$this->Property->Calendar->save($data, false);
			} else {
				$this->Property->Calendar->create();
				$this->Property->Calendar->save($data, false);
			}
		}
	}

////////////////////////////////////////////////////////////////////////////////////
/**
 * Admin area of users.
 *
 * Some example:
 * @code
 * ...
 * @endcode
 *
 * @since 1.0.0
 * @file Admin panel for properties
 * @author EMCMS rentals
 */
////////////////////////////////////////////////////////////////////////////////////

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index($search = null) {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if ($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = array(
			'Property.deleted' => null,
			'Property.is_approved' => 1
		);
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'index', $this->request->data['Property']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array(
				'Property.address LIKE' => '%' . $search . '%',
				'PropertyTranslation.title LIKE' => '%' . $search . '%',
				'PropertyTranslation.description LIKE' => '%' . $search . '%'
			);
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);

		$this->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Property.sort' => 'ASC'),
			'contain' => array(
				'PropertyTranslation',
				// 'PropertyPicture',
				'User'
			),
			'maxLimit' => 100,
			'paramType' => 'querystring',
			'recursive' => 0,
		);
		// $this->paginate = array_merge($this->paginate, $this->Paginator->settings);
		// debug($this->paginate);
		$properties = $this->Paginator->paginate();
		$this->set(compact('properties', 'search'));
	}

	/**
	 * view method
	 *
	 * @return void
	 */
	public function admin_view($id = null) {
		if ($this->request->is('ajax')){
			$this->autoRender = false;
			$this->layout = null;
		}

		if (!$id) {
			throw new BadRequestException(__('Property ID is not set. Please refresh the page and try again!'));
		}

		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__('Property that you are trying to access does not exist. Please refresh the page and try again!'));
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);

		$option = [
			'conditions' => [
				'Property.id' => $id,
			],
			'limit' => 1,
			'contain' => [
				'PropertyTranslation',
				'PropertyPicture',
				'User',
				'Price',
				'Address',
				'Currency',
				'Review' => [
					'UserBy',
				],
			],
		];

		$this->set('property', $this->Property->find('first', $option));

		if ($this->request->is('ajax')){
			$this->render('admin_view', 'ajax');
		}
	}

	/**
	 * waiting Approval method
	 *
	 * @return void
	 */
	public function admin_waiting_approval() {
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if ($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		$this->Property->unbindModel([
			'hasMany'=>['PropertyTranslation']
		]);
		$this->Property->bindModel([
			'hasOne' => [
				'PropertyTranslation' => [
				    'foreignKey' => 'property_id',
				    'conditions' => [
				    	'PropertyTranslation.property_id = Property.id',
				    	'PropertyTranslation.language_id' => $language_id
				    ],
				    'className' => 'PropertyTranslation'
				],
			],
		]);

		$conditions = array(
			'Property.deleted' => null,
			'Property.is_approved' => 0
		);
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Property.sort' => 'ASC'),
			'contain' => array(
				'PropertyTranslation',
				'User'
			),
			'maxLimit' => 100,
			'paramType' => 'querystring'
		);
		$properties = $this->Paginator->paginate();
		$this->set(compact('properties'));
	}

	/**
	 * edit method for admin
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->helpers[] = 'Froala.Froala';
		$language_id = $this->Property->PropertyTranslation->Language->getActiveLanguageId();

		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__('Invalid property'));
		}

		if ($this->Property->isDeleted($id)) {
			throw new NotFoundException(__('Invalid property'));
		}


		if ($this->request->is(array('post', 'put'))) {

			$errors = [];
			if (!empty($this->request->data['Address'])) {
				if (
					$this->Property->Address->Country->isNeedDniByCountryId($this->request->data['Address']['country_id']) &&
					!$this->request->data['Address']['dni']
				) {
					$this->Property->Address->invalidate('dni', __('The identification number is incorrect or has already been used.'));
					$errors[] = __('The identification number is incorrect or has already been used.');
				}

				/* If the selected country does not contain states */
				$id_state =  isset($this->request->data['Address']['state_id']) ? $this->request->data['Address']['state_id'] : null;
				$id_country = (int) $this->request->data['Address']['country_id'];
				$country = $this->Property->Address->Country->find('first', array(
				    'conditions' => array('Country.id' => $id_country)
				));

				if (!$country) {
					$this->Flash->error(__('The property could not be updated. Country specified was not found. Please, try again.'));
					$this->redirect($this->referer());
				}

				$country = $country['Country'];
				if (!(int)$country['contains_states'] && $id_state) {
					$this->Property->Address->invalidate('country_id', __('You have selected a state for a country that does not contain states.'));
				    $errors[] = __('You have selected a state for a country that does not contain states.');
				}

				/* If the selected country contains states, then a state have to be selected */
				if ((int)$country['contains_states'] && !$id_state) {
					$this->Property->Address->invalidate('state_id', __('An address located in a country containing states must have a state selected.'));
				    $errors[] = __('An address located in a country containing states must have a state selected.');
				}

				$postcode = $this->request->data['Address']['postal_code'];
				/* Check zip code format */
				if ($country['zip_code_format'] && !$this->Property->Address->Country->checkZipCode($postcode, $country)) {
				    $errors[] = __('Your Zip/postal code is incorrect. It must be entered as follows:').' '.str_replace('C', $country['iso_code'], str_replace('N', '0', str_replace('L', 'A', $country['zip_code_format'])));
				} elseif (empty($postcode) && $country['need_zip_code']) {
				    $errors[] = __('A Zip/postal code is required.');
				} elseif ($postcode && !$this->Property->Address->Country->isPostCode($postcode)) {
				    $errors[] = __('The Zip/postal code is invalid.');
				}

				if (count($errors)) {
					$this->Property->Address->invalidate('postal_code', __('The Zip/postal code is invalid.'));
					$this->Flash->error(implode("\n", $errors));
					$this->redirect($this->referer());
				}
	        }

	        # Populate Prices
	        $this->request->data['Price']['model_id'] = $id;
	        $this->request->data['Price']['model']    = $this->Property->alias;
	        $this->request->data['Price']['night']    = $this->request->data['Property']['price'];
	        $this->request->data['Price']['week']     = $this->request->data['Property']['weekly_price'];
	        $this->request->data['Price']['month']    = $this->request->data['Property']['monthly_price'];
	        $this->request->data['Price']['currency'] = $this->Property->Currency->findCurrencyCodeById((int)$this->request->data['Property']['currency_id']);

	        // $errors = $this->Property->invalidFields(); // contains validationErrors array
	        // $errors1 = $this->Property->validationErrors;

			if ($this->Property->saveAll($this->request->data, ['validate'=>'first', 'deep' => true])) {
				$this->Flash->success(__('The property has been updated.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The property could not be updated. Please, try again.'));
			}
		}

		$this->request->data = $this->Property->find('first', array(
			'contain' => array(
				'Safety',
				'Characteristic',
				'PropertyPicture',
				'Calendar',
				'Price',
				'Currency',
				'Address',
				'PropertyTranslation.Language',
			),
			'conditions' => [
				'Property.'.$this->Property->primaryKey => $id,
				'Property.deleted' => null,
			],
			'recursive' => 0,
		));

		$currencies = $this->Property->Currency->find('list',array('conditions' => array('Currency.status'=>1),'order' => array('Currency.id ASC')));

		$languages = $this->Property->PropertyTranslation->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));

		$cancellationPolicies = $this->Property->CancellationPolicy->find('list',array('order' => array('CancellationPolicy.id ASC')));

		$countries = $this->Property->Address->Country->find('list', array(
			'fields' => array(
				'Country.id',
				'Country.name'
			),
			'order' => array(
				'Country.name ASC'
			)
		));

		$roomTypes = $this->Property->RoomType->find('list',
			array(
				'conditions' => array('RoomType.language_id'=>$language_id),
				'fields' => array('RoomType.room_type_id', 'RoomType.room_type_name'),
				'recursive'=>-1
			)
		);
		$accommodationTypes = $this->Property->AccommodationType->find('list',
			array(
				'conditions' => array('AccommodationType.language_id'=>$language_id),
				'fields' => array(
					'AccommodationType.accommodation_type_id',
					'AccommodationType.accommodation_type_name'
				),
				'recursive'=>-1
			)
		);
		$AllCharacteristics = $this->Property->Characteristic->find('all', array(
			'joins' => array(
				array(
					'table' => 'characteristic_translations',
					'alias' => 'CharacteristicTranslation',
					'type' => 'LEFT',
					'conditions' => array('Characteristic.id = CharacteristicTranslation.characteristic_id')
				)
			),
			'conditions' => array('CharacteristicTranslation.language_id' => $language_id),
			'fields' => array('CharacteristicTranslation.id', 'CharacteristicTranslation.characteristic_name', 'Characteristic.icon_class'),
			'recursive' => 0
		));
		$AllSafeties = $this->Property->Safety->find('all', array(
			'joins' => array(
				array(
					'table' => 'safety_translations',
					'alias' => 'SafetyTranslation',
					'type' => 'LEFT',
					'conditions' => array('Safety.id = SafetyTranslation.safety_id')
				)
			),
			'conditions' => array('SafetyTranslation.language_id' => $language_id),
			'fields' => array('SafetyTranslation.id', 'SafetyTranslation.safety_name', 'Safety.icon_class'),
			'recursive' => 0
		));

		$this->set(
			compact(
				'currencies', 'countries', 'languages',
				'cancellationPolicies', 'roomTypes', 'accommodationTypes',
				'AllCharacteristics', 'AllSafeties'
			)
		);
	}

	/**
	 * changeStatus method
	 *
	 * @return void
	 */
	public function admin_changeStatus() {
		$this->autoRender = false;
		$this->layout = null;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->Property->save($this->request->data)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed this property status.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Property Status could not be changed. Please Try again!');
		}
		return json_encode($response);
	}

	/**
	 * Sort method
	 *
	 * @return void
	 */
	public function admin_sort() {
		$this->autoRender = false;
		$this->layout = null;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->data['action'] === 'sort'){
			$array = $this->request->data['arrayorder'];
			$count = 1;
			foreach ($array as $idval) {
				$query = " UPDATE properties SET sort={$count} WHERE id={$idval}";
				$this->Property->query($query);
				$count ++;
			}
			$response['type'] = 'success';
			$response['message'] = __('Property sort changed successfully.');
		}
		return json_encode($response);
	}

	/**
	 * feature method
	 *
	 * @return void
	 */
	public function admin_featured($id = null) {
		$this->autoRender = false;
		$this->layout = null;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->is('ajax')) {
			$is_featured = $this->request->data['Property']['is_featured'];
			$query = "UPDATE properties SET is_featured={$is_featured} WHERE id={$id}";
			$this->Property->query($query);
			if ($this->Property->getAffectedRows()) {
				$response['type'] = 'success';
				$response['message'] = __('Property featured status was changed.');
				$response['data'] = $this->request->data;
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Property featured status could not be changed. Please Try again!');
				$response['data'] = $this->request->data;
			}
			return json_encode($response);
		} elseif ($this->request->is(array('post', 'put'))) {
			$this->Property->id = $id;
			if ($this->Property->save($this->request->data)) {
				$this->Flash->success(__('Property featured status was changed.'));
			} else {
				$this->Flash->error(__('Property featured status could not be changed. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * activate method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_approve($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$this->request->allowMethod('post', 'put');

		$this->Property->id = $id;
		if (!$this->Property->exists()) {
			throw new NotFoundException(__('Invalid property'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Property->updateAll(['Property.is_approved' => 1], ['Property.'.$this->Property->primaryKey => $id])) {
				$response['type'] = 'success';
				$response['message'] = __('Property has been accepted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Property could not be accepted. Please Try again!');
			}
			return json_encode($response);
		} else {
			if ($this->Property->updateAll(['Property.is_approved' => 1], ['Property.'.$this->Property->primaryKey => $id])) {
				$this->Flash->success(__('Property has been accepted.'));
			} else {
				$this->Flash->error(__('Property could not be not be accepted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$this->request->allowMethod('post', 'delete');

		$this->Property->id = $id;
		if (!$this->Property->exists()) {
			throw new NotFoundException(__('Invalid property'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Property->updateAll(['Property.deleted' => 'NOW()'], ['Property.'.$this->Property->primaryKey => $id])) {
				$response['type'] = 'success';
				$response['message'] = __('Property has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Property could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} else {

			if ($this->Property->updateAll(['Property.deleted' => 'NOW()'], ['Property.'.$this->Property->primaryKey => $id])) {
				$this->Flash->success(__('Property has been deleted.'));
			} else {
				$this->Flash->error(__('Property could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * deleted properties list
	 *
	 * @return void
	 */
	public function admin_deleted() {
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions =  array(
			'not' => array(
				'Property.deleted' => null
			)
		);

		$this->Paginator->settings =  array(
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Property.deleted' => 'DESC'),
			'contain' => array(
				'User'
			),
			'maxLimit' => 100,
			'paramType' => 'querystring'
		);
		$properties = $this->Paginator->paginate();
		$this->set(compact('properties'));
	}

	/**
	 * delete Property
	 *
	 * @throws NotFoundException
	 * @param array an array send with Ajax
	 * @return int
	 */
	public function admin_deletePropertyAjax() {
		$this->autoRender = false;
		$this->layout = null;
		$this->request->allowMethod('ajax');
		if ($this->request->data['action'] === 'delete') {
			$id = (int) $this->request->data['property_id'];
			$delete_reason = mysqlPrepare($this->request->data['delete_reason']);
			$dataSource = $this->Property->getDataSource();
			if ($this->Property->updateAll([
					'Property.delete_reason'=> $dataSource->value($delete_reason, 'string'),
					'Property.deleted'=>'NOW()'
				], [
					'Property.'.$this->Property->primaryKey => $id
				])
			) {
				echo 1;
			} else {
				echo 0;
			}
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_deletPermanent($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$this->request->allowMethod('post', 'delete');

		if (!$this->Property->exists($id)) {
			throw new NotFoundException(__('Invalid property'));
		}

		if ($this->request->is('ajax')) {

			if ($this->Property->delete($id, true)) {
				$response['type'] = 'success';
				$response['message'] = __('Property has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Property could not be deleted. Please Try again!');
			}

			return json_encode($response);
		} else {

			if ($this->Property->delete($id, true)) {
				$this->Flash->success(__('Property has been permanently deleted.'));
			} else {
				$this->Flash->error(__('Property could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

}
