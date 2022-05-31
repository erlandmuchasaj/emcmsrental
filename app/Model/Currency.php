<?php
App::uses('AppModel', 'Model');
/**
 * Currency Model
 *
 * @property Property $Property
 * @property Reservation $Reservation
 */
class Currency extends AppModel {

/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Currency';

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
				'rule' => array('blank'),
				'message' => 'You can not modify this attribute',
				'on' => 'create',
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Currency name can not be empty',
				'allowEmpty' => false,
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This name allredy exists.',
			),
		),
		'code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Should Not be empty.',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 3),
				'message' => 'Max length of code is 3.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'CODE should be unique.',
			),
		),
		'symbol' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Currency symbol can not be empty',
				'allowEmpty' => false,
			),
			// 'alphaNumeric' => array(
			// 	'rule' => array('alphaNumeric'),
			// 	'message' => 'symbol can be only AlfaNumeric',
			// 	'allowEmpty' => false,
			// ),
			// 'isUnique' => array(
			// 	'rule' => 'isUnique',
			// 	'message' => 'This Currency allredy exists.',
			// ),
		),
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Property' => array(
			'className' => 'Property',
			'foreignKey' => 'currency_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		// 'UserProfile' => array(
		// 	'className' => 'UserProfile',
		// 	'foreignKey' => 'currency_id',
		// 	'dependent' => false,
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => '',
		// 	'limit' => '',
		// 	'offset' => '',
		// 	'exclusive' => '',
		// 	'finderQuery' => '',
		// 	'counterQuery' => ''
		// ),
	);

/**
 * Get currency different fields
 * $this->Currency->findCurrencyName(ID);
 * @var Boolean
 * @var String
 */
	public function findCurrencyNameById($id) {
		return $this->field('Currency.name', array('Currency.id' => $id));
	}

	public function findCurrencyNameByCode($code) {
		return $this->field('Currency.name', array('Currency.code' => $code));
	}

	public function findCurrencyCodeById($id) {
		return $this->field('Currency.code', array('Currency.id' => $id));
	}

	public function findCurrencyIdByCode($code) {
		return $this->field('Currency.id', array('Currency.code' => $code));
	}

	public function findCurrencySymbolById($id) {
		return $this->field('Currency.symbol', array('Currency.id' => $id));
	}

	public function findCurrencySymbolByCode($code) {
		return $this->field('Currency.symbol', array('Currency.code' => $code));
	}

	public function getDefaultCurrency() {
		return $this->find('first', [
			'conditions' => [
				'Currency.is_default' => 1,
				'Currency.status' => 1
			],
			'recursive' => -1,
			'callbacks' => false,
			'limit' => 1
		]);
	}

	public function getDefaultCurrencyId() {
		$defaultCurrency = $this->getDefaultCurrency();
		if ($defaultCurrency) {
			return (int) $defaultCurrency['Currency']['id'];
		}
		return null;
	}

	public function getDefaultCurrencyCode() {
		$defaultCurrency = $this->getDefaultCurrency();
		if ($defaultCurrency) {
			return $defaultCurrency['Currency']['code'];
		}
		return 'EUR';
	}

	public function getDefaultCurrencySymbol() {
		$defaultCurrency = $this->getDefaultCurrency();
		if ($defaultCurrency) {
			return $defaultCurrency['Currency']['symbol'];
		}
		return '€';
	}


	public function getCurrencyList($type = 'list') {
		
		if (!in_array($type, ['list', 'all'], true)) {
			$type = 'list';
		}

		$currencies = $this->find($type, [
			'conditions' => [
				'Currency.status' => 1
			], 
			'order' => [
				'Currency.id ASC'
			],
			'recursive' => -1
		]);

		return $currencies;
	}


