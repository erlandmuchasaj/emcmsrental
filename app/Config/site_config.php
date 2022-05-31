<?php
/**
 * I've put a lot of time and effort into making `EMCMS Rental Script` awesome. If
 * you love it, you can
 *   _
 *  | |__    _   _   _   _     _ __ ___     ___
 *  | '_ \  | | | | | | | |   | '_ ` _ \   / _ \
 *  | |_) | | |_| | | |_| |   | | | | | | |  __/
 *  |_.__/   \__,_|  \__, |   |_| |_| |_|  \___|
 *                   |___/
 *                             __    __                      __
 *    __ _      ___    ___    / _|  / _|   ___    ___     _  \ \
 *   / _` |    / __|  / _ \  | |_  | |_   / _ \  / _ \   (_)  | |
 *  | (_| |   | (__  | (_) | |  _| |  _| |  __/ |  __/    _   | |
 *   \__,_|    \___|  \___/  |_|   |_|    \___|  \___|   ( )  |_|
 * 
 * @link(Erland Muchasaj, http://www.erlandmuchasaj.com/)
 * https://www.brandalmanac.com/move/
 * https://www.makereign.com/
 *
 */

// Paypal Configuration Credentials
$config['PayPal'] = [
	'API_username'   => 'erlandi_20-facilitator_api1.hotmail.com',
	'API_password'   => 'C54BURK3UWMQKPCN',
	'API_signature'  => 'AJaSZvMmqgyAMODA8CnX1wYcW.ckA..ZYEWq2hep2nkn6aaGZkH2D4tB',
	'APP_ID'		 => 'APP-80W284485P519543T',
	'LOGIN_CLIENT_ID'=> 'ATsfTjJogq7dDuySiNMrLqsWFSIwViqpyjVH7109VIB2uxOTNcR3l-LTboGspsxntyJV6FdCaA2OyE7G',
	'LOGIN_SECRET'   => 'EPYnRdwXCSIdvQvTcaotznysh-6VBZg4XumFDQCUN8HaUPP5_lPlUoo8VZsNeI5pOa7IfXSFtm6kYJWe',
	'SANDBOX_flag'   => true,
	'RETURN_url'     => rtrim(Configure::read('App.fullBaseUrl'), '/\\') . '/paymentSuccess',
	'CANCEL_url'     => rtrim(Configure::read('App.fullBaseUrl'), '/\\') . '/paymentCancel',
	'IPN_url'   	 => rtrim(Configure::read('App.fullBaseUrl'), '/\\') . '/paymentIpn',
	'PAYMENT_type'   => 'Sale',
	'CURRENCY_code'  => 'USD',
	'enabled' 		 => true,
];

// Stripe Configuration Credentials
$config['Stripe'] = [
	'Secret'=> 'sk_test_tqgfn8bxdbNOEVCsO2uBXY3c',
	'Publishable'=> 'pk_test_HOEZH30MPZ7DTgkw2nWmLLyB',
	'mode'      => 'Test',
	'currency'  => 'usd',
	'fields'    => [
		'stripe_id' => 'id',
		'stripe_last4' => [
			'card' => 'last4',
		],
		'stripe_address_zip_check' => [
			'card' => 'address_zip_check',
		],
		'stripe_cvc_check' => [
			'card' => 'cvc_check',
		],
		'stripe_amount' => 'amount',
	],
	'enabled' => true,
];

// TwoCheckout Configuration Credentials
$config['TwoCheckout'] = [
	'sandbox' => [
		'publishableKey' => 'C1F8FD30-3A20-498B-B9D9-E595E59E2B99',
		'privateKey' => '7ABA4648-4142-4229-B518-D772D0BC13F6',
		'username' => 'erlandmuchasaj',
		'password' => '',
		'sellerId' => '901403601',
	],
	'live' => [
		'publishableKey' => '',
		'privateKey' => '',
		'username' => '',
		'password' => '',
		'sellerId' => '',
	],
	'mode' => 'sandbox',
	'foramt' => 'array', // array | json, default - array
	'verifySSL'  => false,
	'currency'  => 'usd',
	'enabled' => false,
];

// google Map Default Setting
$config['Google'] = [
	'key'  => 'AIzaSyCZH6qxBhkmUjVS9kd5of6cqMKBHiBbVxQ',
	'api'  => '2',
	'zoom' => 13,
	'lat'  => 51,
	'lng'  => 11,
	'type' => 'roadmap',
	'static_size' => '480x320',
];

