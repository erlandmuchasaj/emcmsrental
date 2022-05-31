<?php
App::uses('AppModel', 'Model');
/**
 * Language Model
 *
 */
class Language extends AppModel {

	/**
	 * Model Name
	 *
	 * @var string
	 */
	public $name = 'Language';

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
	public $displayField = 'name';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => 'blank',
				'message' => 'You can not modify this attribute',
				'on' => 'create',
			),
		),
		'name' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'Max length of 50.',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Should Not be empty.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Name should be unique.',
			),
		),
		'language_code' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 2),
				'message' => 'Max length of code is 2.',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Should Not be empty.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'CODE should be unique.',
			),
		),
		'locale' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 3),
				'message' => 'Max length of locale code is 3.',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'locale should Not be empty.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'locale should be unique.',
			),
		),
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	// public $hasMany = array(
	// 	'UserProfile' => array(
	// 		'className' => 'UserProfile',
	// 		'foreignKey' => 'language_id',
	// 		'dependent' => false,
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => '',
	// 		'limit' => '',
	// 		'offset' => '',
	// 		'exclusive' => '',
	// 		'finderQuery' => '',
	// 		'counterQuery' => ''
	// 	),
	// );


	/**
	 * Get user different fields
	 * $this->Language->findLanguageName(ID);
	 * @var Boolean
	 * @var String 
	 */
		public function findLanguageNameById($id) {
			return $this->field('name', array('id' => $id));
		}	

		public function findLanguageNameByCode($code) {
			return $this->field('name', array('language_code' => $code));
		}

		public function findLanguageCodeById($id) {
			return $this->field('language_code', array('id' => $id));
		}

		public function findLanguageIdByCode($code) {
			return $this->field('id', array('language_code' => $code));
		}

		public function getDefaultLanguage() {
			return $this->find('first', [
				'conditions' => [
					'Language.is_default' => 1,
					'Language.status' => 1
				],
				'recursive' => -1,
				'callbacks' => false,
				'limit' => 1
			]);
		}

		public function getDefaultLanguageId() {
			$defaultLang = $this->getDefaultLanguage();
			if ($defaultLang) {
				return (int) $defaultLang['Language']['id'];
			}
			return null;
		}

		public function getDefaultLanguageCode() {
			$defaultLang = $this->getDefaultLanguage();
			if ($defaultLang) {
				return $defaultLang['Language']['language_code'];
			}
			return 'en';
		}

		public function getLanguageList($type = 'list') {
			if (!in_array($type, ['list', 'all'], true)) {
				$type = 'list';
			}

			$languages = $this->find($type, [
				'conditions' => [
					'Language.status' => 1
				],
				'order' => [
					'Language.id ASC'
				], 
				'recursive'=>-1
			]);
			return $languages;
		}

		public function getActiveLanguageDirection() {
			$lang = $this->getActiveLanguage();
			if (isset($lang['Language']['is_rtl']) && (int)$lang['Language']['is_rtl'] == 1) {
				return 'rtl';
			}
			return 'ltr';
		}

		public function getActiveLanguageCode() {
			return $this->getActiveLanguageId(true);
		}

		public function getActiveLanguageId($getCode = false) {
			App::uses('CakeSession', 'Model/Datasource');

			$language_id = null;
			$defaultLang = $this->getDefaultLanguage();
			$language_code = isset($defaultLang['Language']['language_code']) ? $defaultLang['Language']['language_code'] : 'en';

			if (CakeSession::check('Config.language')) { // Check for existing language session
				$language_code = CakeSession::read('Config.language'); // Read existing language

				// we try to get a language in our system
				$languageData  = $this->find('first', [
					'conditions' => [
						'Language.language_code' => $language_code,
						'Language.status' => 1
					],
					'recursive' => -1,
					'callbacks' => false,
					'fields' => ['Language.id'],
					'limit' => 1
				]);

				if (!empty($languageData)) {
					$language_id = (int) $languageData['Language']['id'];
				} else {
					if ($defaultLang) {
						$language_id = (int) $defaultLang['Language']['id'];
						$language_code = $defaultLang['Language']['language_code'];
					}
				}
			} else {
				if ($defaultLang) {
					$language_id = (int) $defaultLang['Language']['id'];
					$language_code = $defaultLang['Language']['language_code'];
				}
			}

			return ($getCode) ? $language_code : $language_id;
		}

		public function getActiveLanguage() {
			App::uses('CakeSession', 'Model/Datasource');

			if (CakeSession::check('Config.language')) { // Check for existing language session
				$language_code = CakeSession::read('Config.language'); // Read existing language
				// we try to get a language in our system
				$languageData  = $this->find('first', [
					'conditions' => [
						'Language.language_code' => $language_code,
						'Language.status' => 1
					],
					'recursive' => -1,
					'callbacks' => false,
					'limit' => 1
				]);

				if ($languageData) {
					return $languageData;
				}
			}

			$defaultLang = $this->getDefaultLanguage();
			return $defaultLang;
		}

		public function isDefault($id) {
			return (bool)$this->field('is_default', array('id' => $id));
		}

	/**
	 * Copy when a new language is created
	 * @todo Check for  Integrity constraint violation: 1062 Duplicate entry '1' for key 'PRIMARY'
	 * @param int $id_lang_default  default language ID 
	 * @param int $id_lang new language ID
	 */
	public function copyLanguageData($id_lang_default, $id_lang) {
		if (!$id_lang_default || !$id_lang) {
			return false;
		}

		# $sourceList = ConnectionManager::sourceList();
		$db = ConnectionManager::getDataSource($this->useDbConfig);
		$config  = $db->config;
		$tables  = $db->listSources();
		$db_name = $db->getSchemaName();
		$prefix = $db->config['prefix'];

		// $result = $db->query('SHOW TABLES FROM `'.$db_name.'`');
		foreach ($tables as $table_name) {

			// $table_name = $table['TABLE_NAMES']['Tables_in_'.$db_name];
		    if (
		    	(preg_match('/_translations/', $table_name) ||
		    		$table_name == $config['prefix'].'accommodation_types' ||
		    		$table_name == $config['prefix'].'room_types') &&
		    	($table_name != $config['prefix'].'languages')
		    ) {

		        $result2 = $db->query('SELECT * FROM `'.$table_name.'` WHERE `language_id` = '.(int)$id_lang_default);
		        
		        if (!count($result2)) {
		            continue;
		        }

		        // delete old language if there is any
		    	$db->query('DELETE FROM `'.$table_name.'` WHERE `language_id` = '.(int)$id_lang);

				$table 		= str_replace($config['prefix'], '', $table_name);
				$ModelName 	= Inflector::classify($table);
				$Model 		= ClassRegistry::init($ModelName);
				
				// $keys = array_keys($result2[0][$table_name]);
				// debug($Model->schema());
				// debug($Model->getColumnTypes());

				$fields = array_keys($Model->schema());
				if (($key = array_search($Model->primaryKey, $fields)) !== false) {
				    unset($fields[$key]);
				}
				# this is the db header aka column names
				$header = '`' . implode('`, `', $fields) . '`';

		        $query = 'INSERT INTO `'.$table_name.'` ('.$header.') VALUES ';
		        foreach ($result2 as $row2) {

		            $query .= '(';
		            $row2[$table_name]['language_id'] = $id_lang;

		            foreach ($row2[$table_name] as $name => $field) {
		            	// do not dublicate primary key.
		            	if ($name === $Model->primaryKey) {
		            		continue;
		            	}

		                $query .= (!is_string($field) && $field == null) ? 'NULL,' : '\''.mysqlPrepare($field, true).'\',';
		            }

		            $query = rtrim($query, ',').'),';
		        }
		        $query = rtrim($query, ',');

		        $db->query($query);
		    }
		}
		return true;
	}

	/**
	 * removeLanguageData
	 * Remove a language from DB after you have deactivate it.
	 * @param  int $id_lang
	 * @return boolean
	 */
	public function removeLanguageData($id_lang) {
		if (!$id_lang) {
			return false;
		}

		$db = ConnectionManager::getDataSource($this->useDbConfig);
		$config  = $db->config;
		$tables  = $db->listSources();
		foreach ($tables as $table_name) {
		    if (
		    	(preg_match('/_translations/', $table_name) ||
		    		$table_name == $config['prefix'].'accommodation_types' ||
		    		$table_name == $config['prefix'].'room_types') &&
		    	($table_name != $config['prefix'].'languages')
		    ) {
		        // delete old language if there is any
		    	$db->query('DELETE FROM `'.$table_name.'` WHERE `language_id` = '.(int)$id_lang);
		    }
		}
		return true;
	}

	/**
	 * Called after save operation.
	 *
	 * @param bool $created True if this save created a new record
	 * @param array $options Options passed from Model::save().
	 * @return void
	 * @see Model::save()
	 */
	public function afterSave($created, $options = array()) {
		parent::afterSave($created, $options);

		if ($created === true) {
			$id_lang_default = $this->getDefaultLanguageId();
			$this->copyLanguageData($id_lang_default, $this->id);
		}

		return true;
	}

	/**
	 * Called before every deletion operation.
	 *
	 */
	public function beforeDelete($cascade = true) {
		// we try to get a language in our system
		// and do not delete the last language
		$count = $this->find('count', [
			// 'conditions' => [
			// 	'Language.status' => 1
			// ],
			'recursive' => -1,
			'callbacks' => false,
		]);

		if ($count <= 1) {
			return false;
		}

		return parent::beforeDelete($cascade);
	}

	/**
	 * Called after deletion operation.
	 *
	 * @return void
	 */
	public function afterDelete() {
		parent::afterDelete();
		$this->removeLanguageData($this->id);
		return true;
	}

	/**
	 * Maps ISO 639-3 to I10n::_l10nCatalog
	 * The terminological codes (first one per language) should be used if possible.
	 * They are the ones building the url path in `domain.com/[code]`
	 * The bibliographic codes are aliases.
	 *
	 * @var array
	 */
	public $l10nMap = array(
		'af' => 'Afrikaans',
		'sq' => 'Albanian',
		'ar' => 'Arabic',
		'hy' => 'Armenian',
		'eu' => 'Basque',
		'bo' => 'Tibetan',
		'bs' => 'Bosnian',
		'bg' => 'Bulgarian',
		'be' => 'Byelorussian',
		'ca' => 'Catalan',
		'zh' => 'Chinese',
		'hr' => 'Croatian',
		'cs' => 'Czech',
		'da' => 'Danish',
		'nl' => 'Dutch',
		'en' => 'English',
		'et' => 'Estonian',
		'fo' => 'Faeroese',
		'fa' => 'Farsi/Persian',
		'fi' => 'Finnish',
		'fr' => 'French',
		'gd' => 'Gaelic',
		'gl' => 'Galician',
		'de' => 'German',
		'el' => 'Greek',
		'he' => 'Hebrew',
		'hi' => 'Hindi',
		'hu' => 'Hungarian',
		'is' => 'Icelandic',
		'id' => 'Indonesian',
		'ga' => 'Irish',
		'it' => 'Italian',
		'ja' => 'Japanese',
		'kk' => 'Kazakh',
		'kl' => 'Kalaallisut (Greenlandic)',
		'ko' => 'Korean',
		'lv' => 'Latvian',
		'li' => 'Limburgish',
		'lt' => 'Lithuanian',
		'lb' => 'Luxembourgish',
		'mk' => 'Macedonian',
		'ms' => 'Malaysian',
		'mt' => 'Maltese',
		'no' => 'Norwegian',
		'nb' => 'Norwegian Bokmal',
		'nn' => 'Norwegian Nynorsk',
		'pl' => 'Polish',
		'pt' => 'Portuguese',
		'rm' => 'Rhaeto-Romanic',
		'ro' => 'Romanian',
		'ru' => 'Russian',
		'se' => 'Sami',
		'sr' => 'Serbian',
		'sk' => 'Slovak',
		'sl' => 'Slovenian',
		'sb' => 'Sorbian',
		'es' => 'Spanish',
		'sv' => 'Swedish',
		'th' => 'Thai',
		'ts' => 'Tsonga',
		'tn' => 'Tswana',
		'tr' => 'Turkish',
		'uk' => 'Ukrainian',
		'ur' => 'Urdu',
		've' => 'Venda',
		'vi' => 'Vietnamese',
		'cy' => 'Welsh',
		'xh' => 'Xhosa',
		'yi' => 'Yiddish',
		'zu' => 'Zulu',
	);

	/**
	 * Maps I10n::_l10nCatalog toISO 639-3 to 
	 * The terminological codes (first one per language) should be used if possible.
	 * They are the ones building the path in `/APP/Locale/[iso_Code]/LC_MESSAGES/default.po`
	 *
	 * @var array
	 */
	public $l10nToIso = [
		'af' => 'afr',
		'sq' => 'sqi',
		'ar' => 'ara',
		'hy' => 'hye',
		'eu' => 'eus',
		'bo' => 'bod',
		'bs' => 'bos',
		'bg' => 'bul',
		'be' => 'bel',
		'ca' => 'cat',
		'zh' => 'zho',
		'hr' => 'hrv',
		'cs' => 'ces',
		'da' => 'dan',
		'nl' => 'nld',
		'en' => 'eng',
		'et' => 'est',
		'fo' => 'fao',
		'fa' => 'fas',
		'fi' => 'fin',
		'fr' => 'fra',
		'gd' => 'gla',
		'gl' => 'glg',
		'de' => 'deu',
		'el' => 'gre',
		'he' => 'heb',
		'hi' => 'hin',
		'hu' => 'hun',
		'is' => 'isl',
		'id' => 'ind',
		'ga' => 'gle',
		'it' => 'ita',
		'ja' => 'jpn',
		'kk' => 'kaz',
		'kl' => 'kal',
		'ko' => 'kor',
		'lv' => 'lav',
		'li' => 'lim',
		'lt' => 'lit',
		'lb' => 'ltz',
		'mk' => 'mkd',
		'ms' => 'msa',
		'mt' => 'mlt',
		'no' => 'nor',
		'nb' => 'nob',
		'nn' => 'nno',
		'pl' => 'pol',
		'pt' => 'por',
		'rm' => 'roh',
		'ro' => 'ron',
		'ru' => 'rus',
		'se' => 'sme',
		'sr' => 'srp',
		'sk' => 'slk',
		'sl' => 'slv',
		'sb' => 'wen',
		'es' => 'spa',
		'sv' => 'swe',
		'th' => 'tha',
		'ts' => 'tso',
		'tn' => 'tsn',
		'tr' => 'tur',
		'uk' => 'ukr',
		'ur' => 'urd',
		've' => 'ven',
		'vi' => 'vie',
		'cy' => 'cym',
		'xh' => 'xho',
		'yi' => 'yid',
		'zu' => 'zul', 
	];

}
