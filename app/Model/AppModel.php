<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('EmailLib', 'Lib');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */

/* Copied from Drupal search module, except for \x{0}-\x{2f} that has been replaced by \x{0}-\x{2c}\x{2e}-\x{2f} in order to keep the char '-' */
define('PREG_CLASS_SEARCH_EXCLUDE',
'\x{0}-\x{2c}\x{2e}-\x{2f}\x{3a}-\x{40}\x{5b}-\x{60}\x{7b}-\x{bf}\x{d7}\x{f7}\x{2b0}-'.
'\x{385}\x{387}\x{3f6}\x{482}-\x{489}\x{559}-\x{55f}\x{589}-\x{5c7}\x{5f3}-'.
'\x{61f}\x{640}\x{64b}-\x{65e}\x{66a}-\x{66d}\x{670}\x{6d4}\x{6d6}-\x{6ed}'.
'\x{6fd}\x{6fe}\x{700}-\x{70f}\x{711}\x{730}-\x{74a}\x{7a6}-\x{7b0}\x{901}-'.
'\x{903}\x{93c}\x{93e}-\x{94d}\x{951}-\x{954}\x{962}-\x{965}\x{970}\x{981}-'.
'\x{983}\x{9bc}\x{9be}-\x{9cd}\x{9d7}\x{9e2}\x{9e3}\x{9f2}-\x{a03}\x{a3c}-'.
'\x{a4d}\x{a70}\x{a71}\x{a81}-\x{a83}\x{abc}\x{abe}-\x{acd}\x{ae2}\x{ae3}'.
'\x{af1}-\x{b03}\x{b3c}\x{b3e}-\x{b57}\x{b70}\x{b82}\x{bbe}-\x{bd7}\x{bf0}-'.
'\x{c03}\x{c3e}-\x{c56}\x{c82}\x{c83}\x{cbc}\x{cbe}-\x{cd6}\x{d02}\x{d03}'.
'\x{d3e}-\x{d57}\x{d82}\x{d83}\x{dca}-\x{df4}\x{e31}\x{e34}-\x{e3f}\x{e46}-'.
'\x{e4f}\x{e5a}\x{e5b}\x{eb1}\x{eb4}-\x{ebc}\x{ec6}-\x{ecd}\x{f01}-\x{f1f}'.
'\x{f2a}-\x{f3f}\x{f71}-\x{f87}\x{f90}-\x{fd1}\x{102c}-\x{1039}\x{104a}-'.
'\x{104f}\x{1056}-\x{1059}\x{10fb}\x{10fc}\x{135f}-\x{137c}\x{1390}-\x{1399}'.
'\x{166d}\x{166e}\x{1680}\x{169b}\x{169c}\x{16eb}-\x{16f0}\x{1712}-\x{1714}'.
'\x{1732}-\x{1736}\x{1752}\x{1753}\x{1772}\x{1773}\x{17b4}-\x{17db}\x{17dd}'.
'\x{17f0}-\x{180e}\x{1843}\x{18a9}\x{1920}-\x{1945}\x{19b0}-\x{19c0}\x{19c8}'.
'\x{19c9}\x{19de}-\x{19ff}\x{1a17}-\x{1a1f}\x{1d2c}-\x{1d61}\x{1d78}\x{1d9b}-'.
'\x{1dc3}\x{1fbd}\x{1fbf}-\x{1fc1}\x{1fcd}-\x{1fcf}\x{1fdd}-\x{1fdf}\x{1fed}-'.
'\x{1fef}\x{1ffd}-\x{2070}\x{2074}-\x{207e}\x{2080}-\x{2101}\x{2103}-\x{2106}'.
'\x{2108}\x{2109}\x{2114}\x{2116}-\x{2118}\x{211e}-\x{2123}\x{2125}\x{2127}'.
'\x{2129}\x{212e}\x{2132}\x{213a}\x{213b}\x{2140}-\x{2144}\x{214a}-\x{2b13}'.
'\x{2ce5}-\x{2cff}\x{2d6f}\x{2e00}-\x{3005}\x{3007}-\x{303b}\x{303d}-\x{303f}'.
'\x{3099}-\x{309e}\x{30a0}\x{30fb}\x{30fd}\x{30fe}\x{3190}-\x{319f}\x{31c0}-'.
'\x{31cf}\x{3200}-\x{33ff}\x{4dc0}-\x{4dff}\x{a015}\x{a490}-\x{a716}\x{a802}'.
'\x{e000}-\x{f8ff}\x{fb29}\x{fd3e}-\x{fd3f}\x{fdfc}-\x{fdfd}'.
'\x{fd3f}\x{fdfc}-\x{fe6b}\x{feff}-\x{ff0f}\x{ff1a}-\x{ff20}\x{ff3b}-\x{ff40}'.
'\x{ff5b}-\x{ff65}\x{ff70}\x{ff9e}\x{ff9f}\x{ffe0}-\x{fffd}');

