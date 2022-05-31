<?php
App::uses('AppModel', 'Model');
/**
 * Country Model
 *
 */
class Country extends AppModel {


/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'country_name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => 'blank',
				'message' => 'ID can not be changed manually homeboy.',
				'on' => 'create',
			),
		),
		'iso_code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Country symbol can not be empty.',
				'allowEmpty' => false
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Country name can not be empty.',
				'allowEmpty' => false
			),
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Only alfanumeric caracters are allowed.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'phonecode' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'only numbers are allowed',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);


/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Zone' => array(
			'className' => 'Zone',
			'foreignKey' => 'zone_id',
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
		)
	);


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
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
 * isNeedDniByCountryId
 * check if a specific country need identification number
 *
 * @param  int $country_id
 * @return boolean
 */
	public function isNeedDniByCountryId($country_id) {
		return (bool)$this->field('need_identification_number', array('id' => $country_id));
	}

/**
 * containStates
 * check if a specific country contain states
 *
 * @param  int $country_id
 * @return boolean
 */
	public function containStates($country_id) {
		return (bool)$this->field('contains_states', array('id' => $country_id));
	}

    public function getStates($active = true) {
    	$conditions = [];
    	if ($active) {
    		$conditions['State.status'] = 1;
    	}
    	return $this->State->find('all', ['conditions' => $conditions, 'order' => ['State.name' => 'ASC']]);
    }


    public function getStatesByCountryId($country_id, $no_empty = false) {
		$states = $this->State->find('all', array(
			'joins' => [
				[
					'table' => 'countries',
					'alias' => 'Country',
					'type' => 'LEFT',
					'conditions' => ['State.country_id = Country.id']
				]
			],
			'conditions' => ['State.country_id' => $country_id, 'State.status'=> 1, 'Country.contains_states' => 1],
			'order' => ['State.name ASC']
		));
		if (is_array($states) and !empty($states)) {
		    $list = '';
		    if ((bool)$no_empty != true) {
		        $empty_value = '-';
		        $list = '<option value="0">'.htmlentitiesUTF8($empty_value).'</option>'."\n";
		    }

		    foreach ($states as $state) {
		        $list .= '<option value="'.(int)($state['State']['id']).'"'.((isset($_GET['id_state']) and $_GET['id_state'] == $state['State']['id']) ? ' selected="selected"' : '').'>'.$state['State']['name'].'</option>'."\n";
		    }
		} else {
		    $list = 'false';
		}
		return $list;
    }

/**
 * Replace letters of zip code format And check this format on the zip code
 * @param $zip_code
 * @param $country
 * @return (bool)
 */
    public function checkZipCode($zip_code, $country) {
        $zip_regexp = '/^'. $country['zip_code_format'] . '$/ui';
        $zip_regexp = str_replace(' ', '( |)', $zip_regexp);
        $zip_regexp = str_replace('-', '(-|)', $zip_regexp);
        $zip_regexp = str_replace('N', '[0-9]', $zip_regexp);
        $zip_regexp = str_replace('L', '[a-zA-Z]', $zip_regexp);
        $zip_regexp = str_replace('C',  $country['iso_code'], $zip_regexp);

        return (bool)preg_match($zip_regexp, $zip_code);
    }

/**
 * getZipCodeFormat return the zip format for specific country
 * @param  int $country_id
 * @return mixed boolean|string
 */
    public static function getZipCodeFormat($country_id) {
        if (!(int)$country_id) {
            return false;
        }

		$zip_code_format = $this->field('zip_code_format', array('id' => (int)$country_id));

        if (isset($zip_code_format) && $zip_code_format) {
            return $zip_code_format;
        }
        return false;
    }

/**
 * Check for postal code validity
 *
 * @param string $postal_code Postal code to validate
 * @return bool Validity is ok or not
 */
    public static function isPostCode($postal_code) {
        return empty($postal_code) || preg_match('/^[a-zA-Z 0-9-]+$/', $postal_code);
    }

}