// Twilio messaging system API credencials
$config['Twilio'] = [
	'sandbox' => [
		'AccountSid' => 'ACde8fc5dfc06bb138b2316f5481e0e36e',
		'AuthToken' => '5f962e713051ac579423107e2a3f91aa',
		'from' => '+15005550006',
	],
	'live' => [
		'AccountSid' => 'AC4a74f26487760fb52e7d86ef07b7546e',
		'AuthToken' => '8d60b03784db912ee84e142876ece651',
		'from' => '+19179094833',
	],
	'mode' => 'sandbox',
	'enabled' => true,
];

// Media Gallery Credentials
$config['Media'] = [
	'ALLOWED_EXTENTIONS'=> ['jpg', 'jpeg', 'png'],
	'ICON'  => 60,
	'XSMALL_THUMBNAIL'  => 150,
	'SMALL_THUMBNAIL'   => 300,
	'MEDIUM_THUMBNAIL'  => 600,
	'LARGE_THUMBNAIL'   => 1024,
	'XLARGE_THUMBNAIL'  => 2048,
	'FILE_LIMIT'        => 10485760,  // 10*1024*1024 = 10MB;
];

/**
 * CakePHP Demo Mode:
 */
$config['demo'] = false;

/**
 * CakePHP Maintenance:
 */
$config['Maintenance'] = [
	'enable' => false,
];

// Application wide default website data
$config['Website'] = [
	'name'     => 'EMCMS', //  Configure::read('Website.name')
	'sitename' => 'EMCMS Rentals',
	'tagline'  => __('Rent unique places to stay from local hosts in 190+ countries.'),
	'slogan'   => __('Best Rental Script'),
	'homepage_version' => 'v2', // v1 | v2 | v3
	'disable_registration' => false, // true | false
	'copyright' => 'EMCMS, Inc.',
	'powered_by'=> 'Erland Muchasaj',
	'per_page_count' => '20', // 5, 10, 15, 20, 25, 30, 50, 100
	'max_img_pic_property' => '20',  // 5, 10, 15, 20, 25, 30, 35, 40, 45, 50
	'property_limit' => '3',
	'can_users_list' => false,
	'language' => 'en',
	'currency' => 'EUR',
	'timezone' => 'Europe/Amsterdam',
	'address'   => 'Rr. Budi, Tirane, Albania.',
	'contact_number' => '+355672190020',
	'email'     => 'info@erlandmuhcasaj.com',
	'google_analytics_active' => false,
	'google_analytics' => null, // text area.
	'version' => '1.0.0', // Script version
	// currency entiti data
	'currency_entity' => '&euro;',
	'currency_decimal' => '&#8364;',
	'currency_symbol' => '€',
	'currency_position' => '%1$s %2$s', # [%2$s] - price, [%1$s] - currency
	'currency_format' => [
		'thousands' => ',',
		'decimals' => '.'
	],
	// seo related data
	'meta_title' => __('Vacation Rentals, Homes, Experiences &amp; Places - EMCMS'),
	'meta_keywords' => __('Vacation Rentals, Homes, Experiences &amp; Places'),
	'meta_description' => __('Unforgettable trips start with EMCMS. Find adventures nearby or in faraway places and access unique homes, experiences, and places around the world.'),
	// social media links
	'facebook' => null,
	'twitter' => null,
	'pinterest' => null,
	'linkedin' => null,
	'googleplus' => null,
	'instagram' => null,
	'tumblr' => null,
	'youtube' => null,
	'vimeo' => null,
	// ofline messages
	'site_status' => false,
	'offline_message' => __('We are under maintenance'),
	# email related configuration
	'instant_mail' 	 => true,	# send mails directly throught 3rd party
	'email_driver' 	 => 'smtp',	# smtp, default, fast, mailtrap 
	'email_provider' => 'Smtp',	# Mailtrap, Smtp, Sendgrid, Sendinblue
	#=================== EDIT ONLY BELOW HERE ============================#
	'email_host' 	 => 'mail.erlandmuchasaj.com', # host name
	'email_username' => 'do-not-reply@erlandmuchasaj.com', 	 # username aka email
	'email_password' => '0aBhbzSmIvAp', # email password
	'email_port' 	 => 587,			# port
	'email_timeout'  => 30,				# timeout
	'email_from' 	 => 'do-not-reply@erlandmuchasaj.com', # deliver email
	'email_from_name'=> 'EMCMS',		# Name
	'email_tls'		 => false,
	'email_log'		 => false,
	'email_client'	 => null,
	'email_ssl_allow_self_signed' => false,
];