define('PREG_CLASS_NUMBERS',
'\x{30}-\x{39}\x{b2}\x{b3}\x{b9}\x{bc}-\x{be}\x{660}-\x{669}\x{6f0}-\x{6f9}'.
'\x{966}-\x{96f}\x{9e6}-\x{9ef}\x{9f4}-\x{9f9}\x{a66}-\x{a6f}\x{ae6}-\x{aef}'.
'\x{b66}-\x{b6f}\x{be7}-\x{bf2}\x{c66}-\x{c6f}\x{ce6}-\x{cef}\x{d66}-\x{d6f}'.
'\x{e50}-\x{e59}\x{ed0}-\x{ed9}\x{f20}-\x{f33}\x{1040}-\x{1049}\x{1369}-'.
'\x{137c}\x{16ee}-\x{16f0}\x{17e0}-\x{17e9}\x{17f0}-\x{17f9}\x{1810}-\x{1819}'.
'\x{1946}-\x{194f}\x{2070}\x{2074}-\x{2079}\x{2080}-\x{2089}\x{2153}-\x{2183}'.
'\x{2460}-\x{249b}\x{24ea}-\x{24ff}\x{2776}-\x{2793}\x{3007}\x{3021}-\x{3029}'.
'\x{3038}-\x{303a}\x{3192}-\x{3195}\x{3220}-\x{3229}\x{3251}-\x{325f}\x{3280}-'.
'\x{3289}\x{32b1}-\x{32bf}\x{ff10}-\x{ff19}');

define('PREG_CLASS_PUNCTUATION',
'\x{21}-\x{23}\x{25}-\x{2a}\x{2c}-\x{2f}\x{3a}\x{3b}\x{3f}\x{40}\x{5b}-\x{5d}'.
'\x{5f}\x{7b}\x{7d}\x{a1}\x{ab}\x{b7}\x{bb}\x{bf}\x{37e}\x{387}\x{55a}-\x{55f}'.
'\x{589}\x{58a}\x{5be}\x{5c0}\x{5c3}\x{5f3}\x{5f4}\x{60c}\x{60d}\x{61b}\x{61f}'.
'\x{66a}-\x{66d}\x{6d4}\x{700}-\x{70d}\x{964}\x{965}\x{970}\x{df4}\x{e4f}'.
'\x{e5a}\x{e5b}\x{f04}-\x{f12}\x{f3a}-\x{f3d}\x{f85}\x{104a}-\x{104f}\x{10fb}'.
'\x{1361}-\x{1368}\x{166d}\x{166e}\x{169b}\x{169c}\x{16eb}-\x{16ed}\x{1735}'.
'\x{1736}\x{17d4}-\x{17d6}\x{17d8}-\x{17da}\x{1800}-\x{180a}\x{1944}\x{1945}'.
'\x{2010}-\x{2027}\x{2030}-\x{2043}\x{2045}-\x{2051}\x{2053}\x{2054}\x{2057}'.
'\x{207d}\x{207e}\x{208d}\x{208e}\x{2329}\x{232a}\x{23b4}-\x{23b6}\x{2768}-'.
'\x{2775}\x{27e6}-\x{27eb}\x{2983}-\x{2998}\x{29d8}-\x{29db}\x{29fc}\x{29fd}'.
'\x{3001}-\x{3003}\x{3008}-\x{3011}\x{3014}-\x{301f}\x{3030}\x{303d}\x{30a0}'.
'\x{30fb}\x{fd3e}\x{fd3f}\x{fe30}-\x{fe52}\x{fe54}-\x{fe61}\x{fe63}\x{fe68}'.
'\x{fe6a}\x{fe6b}\x{ff01}-\x{ff03}\x{ff05}-\x{ff0a}\x{ff0c}-\x{ff0f}\x{ff1a}'.
'\x{ff1b}\x{ff1f}\x{ff20}\x{ff3b}-\x{ff3d}\x{ff3f}\x{ff5b}\x{ff5d}\x{ff5f}-'.
'\x{ff65}');

