<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * This is email configuration file.
 *
 * Use it to configure email transports of CakePHP.
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *  Mail - Send using PHP mail function
 *  Smtp - Send using SMTP
 *  Debug - Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 */
class EmailConfig {
	public function __construct() {
	    // Do conditional assignments here.
		if (Configure::read('Website.email_driver') == 'smtp') {
		    $this->smtp['from'] 	= [Configure::read('Website.email_from') => Configure::read('Website.email_from_name')];
		    $this->smtp['host'] 	= Configure::read('Website.email_host');
		    $this->smtp['port'] 	= Configure::read('Website.email_port');
		    $this->smtp['timeout']  = Configure::read('Website.email_timeout');
		    $this->smtp['username'] = Configure::read('Website.email_username');
		    $this->smtp['password'] = Configure::read('Website.email_password');
		    $this->smtp['client'] 	= Configure::read('Website.email_client');
		    $this->smtp['log'] 	    = (bool) Configure::read('Website.email_log');

		    if (Configure::check('Website.email_tls') && (Configure::read('Website.email_tls') === true)) {
			    $this->smtp['tls'] = true;
		    }

	        if (Configure::check('Website.email_ssl_allow_self_signed') && (Configure::read('Website.email_ssl_allow_self_signed') === true)) {
	    	    $this->smtp['ssl_allow_self_signed'] = true;
	        }
		}
	}

	public $default = array(
		'transport' => 'Mail',
		'from' => [
			'do-not-reply@erlandmuchasaj.com' => 'EMCMS',
		],
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

	public $smtp = array(
		'transport' => 'Smtp',
		'from' => ['do-not-reply@erlandmuchasaj.com' => 'EMCMS'],
		'host' => 'mail.erlandmuchasaj.com',
		'port' => 587,
		'timeout' => 30,
		'username' => 'do-not-reply@erlandmuchasaj.com',
		'password' => '0aBhbzSmIvAp',
		'client' => null,
		'log' => false,
		'charset' => 'utf-8',
		'headerCharset' => 'utf-8',
	);

	public $test = [
		'log' => true
	];

	public $fast = [
		'from' => [
			'do-not-reply@erlandmuchasaj.com' => 'EMCMS',
		],
		'sender' => null,
		'to' => null,
		'cc' => null,
		'bcc' => null,
		'replyTo' => null,
		'readReceipt' => null,
		'returnPath' => null,
		'messageId' => true,
		'subject' => null,
		'message' => null,
		'headers' => null,
		'viewRender' => null,
		'template' => false,
		'layout' => false,
		'viewVars' => null,
		'attachments' => null,
		'emailFormat' => null,
		'transport' => 'Smtp',
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => true,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	];

}