/**
 * Used for autorouting of pages
 * Application wide default website data
 */
$config['EmcmsPages'] = [
	'routes' => [
		'autoRouting' => true,
		'autoRoutingIgnoreRoutes' => 'index|add|view|edit|display|delete|maintenance|main|admin|users|blog|reviews|experiences|wishlists|faqs|login|logout',
	],
	'blocks' => true,
	'articles' => true,
	'leads' => true,
	'redirects' => true,
	'additionalAdminMenu' => [],
	'checkInstall' => true,
	'theme' => '',
	'adminTheme' => '',
];

// Application wide default options for Froala
$config['Froala'] = [
	'height'    => 300,
	'width'     => 'auto',
	'heightMin' => 200,
	'disableRightClick' => true,
	'htmlAllowComments' => false,
	'direction'     => 'ltr',
	'tabSpaces'     => 4,
	'spellcheck'    => true,
	'shortcutsHint' => true,
	'placeholderText' => __('Type Something here'),
];

/**
 * Mail component credentials
 */
$config['Mail'] = [
	'enabled'    => true,
	'debug_mode' => (bool)Configure::read('debug'),
	'providers' => [
		'Smtp' => [
			'host' 	   => 'mail.erlandmuchasaj.com',# host
			'username' => 'do-not-reply@erlandmuchasaj.com', # username
			'password' => '0aBhbzSmIvAp', 	# password
			'port' 	   => 587,			 	# port
			'timeout'  => 30, 				# timeout
			'enabled'  => true,
		],
		'Sendgrid' => [
			'host' 	   => 'smtp.sendgrid.net',# host
			'username' => 'erlandmuchasaj',	# username
			'password' => 'erlandi852123', 	# password
			'port' 	   => 587,			 	# port
			'timeout'  => 30, 				# timeout
			'enabled'  => true,
		],
		'Sendinblue' => [
			'host' 	   => 'smtp-relay.sendinblue.com', # host
			'username' => 'erland.muchasaj@gmail.com', # username
			'password' => 'jNT1OYbptU9rdHv4',		   # password
			'port' 	   => 587,			 	 		   # port
			'timeout'  => 30, 				 		   # timeout
			'enabled'  => true,
		],
		'Mailgun' => [
			'host' 	   => 'smtp.mailgun.org',# host
			'username' => 'postmaster@sandboxfbe5e52e942041e9a46c27049afcac31.mailgun.org',  # username
			'password' => 'xxxxxxxxxxxxxx',  # password
			'port' 	   => 25,			 	 # port
			'timeout'  => 30, 				 # timeout
			'enabled'  => true,
		],
		'Mailtrap' => [
			'host' 	   => 'smtp.mailtrap.io',# host
			'username' => '7d309d46384602',  # username
			'password' => '5f8f6d470dda15',  # password
			'port' 	   => 2525,			 	 # port
			'timeout'  => 30, 				 # timeout
			'enabled'  => true,
		],
	],
];


/**
 * HybridAuth component credentials
 */
$config['Hybridauth'] = [
	'enabled'    => true,
	'debug_mode' => (bool)Configure::read('debug'),
	'debug_file' => LOGS . 'hybridauth.log',
	// Location where to redirect users once they authenticate,
	// For this example we choose to come back to this same script.
	// 'base_url' => 'http://localhost/emcmsrentals/social_endpoint',
	'base_url' => rtrim(Configure::read('App.fullBaseUrl'), '/\\') . '/social_endpoint',
	'providers' => [
		// openid providers
		'Google' => [
			'enabled' => true,
			'keys' => [
				'id' => '660647825618-4cmmlfpi25sjmool6jc1dt3efq2kt98e.apps.googleusercontent.com',
				'secret' => 'RFr8bSKA6SFY6zUibF63ZNGg',
			],
			# this is the format of return url on google.
			// 'redirect_uri' => 'http://mywebsite.com/social_endpoint?hauth.done=Google',
		],
		'GitHub' => [
			'enabled' => true,
			'keys' => [
				'id' => '0449dd38c1c8982e3bbf', 
				'key' => null, 
				'secret' => 'd4e1fc2e37d05efb4854567e25ed139408d62dc2',
			],
			'scope' => 'user,read'
			# 'redirect_uri' => 'http://mywebsite.com/social_endpoint?hauth.done=GitHub'
		],
		'Twitter' => [
			'enabled' => false,
			'keys' => [
				'key' => 'BofoggMnsbBqtfbJ7TRFsgAKr', 
				'secret' => 'lEvn7vKPMPqI6xzc6mf3GxKvJouoaw4bB8t24tkWNbRbbDCPDy',
			],
			'includeEmail' => true,
		],
		'Facebook' => [
			'enabled' => false,
			'keys' => [
				'id' =>'120966618318988',
				'secret' => '4704fc4f60576650d23717f896d45da3'
			],
			'trustForwarded' => false,
		],
		'OpenID' => [
			'enabled' => false,
			'keys' => ['id' => '', 'secret' => ''],
		],
		'Yahoo' => [
			'enabled' => false,
			'keys' => ['id' => '', 'secret' => ''],
		],
		'AOL' => [
			'enabled' => false,
			'keys' => ['id' => '', 'secret' => ''],
		],
		'Live' => [
			'enabled' => false,
			'keys' => ['id' => '', 'secret' => ''],
		],
		'MySpace' => [
			'enabled' => false,
			'keys' => ['key' => '', 'secret' => ''],
		],
		'LinkedIn' => [
			'enabled' => false,
			'keys' => ['key' => '', 'secret' => ''],
		],
		'Foursquare' => [
			'enabled' => false,
			'keys' => ['id' => '', 'secret' => ''],
		],
	],
];