/**
 * Matches all CJK characters that are candidates for auto-splitting
 * (Chinese, Japanese, Korean).
 * Contains kana and BMP ideographs.
 */
define('PREG_CLASS_CJK', '\x{3041}-\x{30ff}\x{31f0}-\x{31ff}\x{3400}-\x{4db5}\x{4e00}-\x{9fbb}\x{f900}-\x{fad9}');

class AppModel extends Model {
	/**
	 * List of behaviors to load when the model object is initialized. Settings can be
	 * passed to behaviors by using the behavior name as index. Eg:
	 *
	 * var $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'))
	 *
	 * @var array
	 * @link http://book.cakephp.org/view/1072/Using-Behaviors
	 */
		public $actsAs = array(
			'Containable',
		);

	/**
	 * Number of associations to recurse through during find calls. Fetches only
	 * the first level by default.
	 *
	 * @var int
	 * @link http://book.cakephp.org/view/1057/Model-Attributes#recursive-1063
	 */
		public $recursive = -1;
		public $EMCMS_SEARCH_BLACKLIST = '4r5e';
		public $EMCMS_SEARCH_MIN_WORD_LENGTH = 3;
		public $EMCMS_SEARCH_MAX_WORD_LENGTH = 15;
		public $modelDirectory = null;


	/**
	 * Constructor. Binds the model's database table to the object.
	 *
	 *
	 * @param bool|int|string|array $id Set this ID for this model on startup,
	 * can also be an array of options, see above.
	 * @param string|false $table Name of database table to use.
	 * @param string $ds DataSource connection name.
	 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->modelDirectory = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $this->alias . DS;
	}

	/**
	 * send E-mail method
	 *
	 * @param mixed $to email or array of emails as recipients
	 * @param array $options list of options for email sending. Possible keys:
	 * @return boolean
	 */
	public static function __sendMail($emailTo, array $options = []) {
		EmailLib::__sendMail($emailTo, $options);
	}

