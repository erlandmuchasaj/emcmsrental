<?php
App::uses('AppModel', 'Model');
//App::uses('AuthComponent', 'Controller/Component');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {

	/**
	 * Model Name
	 *
	 * @var string
	 */
		public $name = 'User';

	/**
	 * User Table
	 *
	 * @var string
	 */
		public $useTable = 'users';

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
		// public $displayField = 'fullname';
		public $displayField = 'name';

	/**
	 * Virtual field
	 *
	 * @var string
	 */
		// public $virtualFields = array('fullname' => 'CONCAT(`User`.`name`, " ", `User`.`surname`)');

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
			'name' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => 'Please enter the value for name'
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'maxLength' => array(
					'rule' => array('maxLength', 50),
					'message' => 'User name can not have more then 50 characters.',
				),
			),
			'surname' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => 'Please enter the value for surname'
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'maxLength' => array(
					'rule' => array('maxLength', 50),
					'message' => 'User surname can not have more then 50 characters..',
				),
			),
			'email' => array(
				'email' => array(
					'rule' => array('email', true),
					'message' => 'That email address does not seem to be valid.'
				),
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => 'E-mail can not be empty.',
					'allowEmpty' => false
				),
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => 'It seems you are already registered, please use the forgot password option.',
				),
			),
			'username' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => 'Username can not be empty.',
					'allowEmpty' => true,
					'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'maxLength' => array(
					'rule' => array('maxLength' , 50),
					'message' => 'Username can not be more then 50 characters long.',
				),
				'minLength' => array(
					'rule' => array('minLength' , 5),
					'message' => 'Username can not be less then 5 characters.',
				),
				// 'isUnique' => array(
				// 	'rule' => 'isUnique',
				// 	'message' => 'This username allredy exist in Database.',
				// ),
				// 'alphaNumeric' => array(
				// 	'rule' => 'alphaNumeric',
				// 	'message' => 'Letters and numbers only',
				// 	// 'required' => true,
				// ),
			),
			'password' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => 'Password Can not be empty',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'minLength' => array(
					'rule' => array('minLength',5),
					'message' => 'Password should be more then 5 characters long',
				),
			),
			'confirm_password' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => 'Please enter the value for Confirm Password.'
				),
				'checkPassword' => array(
					'rule' => array('checkPassword'),
					'message' => 'Password and Confirmation password do not match.',
				)
			),
			'image_path' => array(
				'fileExtension' => array(
					'rule' => array('fileExtension', array('png','jpg','jpeg')),
					'message' => 'Please supply a valid image (PNG , JPEG, JPG only).',
					'allowEmpty' => true,
					'required' => false,
				),
				'fileMaxSize' => array(
					'rule' => array('fileMaxSize', '5242880'),
					'message' => 'Max file size is exeeded.',
					'allowEmpty' => true,
					'required' => false,
				),
				'extension' => array(
					'rule' => array('extension', array('jpeg', 'png', 'jpg')),
					'message' => 'Please supply a valid image.',
					'allowEmpty' => true,
					'required' => false,
				),
				'fileSize' => array(
					'rule' => array('fileSize', '<=', '5MB'),
					'message' => 'Image must be less than 5MB',
					'allowEmpty' => true,
					'required' => false,
				),
				'uploadError' => array(
					'rule' => array('uploadError'),
					'message' => 'Something went wrong with the upload.',
					'allowEmpty' => true,
					'required' => false,
				),
				'processMediaUpload' => array(
					'rule' => 'processMediaUpload',
					'message' => 'Unable to process image upload.',
					'required' => false,
					'allowEmpty' => true,
				),
			),
			'current_password' => array(
				'rule' => 'checkCurrentPassword',
				'message' => 'Current password is not valid. Please enter your current password'
			),
			'new_password' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => 'Password can not be empty.',
				),
				'minLength' => array(
					'rule' => array('minLength',5),
					'message' => 'Password should be more then 5 characters long',
				),
				'passwordsMatch'=>array(
					'rule'=>'passwordsMatch',
					'message'=>'Passwords do now match!'
				),
			),
			'confirm_new_password'=>array(
				'notBlank'=>array(
					'rule'=>'notBlank',
					'message'=>'Confirm new password.'
				),
			),
			'gender' => array(
				'inList' => array(
					'rule' => array('inList', array('male','female','other','unknown','refuzed')),
					'message' => 'Only male, female, other, refuzed and unknown option are allowed',
					'allowEmpty' => true,
					'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'status' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => 'Bolean value only',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'is_superuser' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => 'Bolean value only',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'role' => array(
				'inList' => array(
					'rule' => array('inList', array('admin', 'user', 'agency', 'agent')),
					'message' => 'Only Admin, User, Agent and Agency option are allowed (Lowercase)',
					// 'allowEmpty' => false,
					// 'required' => true,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'is_banned' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => 'Bolean value only',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
		// public $belongsTo = array(
		// 	'Language' => array(
		// 		'className' => 'Language',
		// 		'foreignKey' => 'language_id',
		// 		'conditions' => '',
		// 		'fields' => '',
		// 		'order' => ''
		// 	)
		// );

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
		public $hasMany = array(
			'SocialProfile' => array(
				'className' => 'SocialProfile',
				'dependent' => true,
			),
			'UserSession' => array(
				'className' => 'UserSession',
				'dependent' => false,
			),
			'PayoutPreference' => array(
				'className' => 'PayoutPreference',
				'dependent' => true,
			),
			'MessageBy' => array(
				'className' => 'Message',
				'foreignKey' => 'user_by',
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
			'MessageTo' => array(
				'className' => 'Message',
				'foreignKey' => 'user_to',
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
			'ReservationBy' => array(
				'className' => 'Reservation',
				'foreignKey' => 'user_by',
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
			'ReservationTo' => array(
				'className' => 'Reservation',
				'foreignKey' => 'user_to',
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
			'ReviewBy' => array(
				'className' => 'Review',
				'foreignKey' => 'user_by',
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
			'ReviewTo' => array(
				'className' => 'Review',
				'foreignKey' => 'user_to',
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
			'Property' => array(
				'className' => 'Property',
				'foreignKey' => 'user_id',
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
			'UserWishlist' => array(
				'className' => 'UserWishlist',
				'foreignKey' => 'user_id',
				'dependent' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
			'Image' => array(
				'className' => 'Image',
				'foreignKey' => 'model_id',
				'dependent' => true,
				'conditions' => array(
					'Image.model' => 'User',
					'Image.status' => 1
				),
				'fields' => '',
				'order' => array('sort' => 'asc'),
				'limit' => 10,
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
		);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
		public $hasOne = array(
			'UserProfile' => array('dependent' => true)
		);

	/**
	 * ActsAs
	 *
	 * @var array
	 */
		public $actsAs = array(
			// 'Revision' => array('fields' => array('name','surname')),
			'Upload.Upload' => array(
				'fields' => array('image_path'=>''),
				'use_thumbnails'=>true
			)
		);

	/**
	 * checkPassword Method
	 *
	 * @return boolean
	 */
		public function checkPassword($check){
			return ($this->data[$this->alias]['password'] === $this->data[$this->alias]['confirm_password']);
		}

	/**
	 * checkCurrentPassword Method
	 * check if the passwword entered is same as our password
	 * @return boolean
	 */
		public function checkCurrentPassword($data) {
			$this->id = $this->field('id');
			// debug($this->id);
			$password = $this->field('password');
			// here we grab the user old password , we hash it and then compare and see if they match
			return $this->check($data['current_password'], $password);
		}

	/**
	 * Check hash. Generate hash for user provided password and check against existing hash.
	 *
	 * @param string $password Plain text password to hash.
	 * @param string Existing hashed password.
	 * @return boolean True if hashes match else false.
	 */
		public function check($password, $hashedPassword) {
			return $hashedPassword === Security::hash($password, 'blowfish', $hashedPassword);
		}

	/**
	 * passwordsMatch Method
	 *  Check wether the new Password and Confirm New password matches
	 * @return boolean
	 */
		public function passwordsMatch($data) {
			if ($data['new_password'] === $this->data[$this->alias]['confirm_new_password']) {
				return true;
			}
			$this->invalidate('confirm_new_password', 'Passwords do not match!');
			return false;
		}

	/**
	 * BeforeSave Method
	 *
	 * @return array
	 */
		public function beforeSave($options = array()) {
			// Adding new user
			if (isset($this->data[$this->alias]['password'])) {
				//[$this->alias] is instead of ['User']
				$passwordHasher = new BlowfishPasswordHasher();
				$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
				// $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
			}

			//Changing User Password
			if (isset($this->data[$this->alias]['new_password']) && !empty($this->data[$this->alias]['new_password'])) {
				$passwordHasher = new BlowfishPasswordHasher();
				$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['new_password']);
				//$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['new_password']);
			}

			// Add languages
			if (isset($this->data[$this->alias]['languages']) && !empty($this->data[$this->alias]['languages'])) {
				$this->data[$this->alias]['languages'] = json_encode($this->data[$this->alias]['languages']);
			}

			return parent::beforeSave($options);
		}


	/**
	 * access Method
	 *
	 * @return boolean
	 */
		public function access($user_id = null)  {
			if (!$user_id) {
				return false;
			}

			$user = $this->find('first', array(
					'conditions' => array('User.id' => $user_id, 'User.deleted' => null),
				)
			);

			if (!$user) {
				return $this->redirect(array('action'=>'logout'));
			}

			if (
				(empty($user['UserProfile']['address'])) ||
				(empty($user['UserProfile']['zip'])) ||
				(empty($user['UserProfile']['city']))
			) {
				return false;
			}

			return true;
		}

	/**
	 * canAddProperty
	 * Determine if user can add more then max_limit of properties specified 
	 * If user is admin or agency/agent he can add more then the limit.
	 * 
	 * @param  int  $user_id 
	 * @param  integer $max_limit
	 * @return boolean
	 */
		public function canAddProperty($user_id, $max_limit = 10) {
			// is user is admin or agency he can add unlemitid prperty
			$role = $this->field('role', ['User.' . $this->primaryKey => $user_id]);
			if (in_array($role, ['agency', 'agent', 'admin'], true)) {
				return true;
			}

			//  else he have a specified limit
			$count = $this->Property->find('count', [
				'conditions' => [
					'Property.user_id' => $user_id, 
					'Property.deleted' => null
				],
				'recursive' => -1,
				'callbacks' => false,
			]);
			$maxlimit = Configure::check('Website.property_limit') ? Configure::read('Website.property_limit') : $max_limit;

			if ($count >= $maxlimit) {
				return false;
			}

			return true;
		}


		public function getUserByID($userID) {
			try {
				return $this->find('first', array(
					'conditions' => array('User.id' => $userID),
				));
			} catch (Exception $ex) {
				$this->log($ex->getMessage(), LOG_ERROR);
			}
			return false;
		}

	/**
	 * [createFromSocialProfile Create user from the social profile]
	 * @param  [array] $incomingProfile [description]
	 * @return [array]                  [normalized user profile data]
	 */
    public function createFromSocialProfile($incomingProfile) {

		// although it technically means nothing, we still need a password
		// for social. setting it to something random like the current time..
		$password = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

		// brand new user - so register it to DB and then log it in.
		$user[$this->alias]['name']	  = $incomingProfile['SocialProfile']['first_name'];
		$user[$this->alias]['surname']= $incomingProfile['SocialProfile']['last_name'];
		$user[$this->alias]['email']  = $incomingProfile['SocialProfile']['email'];
		$user[$this->alias]['gender'] = $incomingProfile['SocialProfile']['gender'];
		// since the username is required, we need to set up one
		$part2 = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
		$user[$this->alias]['username'] = mb_strtolower($incomingProfile['SocialProfile']['first_name'].'_'.$part2,'UTF-8');
		$user[$this->alias]['password']		  = $password;
		$user[$this->alias]['confirm_password'] = $password;
		$user[$this->alias]['status']			= 1; 	// by default all social logins will have a status of active
		$user[$this->alias]['role']			= 'user'; 	// by default all social logins will have a role of user
		$user[$this->alias]['activation_code'] = null;
		$user[$this->alias]['activation_date'] = date('Y-m-d h:i:s');
		$user[$this->alias]['created']  = date('Y-m-d h:i:s');
		$user[$this->alias]['modified'] = date('Y-m-d h:i:s');
		# user profile
		$user[$this->UserProfile->alias]['job_title'] = $incomingProfile['SocialProfile']['job_title'];
		$user[$this->UserProfile->alias]['company'] = $incomingProfile['SocialProfile']['company'];
		$user[$this->UserProfile->alias]['about']	= $incomingProfile['SocialProfile']['about'];
		$user[$this->UserProfile->alias]['address'] = $incomingProfile['SocialProfile']['address'];
		$user[$this->UserProfile->alias]['zip'] 	= $incomingProfile['SocialProfile']['zip'];
		$user[$this->UserProfile->alias]['city']	= $incomingProfile['SocialProfile']['city'];
		$user[$this->UserProfile->alias]['country'] = $incomingProfile['SocialProfile']['country'];
		$user[$this->UserProfile->alias]['phone']   = $incomingProfile['SocialProfile']['phone'];
		$user[$this->UserProfile->alias]['url'] 	= $incomingProfile['SocialProfile']['url'];

		// save and store our ID
		$options = array('validate' => false, 'deep' => true, 'atomic' => true);   // to save only the valid data
		if ($this->saveAssociated($user, $options)) {
			$user[$this->alias][$this->primaryKey] = $this->id;
			$user[$this->UserProfile->alias][$this->UserProfile->primaryKey] = $this->UserProfile->id;
		} else {
			var_dump($this->validationErrors);
			return false;
		}

		return $user;
	}

}
