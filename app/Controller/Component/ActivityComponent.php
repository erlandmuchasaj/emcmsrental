<?php
App::uses('Component', 'Controller');
class ActivityComponent extends Component {
	public $components = array('Auth');
	public $params = array();
	public $user = array();
	
	public function startup(Controller $controller) {
		$this->params = $controller->request->params;
		$this->user = $this->Auth->user('id');
	}
	//user_id is the ID of logged-in user if any who is performin the action.
	//$this->Activity->log($this->Model->id, 'ModelName', 'actionName', 'Description - optional');
	public function log($item_id = null, $model = null, $method = null, $description = '') {
		$item_id = (isset($item_id) && !empty($item_id)) ? $item_id : $this->params['pass'][0];
		if (empty($model) || empty($method)) {
			return false;
		}

		$data['Activity']['user_id'] = (isset($this->user) && !empty($this->user)) ? $this->user : 0;
		$data['Activity']['model'] = $model;
		$data['Activity']['method'] = $method;
		$data['Activity']['item_id'] = $item_id;
		$data['Activity']['description'] = $description;
		
		$activity = ClassRegistry::init('Activity');
		$activity->create();
		$activity->save($data, false);
		$activity->clear();
	}
}