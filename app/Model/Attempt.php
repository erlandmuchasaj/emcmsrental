<?php
App::uses('AppModel', 'Model');
class Attempt extends AppModel 
{
	public $name = 'Attempt';
	public $displayField = 'ip';
	
	// Returns the number of failed attempts for a certain action.
	public function count($ip, $action) {
		return $this->find('count', array(
			'conditions' => array(
				'ip' => $ip,
				'action' => $action,
				'expires >' => date('Y-m-d H:i:s')
			)
		));
	}

	// Returns false if the number of failed attempts is bigger than the passed limit.
	public function limit($ip, $action, $limit) {
		return ($this->count($ip, $action) < $limit);
	}
	
	// Creates a failed attempt that counts towards the limit for the passed duration
	public function fail($ip, $action, $duration) {
		$this->create(array(
			'ip' => $ip,
			'action' => $action,
			'expires' => date('Y-m-d H:i:s', strtotime($duration)),
			)
		);
		return $this->save();
	}
	
	// Deletes all failed attempts for a certain action
	public function reset($ip, $action) {
		return $this->deleteAll(array(
			'ip' => $ip,
			'action' => $action
			), false, false);
	}
	
	// Deletes all expired failed attempts from the database. This should be run via CakeShell (ideally as a CRON job) every now and then.
	public function cleanup() {
		return $this->deleteAll(array(
			'expires <' => date('Y-m-d H:i:s')
			), false, false);
	}

}