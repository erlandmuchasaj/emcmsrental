<?php 
App::uses('ClassRegistry', 'Utility');
class AppSchema extends CakeSchema {

	public $connection = 'default';

	public function before($event = array()) {
		$db = ConnectionManager::getDataSource($this->connection);
    	$db->cacheSources = false;
		return true;
	}

	public function after($event = array()) {
		if (isset($event['create'])) {
		    switch ($event['create']) {
		        case 'accommodation_types':
			        // $post = ClassRegistry::init('Post');
			        //    $post->create();
			        //    $post->save(
			        //        array('Post' =>
			        //            array('title' => 'CakePHP Schema Files')
			        //        )
			        //    );
		            break;
		        case 'booktime_policies':
		            break;
		        case 'cancel_my_account_details':
		            break;
		        case 'cancellation_policies':
		            break;
		        case 'categories':
		            break;
		        case 'characteristics':
		            break;
		        case 'characteristic_translations':
		            break;
		        case 'cities':
		            break;
		        case 'city_places':
		            break;
		        case 'countries':
		            break;
		        case 'currencies':
		            break;
		        case 'email_settings':
		            break;
		        case 'email_templates':
		            break;
		        case 'faqs':
		            break;
		        case 'home_sliders':
		            break;
		        case 'host_cancellation_penalies':
		            break;
		        case 'host_cancellation_policies':
		            break;
		        case 'languages':
		            break;
		        case 'pages':
		            break;
		        case 'payment_details':
		            break;
		        case 'payments':
		            break;
		        case 'paymode':
		            break;
		        case 'room_types':
		            break;
		        case 'safeties':
		            break;
				case 'safety_translations':
				    break;
				case 'site_settings':
				    break;
				case 'states':
				    break;
				case 'timezones':
				    break;
				case 'zones':
				    break;	

				default:
				    break;		            
		    }
		}
	}

