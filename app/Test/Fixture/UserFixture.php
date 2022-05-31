<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'surname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date_of_birth' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 12, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'gender' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 8, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'token_expires' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'api_token' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'activation_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'tos_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'reset_password' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'activation_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => 'Key sent to user to activate his account.', 'charset' => 'utf8'),
		'last_login' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 31, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_superuser' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'role' => array('type' => 'string', 'null' => true, 'default' => 'user', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'image_path' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 512, 'collate' => 'utf8_general_ci', 'comment' => 'User Avatar picture', 'charset' => 'utf8'),
		'is_banned' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => '0-False, 1-TRUE if user has been baned by SITE administrator'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'deleted' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'surname' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'phone_number' => 'Lorem ipsum dolor ',
			'date_of_birth' => 'Lorem ipsu',
			'gender' => 'Lorem ',
			'token' => 'Lorem ipsum dolor sit amet',
			'token_expires' => '2016-08-17 17:18:44',
			'api_token' => 'Lorem ipsum dolor sit amet',
			'activation_date' => '2016-08-17 17:18:44',
			'tos_date' => '2016-08-17 17:18:44',
			'reset_password' => 'Lorem ipsum dolor sit amet',
			'activation_code' => 'Lorem ipsum dolor sit amet',
			'last_login' => 'Lorem ipsum dolor sit amet',
			'status' => 1,
			'is_superuser' => 1,
			'role' => 'Lorem ipsum dolor sit amet',
			'image_path' => 'Lorem ipsum dolor sit amet',
			'is_banned' => 1,
			'created' => '2016-08-17 17:18:44',
			'modified' => '2016-08-17 17:18:44',
			'deleted' => '2016-08-17 17:18:44'
		),
	);

}