	/**
	 * Replace all accented chars by their equivalent non accented chars.
	 *
	 * @param string $str
	 * @return string
	 */
		public function replaceAccentedChars($str) {
		    /* One source among others:
		        http://www.tachyonsoft.com/uc0000.htm
		        http://www.tachyonsoft.com/uc0001.htm
		        http://www.tachyonsoft.com/uc0004.htm
		    */
		    $patterns = array(

		        /* Lowercase */
		        /* a  */ '/[\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}\x{0101}\x{0103}\x{0105}\x{0430}\x{00C0}-\x{00C3}\x{1EA0}-\x{1EB7}]/u',
		        /* b  */ '/[\x{0431}]/u',
		        /* c  */ '/[\x{00E7}\x{0107}\x{0109}\x{010D}\x{0446}]/u',
		        /* d  */ '/[\x{010F}\x{0111}\x{0434}\x{0110}]/u',
		        /* e  */ '/[\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{0113}\x{0115}\x{0117}\x{0119}\x{011B}\x{0435}\x{044D}\x{00C8}-\x{00CA}\x{1EB8}-\x{1EC7}]/u',
		        /* f  */ '/[\x{0444}]/u',
		        /* g  */ '/[\x{011F}\x{0121}\x{0123}\x{0433}\x{0491}]/u',
		        /* h  */ '/[\x{0125}\x{0127}]/u',
		        /* i  */ '/[\x{00EC}\x{00ED}\x{00EE}\x{00EF}\x{0129}\x{012B}\x{012D}\x{012F}\x{0131}\x{0438}\x{0456}\x{00CC}\x{00CD}\x{1EC8}-\x{1ECB}\x{0128}]/u',
		        /* j  */ '/[\x{0135}\x{0439}]/u',
		        /* k  */ '/[\x{0137}\x{0138}\x{043A}]/u',
		        /* l  */ '/[\x{013A}\x{013C}\x{013E}\x{0140}\x{0142}\x{043B}]/u',
		        /* m  */ '/[\x{043C}]/u',
		        /* n  */ '/[\x{00F1}\x{0144}\x{0146}\x{0148}\x{0149}\x{014B}\x{043D}]/u',
		        /* o  */ '/[\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F8}\x{014D}\x{014F}\x{0151}\x{043E}\x{00D2}-\x{00D5}\x{01A0}\x{01A1}\x{1ECC}-\x{1EE3}]/u',
		        /* p  */ '/[\x{043F}]/u',
		        /* r  */ '/[\x{0155}\x{0157}\x{0159}\x{0440}]/u',
		        /* s  */ '/[\x{015B}\x{015D}\x{015F}\x{0161}\x{0441}]/u',
		        /* ss */ '/[\x{00DF}]/u',
		        /* t  */ '/[\x{0163}\x{0165}\x{0167}\x{0442}]/u',
		        /* u  */ '/[\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{0169}\x{016B}\x{016D}\x{016F}\x{0171}\x{0173}\x{0443}\x{00D9}-\x{00DA}\x{0168}\x{01AF}\x{01B0}\x{1EE4}-\x{1EF1}]/u',
		        /* v  */ '/[\x{0432}]/u',
		        /* w  */ '/[\x{0175}]/u',
		        /* y  */ '/[\x{00FF}\x{0177}\x{00FD}\x{044B}\x{1EF2}-\x{1EF9}\x{00DD}]/u',
		        /* z  */ '/[\x{017A}\x{017C}\x{017E}\x{0437}]/u',
		        /* ae */ '/[\x{00E6}]/u',
		        /* ch */ '/[\x{0447}]/u',
		        /* kh */ '/[\x{0445}]/u',
		        /* oe */ '/[\x{0153}]/u',
		        /* sh */ '/[\x{0448}]/u',
		        /* shh*/ '/[\x{0449}]/u',
		        /* ya */ '/[\x{044F}]/u',
		        /* ye */ '/[\x{0454}]/u',
		        /* yi */ '/[\x{0457}]/u',
		        /* yo */ '/[\x{0451}]/u',
		        /* yu */ '/[\x{044E}]/u',
		        /* zh */ '/[\x{0436}]/u',

		        /* Uppercase */
		        /* A  */ '/[\x{0100}\x{0102}\x{0104}\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}\x{0410}]/u',
		        /* B  */ '/[\x{0411}]/u',
		        /* C  */ '/[\x{00C7}\x{0106}\x{0108}\x{010A}\x{010C}\x{0426}]/u',
		        /* D  */ '/[\x{010E}\x{0110}\x{0414}]/u',
		        /* E  */ '/[\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{0112}\x{0114}\x{0116}\x{0118}\x{011A}\x{0415}\x{042D}]/u',
		        /* F  */ '/[\x{0424}]/u',
		        /* G  */ '/[\x{011C}\x{011E}\x{0120}\x{0122}\x{0413}\x{0490}]/u',
		        /* H  */ '/[\x{0124}\x{0126}]/u',
		        /* I  */ '/[\x{0128}\x{012A}\x{012C}\x{012E}\x{0130}\x{0418}\x{0406}]/u',
		        /* J  */ '/[\x{0134}\x{0419}]/u',
		        /* K  */ '/[\x{0136}\x{041A}]/u',
		        /* L  */ '/[\x{0139}\x{013B}\x{013D}\x{0139}\x{0141}\x{041B}]/u',
		        /* M  */ '/[\x{041C}]/u',
		        /* N  */ '/[\x{00D1}\x{0143}\x{0145}\x{0147}\x{014A}\x{041D}]/u',
		        /* O  */ '/[\x{00D3}\x{014C}\x{014E}\x{0150}\x{041E}]/u',
		        /* P  */ '/[\x{041F}]/u',
		        /* R  */ '/[\x{0154}\x{0156}\x{0158}\x{0420}]/u',
		        /* S  */ '/[\x{015A}\x{015C}\x{015E}\x{0160}\x{0421}]/u',
		        /* T  */ '/[\x{0162}\x{0164}\x{0166}\x{0422}]/u',
		        /* U  */ '/[\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{0168}\x{016A}\x{016C}\x{016E}\x{0170}\x{0172}\x{0423}]/u',
		        /* V  */ '/[\x{0412}]/u',
		        /* W  */ '/[\x{0174}]/u',
		        /* Y  */ '/[\x{0176}\x{042B}]/u',
		        /* Z  */ '/[\x{0179}\x{017B}\x{017D}\x{0417}]/u',
		        /* AE */ '/[\x{00C6}]/u',
		        /* CH */ '/[\x{0427}]/u',
		        /* KH */ '/[\x{0425}]/u',
		        /* OE */ '/[\x{0152}]/u',
		        /* SH */ '/[\x{0428}]/u',
		        /* SHH*/ '/[\x{0429}]/u',
		        /* YA */ '/[\x{042F}]/u',
		        /* YE */ '/[\x{0404}]/u',
		        /* YI */ '/[\x{0407}]/u',
		        /* YO */ '/[\x{0401}]/u',
		        /* YU */ '/[\x{042E}]/u',
		        /* ZH */ '/[\x{0416}]/u');

		        // ö to oe
		        // å to aa
		        // ä to ae

		    $replacements = array(
		            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 'ss', 't', 'u', 'v', 'w', 'y', 'z', 'ae', 'ch', 'kh', 'oe', 'sh', 'shh', 'ya', 'ye', 'yi', 'yo', 'yu', 'zh',
		            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'Y', 'Z', 'AE', 'CH', 'KH', 'OE', 'SH', 'SHH', 'YA', 'YE', 'YI', 'YO', 'YU', 'ZH'
		    );

		    return preg_replace($patterns, $replacements, $str);
		}