// Search Configuration parameters
$config['EMCMS_SEARCH_MIN_WORD_LENGTH'] = 3;
$config['EMCMS_SEARCH_MAX_WORD_LENGTH'] = 15;
$config['EMCMS_SEARCH_START'] = '%';
$config['EMCMS_SEARCH_END'] = '%';

// word to be blacklisted
$config['EMCMS_SEARCH_BLACKLIST'] = ['adderall', 'adipex', 'advicer', 'ambien', 'baccarat', 'baccarrat', 'blackjack', 'bllogspot', 'booker', 'byob', 'car-rental-e-site', 'car-rentals-e-site', 'carisoprodol', 'casino', 'casinos', 'chatroom', 'cialis', 'citalopram', 'clomid', 'coolcoolhu', 'coolhu', 'credit-card-debt', 'credit-report-4u', 'cwas', 'cyclen', 'cyclobenzaprine', 'cymbalta', 'dating-e-site', 'day-trading', 'debt-consolidation', 'debt-consolidation-consultant', 'discreetordering', 'doxycycline', 'duty-free', 'dutyfree', 'ephedra', 'equityloans', 'facial', 'femdom', 'fetish', 'fioricet', 'flowers-leading-site', 'freenet', 'freenet-shopping', 'fucking', 'gambling', 'gambling-', 'hair-loss', 'health-insurancedeals-4u', 'holdem', 'holdempoker', 'holdemsoftware', 'holdemtexasturbowilson', 'homeequityloans', 'homefinance', 'hotel-dealse-site', 'hotele-site', 'hotelse-site', 'hydrocodone', 'incest', 'insurance-quotesdeals-4u', 'insurancedeals-4u', 'jrcreations', 'levitra', 'lexapro', 'lipitor', 'lorazepam', 'macinstruct', 'mortgage-4-u', 'mortgagequotes', 'online-gambling', 'onlinegambling-4u', 'ottawavalleyag', 'ownsthis', 'oxycodone', 'oxycontin', 'palm-texas-holdem-game', 'paxil', 'penis', 'percocet', 'pharmacy', 'phentermine', 'poker', 'poker-chip', 'porn', 'poze', 'propecia', 'pussy', 'rental-car-e-site', 'ringtone', 'ringtones', 'roulette', 'sex', 'shemale', 'shoes', 'slot-machine', 'texas', 'holdem', 'texas-holdem', 'thorcarlson', 'top-e-site', 'top-site', 'tramadol', 'trim-spa', 'ultram', 'valeofglamorganconservatives', 'valium', 'valtrex', 'viagra', 'vioxx', 'xanax', 'zolus', 'fuck', 'assfucker', '4r5e', '50 yard cunt punt', '5h1t', '5hit', 'a_s_s', 'a2m', 'a55', 'adult', 'amateur', 'anal', 'anal impaler', 'anal leakage', 'anilingus', 'anus', 'ar5e', 'arrse', 'arse', 'arsehole', 'ass', 'ass fuck', 'asses', 'assfucker', 'ass-fucker', 'assfukka', 'asshole', 'asshole', 'assholes', 'assmucus', 'assmunch', 'asswhole', 'autoerotic', 'b!tch', 'b00bs', 'b17ch', 'b1tch', 'ballbag', 'ballsack', 'bang (one\'s) box', 'bangbros', 'bareback', 'bastard', 'beastial', 'beastiality', 'beef curtain', 'bellend', 'bestial', 'bestiality', 'bi+ch', 'biatch', 'bimbos', 'birdlock', 'bitch', 'bitch tit', 'bitcher', 'bitchers', 'bitches', 'bitchin', 'bitching', 'bloody', 'blow job', 'blow me', 'blow mud', 'blowjob', 'blowjobs', 'blue waffle', 'blumpkin', 'boiolas', 'bollock', 'bollok', 'boner', 'boob', 'boobs', 'booobs', 'boooobs', 'booooobs', 'booooooobs', 'breasts', 'buceta', 'bugger', 'bum', 'bunny fucker', 'bust a load', 'busty', 'butt', 'butt fuck', 'butthole', 'buttmuch', 'buttplug', 'c0ck', 'c0cksucker', 'carpet muncher', 'carpetmuncher', 'cawk', 'chink', 'choade', 'chota bags', 'cipa', 'cl1t', 'clit', 'clit licker', 'clitoris', 'clits', 'clitty litter', 'clusterfuck', 'cnut', 'cock', 'cock pocket', 'cock snot', 'cockface', 'cockhead', 'cockmunch', 'cockmuncher', 'cocks', 'cocksuck', 'cocksucked', 'cocksucker', 'cock-sucker', 'cocksucking', 'cocksucks', 'cocksuka', 'cocksukka', 'cok', 'cokmuncher', 'coksucka', 'coon', 'cop some wood', 'cornhole', 'corp whore', 'cox', 'cum', 'cum chugger', 'cum dumpster', 'cum freak', 'cum guzzler', 'cumdump', 'cummer', 'cumming', 'cums', 'cumshot', 'cunilingus', 'cunillingus', 'cunnilingus', 'cunt', 'cunt hair', 'cuntbag', 'cuntlick', 'cuntlicker', 'cuntlicking', 'cunts', 'cuntsicle', 'cunt-struck', 'cut rope', 'cyalis', 'cyberfuc', 'cyberfuck', 'cyberfucked', 'cyberfucker', 'cyberfuckers', 'cyberfucking', 'd1ck', 'damn', 'dick', 'dick hole', 'dick shy', 'dickhead', 'dildo', 'dildos', 'dink', 'dinks', 'dirsa', 'dirty Sanchez', 'dlck', 'dog-fucker', 'doggie style', 'doggiestyle', 'doggin', 'dogging', 'donkeyribber', 'doosh', 'duche', 'dyke', 'eat a dick', 'eat hair pie', 'ejaculate', 'ejaculated', 'ejaculates', 'ejaculating', 'ejaculatings', 'ejaculation', 'ejakulate', 'erotic', 'f u c k', 'f u c k e r', 'f_u_c_k', 'f4nny', 'facial', 'fag', 'fagging', 'faggitt', 'faggot', 'faggs', 'fagot', 'fagots', 'fags', 'fanny', 'fannyflaps', 'fannyfucker', 'fanyy', 'fatass', 'fcuk', 'fcuker', 'fcuking', 'feck', 'fecker', 'felching', 'fellate', 'fellatio', 'fingerfuck', 'fingerfucked', 'fingerfucker', 'fingerfuckers', 'fingerfucking', 'fingerfucks', 'fist fuck', 'fistfuck', 'fistfucked', 'fistfucker', 'fistfuckers', 'fistfucking', 'fistfuckings', 'fistfucks', 'flange', 'flog the log', 'fook', 'fooker', 'fuck hole', 'fuck puppet', 'fuck trophy', 'fuck yo mama', 'fuck', 'fucka', 'fuck-ass', 'fuck-bitch', 'fucked', 'fucker', 'fuckers', 'fuckhead', 'fuckheads', 'fuckin', 'fucking', 'fuckings', 'fuckingshitmotherfucker', 'fuckme', 'fuckmeat', 'fucks', 'fucktoy', 'fuckwhit', 'fuckwit', 'fudge packer', 'fudgepacker', 'fuk', 'fuker', 'fukker', 'fukkin', 'fuks', 'fukwhit', 'fukwit', 'fux', 'fux0r', 'gangbang', 'gangbang', 'gang-bang', 'gangbanged', 'gangbangs', 'gassy ass', 'gaylord', 'gaysex', 'goatse', 'god', 'god damn', 'god-dam', 'goddamn', 'goddamned', 'god-damned', 'ham flap', 'hardcoresex', 'hell', 'heshe', 'hoar', 'hoare', 'hoer', 'homo', 'homoerotic', 'hore', 'horniest', 'horny', 'hotsex', 'how to kill', 'how to murdep', 'jackoff', 'jack-off', 'jap', 'jerk', 'jerk-off', 'jism', 'jiz', 'jizm', 'jizz', 'kawk', 'kinky Jesus', 'knob', 'knob end', 'knobead', 'knobed', 'knobend', 'knobend', 'knobhead', 'knobjocky', 'knobjokey', 'kock', 'kondum', 'kondums', 'kum', 'kummer', 'kumming', 'kums', 'kunilingus', 'kwif', 'l3i+ch', 'l3itch', 'labia', 'LEN', 'lmao', 'lmfao', 'lmfao', 'lust', 'lusting', 'm0f0', 'm0fo', 'm45terbate', 'ma5terb8', 'ma5terbate', 'mafugly', 'masochist', 'masterb8', 'masterbat*', 'masterbat3', 'masterbate', 'master-bate', 'masterbation', 'masterbations', 'masturbate', 'mof0', 'mofo', 'mo-fo', 'mothafuck', 'mothafucka', 'mothafuckas', 'mothafuckaz', 'mothafucked', 'mothafucker', 'mothafuckers', 'mothafuckin', 'mothafucking', 'mothafuckings', 'mothafucks', 'mother fucker', 'mother fucker', 'motherfuck', 'motherfucked', 'motherfucker', 'motherfuckers', 'motherfuckin', 'motherfucking', 'motherfuckings', 'motherfuckka', 'motherfucks', 'muff', 'muff puff', 'mutha', 'muthafecker', 'muthafuckker', 'muther', 'mutherfucker', 'n1gga', 'n1gger', 'nazi', 'need the dick', 'nigg3r', 'nigg4h', 'nigga', 'niggah', 'niggas', 'niggaz', 'nigger', 'niggers', 'nob', 'nob jokey', 'nobhead', 'nobjocky', 'nobjokey', 'numbnuts', 'nut butter', 'nutsack', 'omg', 'orgasim', 'orgasims', 'orgasm', 'orgasms', 'p0rn', 'pawn', 'pecker', 'penis', 'penisfucker', 'phonesex', 'phuck', 'phuk', 'phuked', 'phuking', 'phukked', 'phukking', 'phuks', 'phuq', 'pigfucker', 'pimpis', 'piss', 'pissed', 'pisser', 'pissers', 'pisses', 'pissflaps', 'pissin', 'pissing', 'pissoff', 'poop', 'porn', 'porno', 'pornography', 'pornos', 'prick', 'pricks', 'pron', 'pube', 'pusse', 'pussi', 'pussies', 'pussy', 'pussy fart', 'pussy palace', 'pussys', 'queaf', 'queer', 'rectum', 'retard', 'rimjaw', 'rimming', 's hit', 's.o.b.', 's_h_i_t', 'sadism', 'sadist', 'sandbar', 'sausage queen', 'schlong', 'screwing', 'scroat', 'scrote', 'scrotum', 'semen', 'sex', 'sh!+', 'sh!t', 'sh1t', 'shag', 'shagger', 'shaggin', 'shagging', 'shemale', 'shi+', 'shit', 'shit fucker', 'shitdick', 'shite', 'shited', 'shitey', 'shitfuck', 'shitfull', 'shithead', 'shiting', 'shitings', 'shits', 'shitted', 'shitter', 'shitters', 'shitting', 'shittings', 'shitty', 'skank', 'slope', 'slut', 'slut bucket', 'sluts', 'smegma', 'smut', 'snatch', 'son-of-a-bitch', 'spac', 'spunk', 't1tt1e5', 't1tties', 'teets', 'teez', 'testical', 'testicle', 'tit', 'tit wank', 'titfuck', 'tits', 'titt', 'tittie5', 'tittiefucker', 'titties', 'tittyfuck', 'tittywank', 'titwank', 'tosser', 'turd', 'tw4t', 'twat', 'twathead', 'twatty', 'twunt', 'twunter', 'v14gra', 'v1gra', 'vagina', 'viagra', 'vulva', 'w00se', 'wang', 'wank', 'wanker', 'wanky', 'whoar', 'whore', 'willies', 'willy', 'wtf', 'xrated', 'xxx'];