/**
 * getLocalCurrency return active currency of the site
 * @return string currency code
 */
	public function getLocalCurrency() {
		App::uses('CakeSession', 'Model/Datasource');
		if (CakeSession::check('LocaleCurrency')) {
			$localeCurrency = CakeSession::read('LocaleCurrency');
		} else {
			$localeCurrency = $this->getDefaultCurrencyCode();
			CakeSession::write('LocaleCurrency', $localeCurrency);
		}
		return $localeCurrency;
	}


	/**
	 * Called before every deletion operation.
	 *
	 */
	public function beforeDelete($cascade = true) {
		// we try to get a currency in our system
		// and do not delete the last currency
		$count = $this->find('count', [
			// 'conditions' => [
			// 	'Currency.status' => 1
			// ],
			'recursive' => -1,
			'callbacks' => false,
		]);

		if ($count <= 1) {
			return false;
		}

		return parent::beforeDelete($cascade);
	}

	public $currencyNames = [
		'ALL' => 'Albanian Lek',
		'XCD' => 'East Caribbean Dollar',
		'EUR' => 'Euro',
		'BBD' => 'Barbadian Dollar',
		'BTN' => 'Bhutanese Ngultrum',
		'BND' => 'Brunei Dollar',
		'XAF' => 'Central African CFA Franc',
		'CUP' => 'Cuban Peso',
		'USD' => 'United States Dollar',
		'FKP' => 'Falkland Islands Pound',
		'GIP' => 'Gibraltar Pound',
		'HUF' => 'Hungarian Forint',
		'IRR' => 'Iranian Rial',
		'JMD' => 'Jamaican Dollar',
		'AUD' => 'Australian Dollar',
		'LAK' => 'Lao Kip',
		'LYD' => 'Libyan Dinar',
		'MKD' => 'Macedonian Denar',
		'XOF' => 'West African CFA Franc',
		'NZD' => 'New Zealand Dollar',
		'OMR' => 'Omani Rial',
		'PGK' => 'Papua New Guinean Kina',
		'RWF' => 'Rwandan Franc',
		'WST' => 'Samoan Tala',
		'RSD' => 'Serbian Dinar',
		'SEK' => 'Swedish Krona',
		'TZS' => 'Tanzanian Shilling',
		'AMD' => 'Armenian Dram',
		'BSD' => 'Bahamian Dollar',
		'BAM' => 'Bosnia And Herzegovina Konvertibilna Marka',
		'CVE' => 'Cape Verdean Escudo',
		'CNY' => 'Chinese Yuan',
		'CRC' => 'Costa Rican Colon',
		'CZK' => 'Czech Koruna',
		'ERN' => 'Eritrean Nakfa',
		'GEL' => 'Georgian Lari',
		'HTG' => 'Haitian Gourde',
		'INR' => 'Indian Rupee',
		'JOD' => 'Jordanian Dinar',
		'KRW' => 'South Korean Won',
		'LBP' => 'Lebanese Lira',
		'MWK' => 'Malawian Kwacha',
		'MRO' => 'Mauritanian Ouguiya',
		'MZN' => 'Mozambican Metical',
		'ANG' => 'Netherlands Antillean Gulden',
		'PEN' => 'Peruvian Nuevo Sol',
		'QAR' => 'Qatari Riyal',
		'STD' => 'Sao Tome And Principe Dobra',
		'SLL' => 'Sierra Leonean Leone',
		'SOS' => 'Somali Shilling',
		'SDG' => 'Sudanese Pound',
		'SYP' => 'Syrian Pound',
		'AOA' => 'Angolan Kwanza',
		'AWG' => 'Aruban Florin',
		'BHD' => 'Bahraini Dinar',
		'BZD' => 'Belize Dollar',
		'BWP' => 'Botswana Pula',
		'BIF' => 'Burundi Franc',
		'KYD' => 'Cayman Islands Dollar',
		'COP' => 'Colombian Peso',
		'DKK' => 'Danish Krone',
		'GTQ' => 'Guatemalan Quetzal',
		'HNL' => 'Honduran Lempira',
		'IDR' => 'Indonesian Rupiah',
		'ILS' => 'Israeli New Sheqel',
		'KZT' => 'Kazakhstani Tenge',
		'KWD' => 'Kuwaiti Dinar',
		'LSL' => 'Lesotho Loti',
		'MYR' => 'Malaysian Ringgit',
		'MUR' => 'Mauritian Rupee',
		'MNT' => 'Mongolian Tugrik',
		'MMK' => 'Myanma Kyat',
		'NGN' => 'Nigerian Naira',
		'PAB' => 'Panamanian Balboa',
		'PHP' => 'Philippine Peso',
		'RON' => 'Romanian Leu',
		'SAR' => 'Saudi Riyal',
		'SGD' => 'Singapore Dollar',
		'ZAR' => 'South African Rand',
		'SRD' => 'Surinamese Dollar',
		'TWD' => 'New Taiwan Dollar',
		'TOP' => 'Paanga',
		'VEF' => 'Venezuelan Bolivar',
		'DZD' => 'Algerian Dinar',
		'ARS' => 'Argentine Peso',
		'AZN' => 'Azerbaijani Manat',
		'BYR' => 'Belarusian Ruble',
		'BOB' => 'Bolivian Boliviano',
		'BGN' => 'Bulgarian Lev',
		'CAD' => 'Canadian Dollar',
		'CLP' => 'Chilean Peso',
		'CDF' => 'Congolese Franc',
		'DOP' => 'Dominican Peso',
		'FJD' => 'Fijian Dollar',
		'GMD' => 'Gambian Dalasi',
		'GYD' => 'Guyanese Dollar',
		'ISK' => 'Icelandic Króna',
		'IQD' => 'Iraqi Dinar',
		'JPY' => 'Japanese Yen',
		'KPW' => 'North Korean Won',
		'LVL' => 'Latvian Lats',
		'CHF' => 'Swiss Franc',
		'MGA' => 'Malagasy Ariary',
		'MDL' => 'Moldovan Leu',
		'MAD' => 'Moroccan Dirham',
		'NPR' => 'Nepalese Rupee',
		'NIO' => 'Nicaraguan Cordoba',
		'PKR' => 'Pakistani Rupee',
		'PYG' => 'Paraguayan Guarani',
		'SHP' => 'Saint Helena Pound',
		'SCR' => 'Seychellois Rupee',
		'SBD' => 'Solomon Islands Dollar',
		'LKR' => 'Sri Lankan Rupee',
		'THB' => 'Thai Baht',
		'TRY' => 'Turkish New Lira',
		'AED' => 'UAE Dirham',
		'VUV' => 'Vanuatu Vatu',
		'YER' => 'Yemeni Rial',
		'AFN' => 'Afghan Afghani',
		'BDT' => 'Bangladeshi Taka',
		'BRL' => 'Brazilian Real',
		'KHR' => 'Cambodian Riel',
		'KMF' => 'Comorian Franc',
		'HRK' => 'Croatian Kuna',
		'DJF' => 'Djiboutian Franc',
		'EGP' => 'Egyptian Pound',
		'ETB' => 'Ethiopian Birr',
		'XPF' => 'CFP Franc',
		'GHS' => 'Ghanaian Cedi',
		'GNF' => 'Guinean Franc',
		'HKD' => 'Hong Kong Dollar',
		'XDR' => 'Special Drawing Rights',
		'KES' => 'Kenyan Shilling',
		'KGS' => 'Kyrgyzstani Som',
		'LRD' => 'Liberian Dollar',
		'MOP' => 'Macanese Pataca',
		'MVR' => 'Maldivian Rufiyaa',
		'MXN' => 'Mexican Peso',
		'NAD' => 'Namibian Dollar',
		'NOK' => 'Norwegian Krone',
		'PLN' => 'Polish Zloty',
		'RUB' => 'Russian Ruble',
		'SZL' => 'Swazi Lilangeni',
		'TJS' => 'Tajikistani Somoni',
		'TTD' => 'Trinidad and Tobago Dollar',
		'UGX' => 'Ugandan Shilling',
		'UYU' => 'Uruguayan Peso',
		'VND' => 'Vietnamese Dong',
		'TND' => 'Tunisian Dinar',
		'UAH' => 'Ukrainian Hryvnia',
		'UZS' => 'Uzbekistani Som',
		'TMT' => 'Turkmenistan Manat',
		'GBP' => 'British Pound',
		'ZMW' => 'Zambian Kwacha',
		'BTC' => 'Bitcoin',
		'BYN' => 'New Belarusian Ruble',
		'BMD' => 'Bermudan Dollar',
		'GGP' => 'Guernsey Pound',
		'CLF' => 'Chilean Unit Of Account',
		'CUC' => 'Cuban Convertible Peso',
		'IMP' => 'Manx pound',
		'JEP' => 'Jersey Pound',
		'SVC' => 'Salvadoran Colón',
		'ZMK' => 'Old Zambian Kwacha',
		'XAG' => 'Silver (troy ounce)',
		'ZWL' => 'Zimbabwean Dollar',
	];

	public $currencySymbols = [
		'ALL' => 'Lek',
		'XCD' => '$',
		'EUR' => '€',
		'BBD' => '$',
		'BTN' => 'BTN',
		'BND' => '$',
		'XAF' => 'XAF',
		'CUP' => '$',
		'USD' => '$',
		'FKP' => '£',
		'GIP' => '£',
		'HUF' => 'Ft',
		'IRR' => '﷼',
		'JMD' => 'J$',
		'AUD' => '$',
		'LAK' => '₭',
		'LYD' => 'LYD',
		'MKD' => 'ден',
		'XOF' => 'XOF',
		'NZD' => '$',
		'OMR' => '﷼',
		'PGK' => 'PGK',
		'RWF' => 'RWF',
		'WST' => 'WST',
		'RSD' => 'Дин.',
		'SEK' => 'kr',
		'TZS' => 'TSh',
		'AMD' => 'AMD',
		'BSD' => '$',
		'BAM' => 'KM',
		'CVE' => 'CVE',
		'CNY' => '¥',
		'CRC' => '₡',
		'CZK' => 'Kč',
		'ERN' => 'ERN',
		'GEL' => 'GEL',
		'HTG' => 'HTG',
		'INR' => '₹',
		'JOD' => 'JOD',
		'KRW' => '₩',
		'LBP' => '£',
		'MWK' => 'MWK',
		'MRO' => 'MRO',
		'MZN' => 'MZN',
		'ANG' => 'ƒ',
		'PEN' => 'S/.',
		'QAR' => '﷼',
		'STD' => 'STD',
		'SLL' => 'SLL',
		'SOS' => 'S',
		'SDG' => 'SDG',
		'SYP' => '£',
		'AOA' => 'AOA',
		'AWG' => 'ƒ',
		'BHD' => 'BHD',
		'BZD' => 'BZ$',
		'BWP' => 'P',
		'BIF' => 'BIF',
		'KYD' => '$',
		'COP' => '$',
		'DKK' => 'kr',
		'GTQ' => 'Q',
		'HNL' => 'L',
		'IDR' => 'Rp',
		'ILS' => '₪',
		'KZT' => 'лв',
		'KWD' => 'KWD',
		'LSL' => 'LSL',
		'MYR' => 'RM',
		'MUR' => '₨',
		'MNT' => '₮',
		'MMK' => 'MMK',
		'NGN' => '₦',
		'PAB' => 'B/.',
		'PHP' => '₱',
		'RON' => 'lei',
		'SAR' => '﷼',
		'SGD' => '$',
		'ZAR' => 'R',
		'SRD' => '$',
		'TWD' => 'NT$',
		'TOP' => 'TOP',
		'VEF' => 'VEF',
		'DZD' => 'DZD',
		'ARS' => '$',
		'AZN' => 'ман',
		'BYR' => 'p.',
		'BOB' => '$b',
		'BGN' => 'лв',
		'CAD' => '$',
		'CLP' => '$',
		'CDF' => 'CDF',
		'DOP' => 'RD$',
		'FJD' => '$',
		'GMD' => 'GMD',
		'GYD' => '$',
		'ISK' => 'kr',
		'IQD' => 'IQD',
		'JPY' => '¥',
		'KPW' => '₩',
		'LVL' => 'Ls',
		'CHF' => 'Fr.',
		'MGA' => 'MGA',
		'MDL' => 'MDL',
		'MAD' => 'MAD',
		'NPR' => '₨',
		'NIO' => 'C$',
		'PKR' => '₨',
		'PYG' => 'Gs',
		'SHP' => '£',
		'SCR' => '₨',
		'SBD' => '$',
		'LKR' => '₨',
		'THB' => '฿',
		'TRY' => 'TRY',
		'AED' => 'AED',
		'VUV' => 'VUV',
		'YER' => '﷼',
		'AFN' => '؋',
		'BDT' => 'BDT',
		'BRL' => 'R$',
		'KHR' => '៛',
		'KMF' => 'KMF',
		'HRK' => 'kn',
		'DJF' => 'DJF',
		'EGP' => '£',
		'ETB' => 'ETB',
		'XPF' => 'XPF',
		'GHS' => 'GHS',
		'GNF' => 'GNF',
		'HKD' => '$',
		'XDR' => 'XDR',
		'KES' => 'KSh',
		'KGS' => 'лв',
		'LRD' => '$',
		'MOP' => 'MOP',
		'MVR' => 'MVR',
		'MXN' => '$',
		'NAD' => '$',
		'NOK' => 'kr',
		'PLN' => 'zł',
		'RUB' => 'руб',
		'SZL' => 'SZL',
		'TJS' => 'TJS',
		'TTD' => 'TT$',
		'UGX' => 'USh',
		'UYU' => '$U',
		'VND' => '₫',
		'TND' => 'TND',
		'UAH' => '₴',
		'UZS' => 'лв',
		'TMT' => 'TMT',
		'GBP' => '£',
		'ZMW' => 'ZMW',
		'BTC' => 'BTC',
		'BYN' => 'p.',
		'BMD' => 'BMD',
		'GGP' => 'GGP',
		'CLF' => 'CLF',
		'CUC' => 'CUC',
		'IMP' => 'IMP',
		'JEP' => 'JEP',
		'SVC' => 'SVC',
		'ZMK' => 'ZMK',
		'XAG' => 'XAG',
		'ZWL' => 'ZWL',
	];

}