		public function sanitize($string = '', $indexation = false, $iso_code = false) {
		    $string = trim($string);
		    if (empty($string)) {
		        return '';
		    }

		    $string = EMCMS_strtolower(strip_tags($string));
		    $string = html_entity_decode($string, ENT_NOQUOTES, 'utf-8');

		    $string = preg_replace('/(['.PREG_CLASS_NUMBERS.']+)['.PREG_CLASS_PUNCTUATION.']+(?=['.PREG_CLASS_NUMBERS.'])/u', '\1', $string);
		    $string = preg_replace('/['.PREG_CLASS_SEARCH_EXCLUDE.']+/u', ' ', $string);

		    if ($indexation) {
		        $string = preg_replace('/[._-]+/', ' ', $string);
		    } else {
		        $words = explode(' ', $string);
		        $processed_words = array();
		        // search for aliases for each word of the query
		        foreach ($words as $word) {
		            $processed_words[] = $word;
		        }
		        $string = implode(' ', $processed_words);
		        $string = preg_replace('/[._]+/', '', $string);
		        $string = ltrim(preg_replace('/([^ ])-/', '$1 ', ' '.$string));
		        $string = preg_replace('/[._]+/', '', $string);
		        $string = preg_replace('/[^\s]-+/', '', $string);
		    }

		    // $blacklist = EMCMS_strtolower($this->EMCMS_SEARCH_BLACKLIST);
		    // covert blacklist to array and modify strtolowwer
		    $blacklist = Configure::read('EMCMS_SEARCH_BLACKLIST');
		    if (!empty($blacklist)) {
		    	# new added to support array blacklist
		    	if (is_array($blacklist)) {
		    		$blacklist = array_map('EMCMS_strtolower', $blacklist);
		    	}
		    	$blacklist = implode("|",$blacklist);
		        $string = preg_replace('/(?<=\s)('.$blacklist.')(?=\s)/Su', '', $string);
		        $string = preg_replace('/^('.$blacklist.')(?=\s)/Su', '', $string);
		        $string = preg_replace('/(?<=\s)('.$blacklist.')$/Su', '', $string);
		        $string = preg_replace('/^('.$blacklist.')$/Su', '', $string);
		    }

		    // If the language is constituted with symbol and there is no "words", then split every chars
		    if (in_array($iso_code, array('zh', 'tw', 'ja')) && function_exists('mb_strlen')) {
		        // Cut symbols from letters
		        $symbols = '';
		        $letters = '';
		        foreach (explode(' ', $string) as $mb_word) {
		            if (strlen($this->replaceAccentedChars($mb_word)) == mb_strlen($this->replaceAccentedChars($mb_word))) {
		                $letters .= $mb_word.' ';
		            } else {
		                $symbols .= $mb_word.' ';
		            }
		        }

		        if (preg_match_all('/./u', $symbols, $matches)) {
		            $symbols = implode(' ', $matches[0]);
		        }

		        $string = $letters.$symbols;
		    } elseif ($indexation) {
		        $minWordLen = (int)Configure::read('EMCMS_SEARCH_MIN_WORD_LENGTH');
		        if ($minWordLen > 1) {
		            $minWordLen -= 1;
		            $string = preg_replace('/(?<=\s)[^\s]{1,'.$minWordLen.'}(?=\s)/Su', ' ', $string);
		            $string = preg_replace('/^[^\s]{1,'.$minWordLen.'}(?=\s)/Su', '', $string);
		            $string = preg_replace('/(?<=\s)[^\s]{1,'.$minWordLen.'}$/Su', '', $string);
		            $string = preg_replace('/^[^\s]{1,'.$minWordLen.'}$/Su', '', $string);
		        }
		    }

		    $string = $this->replaceAccentedChars(trim(preg_replace('/\s+/', ' ', $string)));
		    return $string;
		}

