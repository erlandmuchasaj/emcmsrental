<?php
/**
 * Attempt Component Class
 * 
 * 
 * @author Erland Muchasaj
 * @version	1.0
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package App
 * @subpackage App.Controllers.Components
 **/

App::uses('Component', 'Controller');
class AttemptComponent extends Component {
	public $components = array('RequestHandler');

	// Called before the Controller::beforeFilter().
	// function initialize(&$controller, $options) {
	// }

	// Called after the Controller::beforeFilter() and before the controller action
	function startup(Controller $controller) {
		$this->controller = $controller;
		$this->Attempt = ClassRegistry::init('Attempt');
	}
	
	public function count($action) {
		return $this->Attempt->count($this->RequestHandler->getClientIP(), $action);
	}
	
	public function limit($action, $limit = 5) {
		return $this->Attempt->limit($this->RequestHandler->getClientIP(), $action, $limit);
	}
	
	public function fail($action, $duration = '+10 minutes') {
		return $this->Attempt->fail($this->RequestHandler->getClientIP(), $action, $duration);
	}
	
	public function reset($action) {
		return $this->Attempt->reset($this->RequestHandler->getClientIP(), $action);
	}
	
	public function cleanup() {
		return $this->Attempt->cleanup();
	}
}