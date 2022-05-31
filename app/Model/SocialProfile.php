<?php
App::uses('AuthComponent', 'Controller/Component');

class SocialProfile extends AppModel {
	public $belongsTo = [
		'User' => [
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		],
	];

	/**
	 * [createFromSocialProfile Create user from the social profile]
	 * @param  [array] $incomingProfile [description]
	 * @return [array]                  [normalized user profile data]
	 */
    public function createSocialProfile($incomingProfile, $user_id) {
    	# user profile
    	$incomingProfile['SocialProfile']['user_id'] = $user_id;
		if ($this->save($incomingProfile['SocialProfile'], false)) {
			$incomingProfile['SocialProfile']['id'] = $this->id;
		} else {
			// debug($this->validationErrors);
			return false;
		}

		return $incomingProfile;
	}

}