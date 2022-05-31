<?php
App::uses('AppModel', 'Model');
/**
 * UserProfile Model
 *
 * @property User $User
 */
class UserProfile extends AppModel {
	/**
	 * Model Name
	 *
	 * @var string
	 */	
		public $name = 'UserProfile';

	/**
	 * User Table
	 *
	 * @var string
	 */	
		public $useTable = 'user_profiles';

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
		public $displayField = 'address';

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
		public $belongsTo = 'User';

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	// public $belongsTo = array(
	// 	'User' => array(
	// 		'className' => 'User',
	// 		'foreignKey' => 'user_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// 	'Language' => array(
	// 		'className' => 'Language',
	// 		'foreignKey' => 'language_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// 	'Currency' => array(
	// 		'className' => 'Currency',
	// 		'foreignKey' => 'currency_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// 	'Timezone' => array(
	// 		'className' => 'Timezone',
	// 		'foreignKey' => 'timezone_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// );
}