	/**
	 * This function cache the queries
	 *
	 * @return arrat
	 */
		public function find($conditions = null, $fields = array(), $order = null, $recursive = null) {
			$doQuery = true;
			// check if we want the cache
			if (!empty($fields['cache'])) {
				$cacheConfig = null;
				// check if we have specified a custom config
				if (!empty($fields['cacheConfig'])) {
					$cacheConfig = $fields['cacheConfig'];
				}
				$cacheName = $this->name . '-' . $fields['cache'];
				// if so, check if the cache exists
				$data = Cache::read($cacheName, $cacheConfig);
				if ($data == false) {
					$data = parent::find($conditions, $fields, $order, $recursive);
					Cache::write($cacheName, $data, $cacheConfig);
				}
				$doQuery = false;
			}
			if ($doQuery) {
				$data = parent::find($conditions, $fields, $order, $recursive);
			}
			return $data;
		}

	/**
	 * lastError
	 *
	 * @return string [ Error message with error number]
	 */
		public function lastError() {
			$db = $this->getDataSource();
			return $db->lastError();
		}

	/**
	 * Enables HABTM-Validation
	 * e.g. with
	 * 'rule' => array('multiple', array('min' => 2))
	 *
	 * @return bool Success
	 */
		public function beforeValidate($options = []) {
			foreach ($this->hasAndBelongsToMany as $k => $v) {
				if (isset($this->data[$k][$k])) {
					$this->data[$this->alias][$k] = $this->data[$k][$k];
				}
			}
			return parent::beforeValidate($options);
		}

	/**
	 * Handle our HABTM relationship before saving the data
	 *
	 * @return void
	 */
		public function beforeSave($options = array()) {
			if (Configure::read('demo') === true && AppController::$demoBlockIgnore === false) {
				AppController::$demoBlocked = true;
				return false;
			}

			foreach(array_keys($this->hasAndBelongsToMany) as $model){
				if(isset($this->data[$this->name][$model])){
					$this->data[$model][$model] = $this->data[$this->name][$model];
					unset($this->data[$this->name][$model]);
				}
			}
			return parent::beforeSave($options);
		}

		public function beforeDelete($cascade = true) {
			if (Configure::read('demo') === true && AppController::$demoBlockIgnore === false) {
				AppController::$demoBlocked = true;
				return false;
			}
			return parent::beforeDelete($cascade);
		}

	/**
	 * Return the next auto increment id from the current table
	 * UUIDs will return false
	 *
	 * @return int next auto increment value or False on failure
	 */
		public function getNextAutoIncrement() {
			$query = "SHOW TABLE STATUS WHERE name = '" . $this->tablePrefix . $this->table . "'";
			$result = $this->query($query);
			if (!isset($result[0]['TABLES']['Auto_increment'])) {
				return false;
			}
			return (int)$result[0]['TABLES']['Auto_increment'];
		}

	/**
	 * This method generates a slug from a title
	 *
	 * @param  string $title The title or name
	 * @param  string $id The ID of the model
	 * @return string Slug
	 */
		public function generateSlug($title = null, $id = null, $separator = '-') {
			if (!$title) {
				throw new NotFoundException(__('Invalid Title'));
			}

			$title = EMCMS_strtolower(strip_tags($title));
			$title = html_entity_decode($title, ENT_NOQUOTES, 'utf-8');
			$slug  = Inflector::slug($title, $separator);
			$slug  = $this->replaceAccentedChars(trim(preg_replace('/\s+/', ' ', $slug)));

			$conditions = array();
			$conditions[$this->alias . '.slug'] = $slug;

			if ($id) {
				$conditions[$this->primaryKey. ' NOT'] = $id;
			}

			$total = $this->find('count', array('conditions' => $conditions, 'recursive' => -1));
			if ($total > 0) {
				for ($number = 2; $number > 0; $number ++) {
					$conditions[$this->alias . '.slug'] = $slug . $separator . $number;

					$total = $this->find('count', array('conditions' => $conditions, 'recursive' => -1));
					if ($total == 0) {
						return $slug . $separator . $number;
					}
				}
			}
			return $slug;
		}

