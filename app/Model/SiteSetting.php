<?php
App::uses('AppModel', 'Model');
/**
 * SiteSetting Model
 *
 */
class SiteSetting extends AppModel {

/**
 * Model Name
 *
 * @var string
 */
	public $name = 'SiteSetting';

/**
 * table name
 *
 * @var string
 */
    public $useTable = 'site_settings';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'key';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'value';

/**
 * Validation rules for GENERAL
 *
 * @var array
 */

	public $general_settings = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not directly modify ID attribute',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sitename' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'Sitename must be less then 50 Characters',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'tagline' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 120),
				'message' => 'Tagline must be less then 120 characters',
				'allowEmpty' => false,
				'required' => false,
			),
		),
		'slogan' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 60),
				'message' => 'Site slogan must be less then 60 characters',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'address' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => 'Address must be less then 255 characters',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'contact_number' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 30),
				'message' => 'Contact Number must be less then 30 characters',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email', true),
				'message' => 'You must suply a valid email address',
				'allowEmpty' => true,
				'required' => false,
			),
			'maxLength' => array(
				'rule' => array('maxLength', 120),
				'message' => 'E-mail must be less then 120 characters',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'facebook' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'facebook URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'twitter' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'twitter URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'pinterest' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'pinterest URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'linkedin' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'linkedin URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'googleplus' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'googleplus URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'instagram' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'instagram URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'tumblr' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'tumblr URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'youtube' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'youtube URL can not be more hten 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'vimeo' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 512),
				'message' => 'vimeo URL can not be more then 512 characters.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'disable_registration' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'Disable registration: Only boolean value is allowed.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'copyright' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'Footer copyright text must be less then 160 characters',
				'allowEmpty' => true,
				'required' => false,
			),
		),
		'powered_by' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'PoweredBy must be less then 50 characters',
				'allowEmpty' => true,
				'required' => false,
			),
		),
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'key' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter the value for key field.'
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'value' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter the value for value field.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * [getSiteSetting Get site setting for a specific key]
 * @param  string $key [identification key]
 * @return Array|json  [Returned data as json type which can late be turned as array]
 */
	public function getSiteSetting($key = 'GENERAL', $setData = false) {
		if (!$key) {
			$key = 'GENERAL';
			// throw new NotFoundException('No setting found');
		}

		$generalSiteSetting = $this->find('first',array('conditions' => array('SiteSetting.key' => $key), 'recursive' => -1));
		if (!$generalSiteSetting) {
			return false;
			// throw new NotFoundException(__('No setting found: %s.', $key));
		}

		if (!empty($generalSiteSetting['SiteSetting']['value'])) {
			$setting = json_decode($generalSiteSetting['SiteSetting']['value'], true);

			if ($setData === true && isset($setting['SiteSetting'])) {
				$merged_data = array_merge(Configure::read('Website'), $setting['SiteSetting']);
				Configure::write('Website', $merged_data);
			}

			return $setting;
		}

		return false;
	}

/**
 * load all general configuration
 * @example
 * 	$setting = ClassRegistry::init('SiteSetting')->load('GENERAL');
 *  # access several attributes 
 *  $setting['name'];
 *  $setting['email'];
 * @example
 * 
 * @param  string $prefix the prefix to use for these settings
 * @return void
 */
    public function load() {

    	$settings = Configure::read('Website'); // these are fallback settings 

    	$generalSiteSetting = $this->find('first', ['conditions' => array('SiteSetting.key' => 'GENERAL'), 'recursive' => -1]);
    	if (!$generalSiteSetting) {
    		return $settings;
    	}

    	if (!empty($generalSiteSetting['SiteSetting']['value'])) {
    		$siteSetting = json_decode($generalSiteSetting['SiteSetting']['value'], true);

    		$settings = array_merge(Configure::read('Website'), $siteSetting['SiteSetting']);
    		Configure::write('Website', $settings);
    	}

		return $settings;
    }

}