	public $accommodation_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'accommodation_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'accommodation_type_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'accommodation_type_id', 'language_id'), 'unique' => 1),
			'language_id' => array('column' => array('language_id', 'accommodation_type_name'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $activities = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'model' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'method' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'item_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'item_id' => array('column' => 'item_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $addresses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'model_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'model' => array('type' => 'string', 'null' => false, 'default' => 'Property', 'length' => 32, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'state_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'company' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lastname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'comment' => 'if user_id is present it geather information from that user', 'charset' => 'utf8'),
		'firstname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'comment' => 'if user_id is present it geather information from that user', 'charset' => 'utf8'),
		'address1' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'postal_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'utf8_general_ci', 'comment' => 'postal_code or zip_code', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'locality' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'district' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'province' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,16', 'unsigned' => false, 'comment' => 'google geo location'),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,15', 'unsigned' => false, 'comment' => 'google geo location for google maps'),
		'other' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone_mobile' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vat_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'dni' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 16, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_adress' => array('column' => 'user_id', 'unique' => 0),
			'country_id' => array('column' => 'country_id', 'unique' => 0),
			'state_id' => array('column' => 'state_id', 'unique' => 0),
			'model_name' => array('column' => 'model', 'unique' => 0),
			'model_id' => array('column' => 'model_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $api_credentials = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 25, 'collate' => 'utf8_general_ci', 'comment' => 'client_id', 'charset' => 'utf8'),
		'value' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 25, 'collate' => 'utf8_general_ci', 'comment' => 'xyzabc', 'charset' => 'utf8'),
		'site' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 25, 'collate' => 'utf8_general_ci', 'comment' => 'Fasebook, Twitter, Etc', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $articles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'summary' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tags' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'featured_image' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 560, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'show_frontpage' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'route' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'new_window' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => true, 'default' => 'post', 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comment_status' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0 - logedin users can not comment, 1 users can coment (if logedin)'),
		'comment_count' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'unsigned' => false),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'meta_title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_keywords' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'category_id' => array('column' => 'category_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $attempts = array(
		'id' => array('type' => 'string', 'null' => false, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'expires' => array('type' => 'datetime', 'null' => true, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ip' => array('column' => array('ip', 'action'), 'unique' => 0),
			'expires' => array('column' => 'expires', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $blocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $booktime_policies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'reservation_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cancellation_title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cancellation_content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cleaning_status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'security_status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'additional_status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'property_days_prior_status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'property_days_prior_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_days_prior_percentage' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false),
		'property_before_status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'property_before_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_before_percentage' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_non_refundable_nights' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_after_status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1, 'unsigned' => false),
		'property_after_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_after_percentage' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'is_standard' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'reservation_id' => array('column' => 'reservation_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $calendars = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'unique', 'comment' => 'property to which this calendar is connected or associated t'),
		'calendar_data' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'ThisFileds hold the group of days which we specify, for exam', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table holds the calendar for each property and/or reser')
	);

	public $cancel_my_account_details = array(
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'tell_why_your_leaving' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comment' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 255, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'user_id' => array('column' => 'user_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $cancellation_policies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cancellation_title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cancellation_content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cleaning_status' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'security_status' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'additional_status' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'property_days_prior_status' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'property_days_prior_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_days_prior_percentage' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false),
		'property_before_status' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'property_before_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_before_percentage' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_non_refundable_nights' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_after_status' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'property_after_days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'property_after_percentage' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'is_standard' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'meta_title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_keywords' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $characteristic_translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'characteristic_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'characteristic_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 160, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'This field holds name in different languages for a given cha', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'characteristic_id', 'language_id'), 'unique' => 1),
			'language_id' => array('column' => 'language_id', 'unique' => 0),
			'characteristic_name' => array('column' => 'characteristic_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table holds translation for characteristics table. For ')
	);

	public $characteristics = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'icon' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'icon_class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'Fontawsome or bootstrap glicofont classes ', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table holds property characteristics')
	);

	public $characteristics_properties = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'characteristic_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'property_id', 'characteristic_id'), 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'characteristic_id' => array('column' => 'characteristic_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table holds HABTM relationship between property table a')
	);

	public $cities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'around' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'known' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image_path' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 256, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_home' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $city_places = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'city_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'place_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quote' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'short_description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'long_description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image_path' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lat' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 25, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'lng' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 25, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'city_id' => array('column' => 'city_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $comments = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'article_id' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'author' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'author_email' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'author_url' => array('type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'author_ip' => array('type' => 'string', 'null' => false, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'date_gmt' => array('type' => 'datetime', 'null' => true, 'default' => null, 'key' => 'index'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'karma' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'approved' => array('type' => 'string', 'null' => false, 'default' => '1', 'length' => 20, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'agent' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'parent' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'article_id' => array('column' => 'article_id', 'unique' => 0),
			'approved_date_gmt' => array('column' => array('approved', 'date_gmt'), 'unique' => 0),
			'date_gmt' => array('column' => 'date_gmt', 'unique' => 0),
			'parent' => array('column' => 'parent', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $contacts = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'collate' => 'utf8_general_ci', 'comment' => 'contact email address', 'charset' => 'utf8'),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'Contact subject', 'charset' => 'utf8'),
		'message' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8_general_ci', 'comment' => 'the text submited to our site ', 'charset' => 'utf8'),
		'is_read' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'type' => array('type' => 'string', 'null' => false, 'default' => 'Contact Us', 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'default type of form submit, depending on the page view used may be newsletter etc', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'the date that contact form has been submited'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $countries = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'zone_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'currency_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'iso_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'EX: ita', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => 'EX: Italy', 'charset' => 'utf8'),
		'phonecode' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false, 'comment' => 'EX: for italy is 39'),
		'numcode' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true, 'comment' => 'EX: for italy is 380'),
		'contains_states' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'need_identification_number' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'need_zip_code' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'zip_code_format' => array('type' => 'string', 'null' => false, 'length' => 12, 'collate' => 'utf8_general_ci', 'comment' => 'EX: NNNNN, LNL NLN, NN-NNN, NNNN-NNN ', 'charset' => 'utf8'),
		'display_tax_label' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'countries_zone_id_foreign' => array('column' => 'zone_id', 'unique' => 0),
			'countries_iso_code' => array('column' => 'iso_code', 'unique' => 0),
			'countries_currency_id_foreign' => array('column' => 'currency_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $coupons = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'comment' => 'name of coupone', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'coupon code', 'charset' => 'utf8'),
		'price_type' => array('type' => 'tinyinteger', 'null' => false, 'default' => '1', 'length' => 2, 'unsigned' => false, 'comment' => '1=percentage or 2=fixed'),
		'price_value' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'coupon_type' => array('type' => 'string', 'null' => false, 'default' => 'travel', 'length' => 60, 'collate' => 'utf8_general_ci', 'comment' => 'Business, travel, Premote, Advert, Birthday card etc', 'charset' => 'utf8'),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false),
		'date_from' => array('type' => 'date', 'null' => false, 'default' => null),
		'date_to' => array('type' => 'date', 'null' => false, 'default' => null),
		'purchase_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 120, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'if coupone is active or not'),
		'currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'code' => array('column' => 'code', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $currencies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'this is the name of currency', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 3, 'collate' => 'utf8_general_ci', 'comment' => 'currency code', 'charset' => 'utf8'),
		'symbol' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'comment' => 'this holds the simbol of currency', 'charset' => 'utf8'),
		'sign' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_default' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'means this is the default currency of the portal'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table hold currency Types that are available on the Sit')
	);

	public $currency_converters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rates' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $email_queue = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'ascii_general_ci', 'charset' => 'ascii'),
		'to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 129, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'options' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sent' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'locked' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'send_tries' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'unsigned' => false),
		'send_at' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $email_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'example' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Used for toolti and info preview on frontend', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'code' => array('column' => 'code', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $email_templates = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'type' => array('type' => 'string', 'null' => false, 'default' => 'general', 'length' => 32, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'notification/warning/offers/confirm', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'subject' => array('type' => 'string', 'null' => true, 'default' => 'Email', 'length' => 128, 'collate' => 'utf8_general_ci', 'comment' => 'this is the email subject, here you can use veriables {[first_name]} etc', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'this is email body to be sent here as well can be used email variables', 'charset' => 'utf8'),
		'is_html' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'type' => array('column' => 'type', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $faqs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'question' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Question that user have asked', 'charset' => 'utf8'),
		'answer' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Answer of the question', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Status of the question, meaning if is 1=TRUE (display on fro'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Date of creation of the Question'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Date when the question has been answered'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $home_sliders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'image_path' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8_general_ci', 'comment' => 'this is the path of slider image', 'charset' => 'utf8'),
		'slogan' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'comment' => 'slogan is a text or caption for the slider', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true, 'comment' => 'this is for image order sorting to be displaied'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'status if an image is public or not public, meaning visble o'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $host_cancellation_penalies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 5, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => 'EUR', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $host_cancellation_policies = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'days' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'months' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'before_amount' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 100, 'unsigned' => false),
		'after_amount' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 100, 'unsigned' => false),
		'free_cancellation_limit' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 100, 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => 'EUR', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $images = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'src' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'photo_source' => array('type' => 'enum(\'local\',\'web\')', 'null' => false, 'default' => 'local', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'caption' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'model_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'model' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'id_product_cover' => array('column' => array('model', 'model_id', 'is_featured'), 'unique' => 1),
			'idx_product_image' => array('column' => array('id', 'model', 'model_id', 'is_featured'), 'unique' => 1),
			'image_product' => array('column' => array('model', 'model_id'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $languages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'comment' => 'country name as English, Italian, Albanian, Franch, etc', 'charset' => 'utf8'),
		'language_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'aka (iso code) as en, it, al, fr, etc...', 'charset' => 'utf8'),
		'icon' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'language flag', 'charset' => 'utf8mb4'),
		'is_rtl' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_default' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'language_code' => array('column' => array('language_code', 'name'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $messages = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'reservation_id' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'unsigned' => true, 'key' => 'index'),
		'conversation_id' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'unsigned' => true),
		'contact_id' => array('type' => 'biginteger', 'null' => false, 'default' => '0', 'unsigned' => true),
		'user_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'user_to' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'message' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'message_type' => array('type' => 'string', 'null' => true, 'default' => 'conversation', 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'reservation_request, conversation, message, review_request_by_host, review_rquest_by_traveler, inquiry', 'charset' => 'utf8'),
		'is_read' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_respond' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_starred' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_archived' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'reservation_id' => array('column' => array('reservation_id', 'user_by', 'user_to', 'message_type'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $page_popups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'controller' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $pages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sub_title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_keywords' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'route' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'post_route' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'view' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'class' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'top_show' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'top_order' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'bottom_show' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'bottom_order' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'new_window' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'element' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'parent_id' => array('column' => 'parent_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $payment_details = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'payment_id' => array('type' => 'smallinteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'code' => array('column' => 'code', 'unique' => 1),
			'payment_id' => array('column' => 'payment_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $payments = array(
		'id' => array('type' => 'smallinteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'payment_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_enabled' => array('type' => 'smallinteger', 'null' => false, 'default' => '0', 'unsigned' => false),
		'is_live' => array('type' => 'smallinteger', 'null' => false, 'default' => '0', 'unsigned' => false),
		'is_payout' => array('type' => 'smallinteger', 'null' => false, 'default' => '0', 'unsigned' => false),
		'arrives_on' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fees' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'currency' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'note' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'payment_name' => array('column' => 'payment_name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $paymode = array(
		'id' => array('type' => 'tinyinteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'mod_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_premium' => array('type' => 'tinyinteger', 'null' => false, 'default' => '0', 'unsigned' => true),
		'is_fixed' => array('type' => 'tinyinteger', 'null' => false, 'default' => '0', 'unsigned' => true),
		'fixed_amount' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => 'EUR', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'percentage_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'modified_date' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 111, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM', 'comment' => 'this table is used to hold different fees for user when add new property, for new booking, etc')
	);

	public $prices = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'model_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'model' => array('type' => 'string', 'null' => false, 'default' => 'Property', 'length' => 32, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'night' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'week' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'month' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'guests' => array('type' => 'smallinteger', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'limit of guests number, if grater then this apply addguest price'),
		'addguests' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'is the price for each guest'),
		'cleaning' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'security_deposit' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'previous_price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'model_id' => array('column' => 'model_id', 'unique' => 0),
			'model' => array('column' => 'model', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $properties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'property address, used for geo tagging', 'charset' => 'utf8'),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,16', 'unsigned' => false, 'comment' => 'google geo location'),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,15', 'unsigned' => false, 'comment' => 'google geo location for google maps'),
		'country' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 160, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'locality' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'district' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'state_province' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 80, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'zip_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'thumbnail' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'capacity' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false, 'comment' => 'Maximum number of people hosted'),
		'bathroom_number' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'bedroom_number' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'bed_number' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'garages' => array('type' => 'tinyinteger', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'Total number of garagues'),
		'construction_year' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'utf8_general_ci', 'comment' => 'This field is used for properties which are for sale', 'charset' => 'utf8'),
		'surface_area' => array('type' => 'integer', 'null' => true, 'default' => '10', 'unsigned' => false, 'comment' => 'surface of the property( This field is used by property whic'),
		'contract_type' => array('type' => 'enum(\'rent\',\'sale\',\'both\')', 'null' => false, 'default' => 'rent', 'collate' => 'utf8_general_ci', 'comment' => 'this shows the type of property Sale/Rent/both', 'charset' => 'utf8'),
		'minimum_days' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 10, 'unsigned' => true, 'comment' => 'minimum of days that the property can be reserved'),
		'maximum_days' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => false, 'comment' => 'maximum of days that the property can be reserved'),
		'availability_type' => array('type' => 'enum(\'one_time\',\'sometimes\',\'always\')', 'null' => false, 'default' => 'always', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'available_from' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 31, 'collate' => 'utf8_general_ci', 'comment' => 'may be definited for each day of calendar, each week, each m', 'charset' => 'utf8'),
		'available_to' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 31, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'checkin_time' => array('type' => 'string', 'null' => true, 'default' => '17', 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'checkout_time' => array('type' => 'string', 'null' => true, 'default' => '10', 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'video_url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Past a full url to the video, Youtube or Vimeo', 'charset' => 'utf8'),
		'allow_instant_booking' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Allow user to book instantanioslly withough host confirmation'),
		'price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'This field is for properties price (rent/sale)'),
		'weekly_price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'monthly_price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'currency_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'room_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'accommodation_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'cancellation_policy_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'Type of refund. (Flexible, Moderate, Hard)'),
		'security_deposit' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'This field is foramount that the user has to deposit before checkin'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'this field shows wether the property is visible or not to au'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'hits' => array('type' => 'biginteger', 'null' => true, 'default' => '1', 'unsigned' => false, 'comment' => 'Number of time a property has been viewed'),
		'is_approved' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'This shows wether the property has been accepted by site adm'),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_completed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'delete_reason' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'this field is field if user delete his property', 'charset' => 'utf8'),
		'deleted' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0),
			'currency_id' => array('column' => 'currency_id', 'unique' => 0),
			'room_type_id' => array('column' => 'room_type_id', 'unique' => 0),
			'accommodation_type_id' => array('column' => 'accommodation_type_id', 'unique' => 0),
			'cancellation_policy_id' => array('column' => 'cancellation_policy_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $properties_safeties = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'property_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'safety_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'security_id' => array('column' => 'safety_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table holds HABTM relationship between property table a')
	);

	public $property_pictures = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'image_path' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'property image path', 'charset' => 'utf8'),
		'image_caption' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'is_featured' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'this table holds data of each property images')
	);

	public $property_steps = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'unique'),
		'basics' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'description' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'location' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'photos' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'pricing' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'calendar' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $property_translations = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location_description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'space' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'access' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'interaction' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'house_rules' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'neighborhood_overview' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'seo_title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'seo_description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'seo_keywords' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'property_id', 'language_id'), 'unique' => 1),
			'property_translations_main_identifier' => array('column' => 'id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'language_id' => array('column' => 'language_id', 'unique' => 0),
			'title' => array('column' => 'title', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table holds all fields that can or should be translated')
	);

	public $recommendations = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_by' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'user_to' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'message' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'relationship' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_approval' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 31, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_by' => array('column' => 'user_by', 'unique' => 0),
			'user_to' => array('column' => 'user_to', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $redirects = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'redirect' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $reservations = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'guest making the booking'),
		'user_to' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'host to whom the booing is being made'),
		'property_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index', 'comment' => 'property being booked'),
		'checkin' => array('type' => 'date', 'null' => true, 'default' => null),
		'checkout' => array('type' => 'date', 'null' => true, 'default' => null),
		'guests' => array('type' => 'integer', 'null' => true, 'default' => '1', 'unsigned' => false),
		'nights' => array('type' => 'integer', 'null' => true, 'default' => '1', 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => true, 'default' => 'EUR', 'length' => 11, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'enum(\'site\',\'mobile\',\'web\',\'referal\')', 'null' => false, 'default' => 'site', 'collate' => 'utf8_general_ci', 'comment' => 'Indicate the reservation type if is through site or mobile', 'charset' => 'utf8'),
		'confirmation_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reservation_status' => array('type' => 'string', 'null' => true, 'default' => 'awaiting_host_approval', 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'reservation status may differ 1-9 such as 9-completed, 8-awa', 'charset' => 'utf8'),
		'payment_method' => array('type' => 'string', 'null' => true, 'default' => 'paypal', 'collate' => 'utf8_general_ci', 'comment' => 'by default paypal, credit_card', 'charset' => 'utf8'),
		'payment_country' => array('type' => 'string', 'null' => true, 'default' => 'N/A', 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'by default Not Applicable', 'charset' => 'utf8'),
		'paypal_payment_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'paypal_token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'paypal_payer_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'paypal_transaction_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'paypal_transaction_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'paypal_payer_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'comment' => 'user paypal email', 'charset' => 'utf8'),
		'paypal_payer_phonenum' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'comment' => 'Payer Phone num geathered From Pay Pal', 'charset' => 'utf8'),
		'price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'subtotal_price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'cleaning_fee' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'security_fee' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'service_fee' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'admin commition taken from the site'),
		'extra_guest_price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'avarage_price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'total_price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'total price of a reservation'),
		'to_pay' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'cancellation_policy_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 3, 'unsigned' => true, 'key' => 'index'),
		'book_date' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'the moment the user booked the property'),
		'payed_date' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'the moment the user completed the transaction (payed)'),
		'cancel_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_payed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_payed_host' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_payed_guest' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_refunded' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_canceled' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'reason_to_cancel' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'deleted' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_by' => array('column' => 'user_by', 'unique' => 0),
			'user_to' => array('column' => 'user_to', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'cancellation_policy_id' => array('column' => 'cancellation_policy_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $rest_logs = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'class' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'controller' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'action' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 16, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'requested' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'apikey' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'httpcode' => array('type' => 'smallinteger', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => true),
		'error' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ratelimited' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'data_in' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'data_out' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'responded' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $reviews = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_by' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'user_to' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'review_by' => array('type' => 'enum(\'guest\',\'host\')', 'null' => false, 'default' => 'guest', 'collate' => 'utf8_general_ci', 'comment' => 'guest - host', 'charset' => 'utf8'),
		'reservation_id' => array('type' => 'biginteger', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'review' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cleanliness' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'unsigned' => false),
		'communication' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'unsigned' => false),
		'house_rules' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'unsigned' => false),
		'accurancy' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'unsigned' => false),
		'checkin' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'unsigned' => false),
		'location' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'unsigned' => false),
		'value' => array('type' => 'smallinteger', 'null' => false, 'default' => '1', 'unsigned' => false),
		'publish_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'is_dummy' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'dummy_user' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_by' => array('column' => 'user_by', 'unique' => 0),
			'user_to' => array('column' => 'user_to', 'unique' => 0),
			'reservation_id' => array('column' => 'reservation_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $revisions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'revision' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'field' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'model_id' => array('column' => 'model_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $room_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'room_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary', 'comment' => 'id referencing to room_types table'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary', 'comment' => 'code of the language in which the field is translated to'),
		'room_type_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'room_type_id', 'language_id'), 'unique' => 1),
			'language_id' => array('column' => array('language_id', 'room_type_name'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $safeties = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'icon' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Icon of each of the securities.', 'charset' => 'utf8'),
		'icon_class' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => 'Fontawsome or bootstrap glicofont classes ', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'This table holds extra security/safety features of an proper')
	);

	public $safety_translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'safety_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary', 'comment' => 'ID of the security, of which this field corresponds to'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary', 'comment' => 'language code in which the name field is going to be transla'),
		'safety_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'name of security in different languages', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('id', 'safety_id', 'language_id'), 'unique' => 1),
			'safety_id' => array('column' => 'safety_id', 'unique' => 0),
			'language_id' => array('column' => 'language_id', 'unique' => 0),
			'safety_name' => array('column' => 'safety_name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $seasonal_prices = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'unique'),
		'price' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'start_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'end_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'currency' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 11, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'property_id_2' => array('column' => 'property_id', 'unique' => 1),
			'property_id' => array('column' => 'property_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $service_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'slug' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_keywords' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'slug_2' => array('column' => 'slug', 'unique' => 1),
			'slug' => array('column' => 'slug', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $service_pictures = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'service_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'image_path' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'service image path', 'charset' => 'utf8'),
		'image_caption' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => true),
		'is_featured' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'this is an image that tells if an image is featured or not'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'service_id' => array('column' => 'service_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB', 'comment' => 'this table holds data of each service images')
	);

	public $services = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tel1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tel2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fax' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 30, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'address_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'service_category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'business_hours_week' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'business_hours_sat' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'business_hours_sun' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 60, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 160, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'meta_keywords' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $site_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'key' => array('type' => 'string', 'null' => false, 'default' => 'GENERAL', 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'key' => array('column' => 'key', 'unique' => 1),
			'key_2' => array('column' => 'key', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $social_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'social_network_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'social_network_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'display_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'link' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 512, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'picture' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 512, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $socials = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'model_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true),
		'model' => array('type' => 'string', 'null' => false, 'default' => 'Property', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'facebook' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'twitter' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'linkedin' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'googleplus' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'youtube' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'instagram' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pinterest' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'tumblr' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'whatsapp' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'skype' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'flickr' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'country_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'zone_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'EX: Roma', 'charset' => 'utf8'),
		'iso_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 7, 'collate' => 'utf8_general_ci', 'comment' => 'EX: RM', 'charset' => 'utf8'),
		'tax_behavior' => array('type' => 'smallinteger', 'null' => false, 'default' => '0', 'length' => 5, 'unsigned' => true),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'states_zone_id_foreign' => array('column' => 'zone_id', 'unique' => 0),
			'states_country_id_foreign' => array('column' => 'country_id', 'unique' => 0),
			'name' => array('column' => 'name', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $timezones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'name' => array('column' => 'name', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $user_notifications = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'unique'),
		'new_booking' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'new_review' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'review_request' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'leave_review'),
		'booking_request' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'standby_guests' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'company_news' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'periodic_offers' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 1),
			'user_id_2' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'unique'),
		'company' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'job_title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'about' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'zip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'country' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'comment' => 'if a user has a personal site he can put his url in here', 'charset' => 'utf8'),
		'linkedin' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'twitter' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'facebook' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'googleplus' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pinterest' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'instagram' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'vimeo' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'youtube' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'hobbies' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'knowledge' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'references' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'credit_card_type' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'credit_card_number' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'credit_card_expire' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'credit_card_security_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 5, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'card_holder' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'banner' => array('type' => 'string', 'null' => true, 'default' => '0', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'user_id_2' => array('column' => 'user_id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $user_sessions = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'data' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'expires' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $user_wishlists = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'property_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'wishlist_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'index'),
		'note' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'wishlist_id' => array('column' => 'wishlist_id', 'unique' => 0),
			'property_id' => array('column' => 'property_id', 'unique' => 0),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'surname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'birthday' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'gender' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image_path' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8_general_ci', 'comment' => 'User Avatar picture', 'charset' => 'utf8'),
		'token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'token_expires' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'api_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'reset_password' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'activation_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => 'Key sent to user to activate his account.', 'charset' => 'utf8'),
		'activation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'if email confirmed  then 1'),
		'role' => array('type' => 'string', 'null' => true, 'default' => 'user', 'length' => 12, 'collate' => 'utf8_general_ci', 'comment' => 'user/admin/agent/agency', 'charset' => 'utf8'),
		'is_banned' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => '0-False, 1-TRUE if user has been baned by SITE administrator'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true, 'comment' => 'if a user is agent, then he belong to a user (registered as agency)'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'deleted' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'username' => array('column' => 'username', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1),
			'user_email' => array('column' => 'email', 'unique' => 0),
			'user_login' => array('column' => array('email', 'password'), 'unique' => 0),
			'id_user_passwd' => array('column' => array('id', 'password'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $users_verification = array(
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'email' => array('type' => 'enum(\'yes\',\'no\')', 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'facebook' => array('type' => 'enum(\'yes\',\'no\')', 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'google' => array('type' => 'enum(\'yes\',\'no\')', 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'linkedin' => array('type' => 'enum(\'yes\',\'no\')', 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'enum(\'yes\',\'no\')', 'null' => false, 'default' => 'no', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fb_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'google_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'linkedin_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'user_id', 'unique' => 1),
			'user_id' => array('column' => 'user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	public $wishlists = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => true),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'count' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $zones = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

}