	/**
	 * Random string generator function
	 *
	 * This function will randomly generate a password from a given set of characters
	 *
	 * @param int = 8, length of the password you want to generate
	 * @param string = 0123456789abcdefghijklmnopqrstuvwxyz all possible values
	 * @return string, the password
	 */
		public function generateRandomString($length = 8, $options = array()) {
			// initialize variables
			$password = "";
			$i = 0;
			$possible = '';

			$numerals = '0123456789';
			$lowerAlphabet = 'abcdefghijklmnopqrstuvwxyz';
			$upperAlphabet = EMCMS_strtoupper($lowerAlphabet);
			$symbols = '$#@!~`%^&*()_+-=|}{\][:;<>.,/?';

			$defaultOptions = array('type'=>'alphanumeric', 'case'=>'mixed');

			$options = array_merge($defaultOptions, $options);

			$possible = $numerals;
			if ($options['case'] == 'lower') {
				$possible .= $lowerAlphabet;
			} elseif ($options['case'] == 'upper') {
				$possible .= $upperAlphabet;
			} elseif ($options['case'] == 'mixed') {
				$possible .= $lowerAlphabet.$upperAlphabet;
			}
			if ($options['type'] != 'alphanumeric') {
				$possible .= $symbols;
			}

			// add random characters to $password until $length is reached
			while ($i < $length) {
				// pick a random character from the possible ones
				$char = EMCMS_substr($possible, mt_rand(0, EMCMS_strlen($possible)-1), 1);
				// we don't want this character if it's already in the password
				if (!strstr($password, $char)) {
					$password .= $char;
					$i++;
				}
			}
			return $password;
		}

	/**
	 * This function matches two fields - a useful extension for Cake Validation
	 *
	 * @param string|array $check Value to check
	 * @param string $compareField The field to compare
	 * @return boolean Success
	 */
		public function matchFields($check = array(), $compareField = null) {
			$value = array_shift($check);
			if (!empty($value) && !empty($this->data[$this->name][$compareField])) {
				if ($value !== $this->data[$this->name][$compareField]) {
					return false;
				}
			}
			return true;
		}

	/**
	 * Unbinds all associated models that are attached to the current model.
	 *
	 * @param  array $params Array of models to un-associate
	 */
		public function unbindAll($params = array()){
			$unbind = array();

			foreach ($this->belongsTo as $model=>$info) {
				$unbind['belongsTo'][] = $model;
			}

			foreach ($this->hasOne as $model=>$info) {
				$unbind['hasOne'][] = $model;
			}

			foreach ($this->hasMany as $model=>$info) {
				$unbind['hasMany'][] = $model;
			}

			foreach ($this->hasAndBelongsToMany as $model=>$info) {
				$unbind['hasAndBelongsToMany'][] = $model;
			}
			parent::unbindModel($unbind);
			return true;
		}

	/**
	 * A nice little validate data method
	 * @param  array  $data
	 * @return boolean
	 */
		public function validate($data = array()) {
			if (!$data) {
				throw new NotFoundException(__('Invalid Data'));
			}

			$this->set($data);
			return $this->validates();
		}

	/**
	 * @brief wrapper for transactions
	 *
	 * Allow you to easily call transactions manually if you need to do saving
	 * of lots of data, or just nested relations etc.
	 *
	 * @code
	 *	// start a transaction
	 *	$this->transaction();
	 *
	 *	// rollback if things are wrong (undo)
	 *	$this->transaction(false);
	 *
	 *	// commit the sql if all is good
	 *	$this->transaction(true);
	 * @endcode
	 *
	 * @access public
	 *
	 * @param mixed $action what the command should do
	 *
	 * @return see the methods for tranasactions in cakephp dbo
	 */
		public function transaction($action = null) {
			$this->__dataSource = $this->getDataSource();

			$return = false;

			if($action === null) {
				$return = $this->__dataSource->begin($this);
			}

			else if($action === true) {
				$return = $this->__dataSource->commit($this);
			}

			else if($action === false) {
				$return = $this->__dataSource->rollback($this);
			}

			return $return;
		}

}
