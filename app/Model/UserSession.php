<?php
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 */
class UserSession extends AppModel {
    // Add the Containable behaviour
    public $actsAs = ['Containable'];

	/**
	 * Add the relation between the User and the UserSession
	 *
	 * @var array
	 */
	public $belongsTo = [
		'User' => [
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
	];


    // Time in seconds before a session no longer should be seen as active
    private $_activeSessionThreshold = 600;

    /**
     * Before Save callback
     * used to add the User's ID to session data (if any, otherwise null is used)
     * @param array $options The options passed to the save method
     * @return bool
     */
    public function beforeSave($options = []) {
        $this->data[$this->alias]['user_id'] = AuthComponent::user('id');
        return parent::beforeSave($options);
    }

    /**
     * Expire every session except the current one
     * @return bool
     */
    public function expireAllExceptCurrent() {
        if (!AuthComponent::user('id')) {
            return false;
        }
        
        $query = [
            'UserSession.id <>' => session_id(),
            'UserSession.user_id' => AuthComponent::user('id'),
        ];
        return $this->deleteAll($query);
    }

    /**
     * Find all the sessions that are considered active
     * @return array
     */
    public function findActive() {
        $query = [
            'recursive' => -1,
            'contain' => [
                'User' => [
                    'fields' => [
                        'User.id',
                        'User.email',
                    ],
                ],
            ],
            'conditions' => [
                'expires >=' => time() - $this->_activeSessionThreshold,
            ],
            'fields' => [
                'UserSession.id',
            ],
        ];
        return $this->find('all', $query);
    }


    public function getActiveUsers() {
        $minutes = 10; // Conditions for the interval of an active session
        $sessionData = $this->find('all',array(
            'conditions' => array(
                'expires >=' => time() - ($minutes * 60) // Making sure we only get recent user sessions
            )
    	));

	    $activeUsers = array();
	    foreach($sessionData as $session){

	        $data = $session['UserSession']['data'];

	        // Clean the string from unwanted characters
	        $data = str_replace('Config','',$data);
	        $data = str_replace('Message','',$data);
	        $data = str_replace('Auth','',$data);
	        $data = substr($data, 1); // Removes the first pipe, don't need it

	        // Explode the string so we get an array of data
	        $data = explode('|',$data);

	        // Unserialize all the data so we can use it
	        if (isset($data[2])) {
                $auth = unserialize($data[2]);
            }

            if (isset($data[3])) {
                $authSecond = unserialize($data[3]);
            }


            // there  are times when the loggedin user is saved on the 3 element of the array
            if(isset($authSecond['User']) && !is_null($authSecond['User']['id'])){
                if(!in_array($authSecond['User']['id'],$activeUsers) && $authSecond['User']['id'] !== AuthComponent::user('id')){
                    $user = [
                        'id' => $authSecond['User']['id'], 
                        'name' => $authSecond['User']['name'], 
                        'surname' => $authSecond['User']['surname'],
                        'email' => $authSecond['User']['email'],
                        'image_path' => isset($authSecond['User']['image_path']) ? $authSecond['User']['image_path'] : '',
                    ];
                    $activeUsers[$authSecond['User']['id']] = $user; 
                }
            }

	        // Check if we are dealing with a signed-in user
	        if(!isset($auth['User']) || is_null($auth['User']['id'])) continue;

	        /* Because a user session contains all the data of a user 
	        * (except the password), I will only return the User id 
	        * and the first and last name of the user 
	        */

	        /* First check if a user id hasn't already been saved 
	        * (can happen because of multiple sign-ins on different 
	        * browsers / computers!) 
	        */

	        if(!in_array($auth['User']['id'],$activeUsers) && $auth['User']['id'] !== AuthComponent::user('id')){
                $user = [
                    'id' => $auth['User']['id'], 
                    'name' => $auth['User']['name'], 
                    'surname' => $auth['User']['surname'],
                    'email' => $auth['User']['email'],
                    'image_path' => $auth['User']['image_path']
                ];
                $activeUsers[$auth['User']['id']] = $user; 

                /* Keep in mind, your User table needs to contain 
                  * a name- surname and email to return them. If not, 
                  * you could use the email address or username 
                  * instead of this data. 
                */

            }

	    }
	    return $activeUsers;
    }

    public function countActiveUsers(){
        return count($this->getActiveUsers());
    }

}