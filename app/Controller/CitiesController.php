<?php
App::uses('AppController', 'Controller');
/**
 * Cities Controller
 *
 * @property City $City
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CitiesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');
/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		/*
			Making a jquery ajax call with Security component activated
			$this->Security->unlockedActions = array('ajax_action');
		*/
		$this->Auth->allow('featured');
		parent::beforeFilter();	
	}


/**
 * featured method
 * @access public
 * @return void
 */
	public function featured() {
		if (empty($this->request->params['requested'])) {
			throw new ForbiddenException();
		}

		App::uses('Language', 'Model');
		$Language = new Language();
		$language_id = $Language->getActiveLanguageId();

		return $this->City->find('all', array(
			'conditions' => array('City.is_home'=>1),
			'order' => array('City.sort' => 'asc', 'City.created' => 'desc'),
			'recursive' => -1
		));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) { 
			$page_count = $this->Session->read('per_page_count');
		}
		$this->Paginator->settings =  array(
			'limit' => $page_count,
			'order' => array('City.sort' => 'asc'),
		);
		$cities = $this->paginate('City');
		$this->set(compact('cities')); 
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->City->exists($id)) {
			throw new NotFoundException(__('Invalid city'));
		}
		$options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
		$this->set('city', $this->City->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->City->create();
			if (empty($this->request->data['City']['image_path']['name'])) {
				unset($this->request->data['City']['image_path']);
			}
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->City->exists($id)) {
			throw new NotFoundException(__('Invalid city'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['City']['image_path']['name'])) {
				unset($this->request->data['City']['image_path']);
			}
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
			$this->request->data = $this->City->find('first', $options);
		}
	}


/**
 * Sort method
 *
 * @return void
 */	
	public function admin_sort() {
		$this->autoRender = false;
		// This is Standart Format for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];


		if ($this->request->data['action'] == 'sort'){
			$array	= $this->request->data['arrayorder'];
			$count = 1;
			foreach ($array as $idval) {
				$query = " UPDATE cities SET sort={$count} WHERE id={$idval}";
				$this->City->query($query);
				$count ++;
			}
			$response['type'] = 'success';
			$response['message'] = __('Sort changed successfully.');
		}

		return json_encode($response);
	}


/**
 * changeStatus method
 *
 * @return void
 */	
	public function admin_changeStatus(){
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->City->save($this->request->data, false)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed this City status.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('City Status could not be changed. Please Try again!');
		}

		return json_encode($response);
	}

	
/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];
		
		$this->City->id = $id;
		if ($this->request->is('ajax')) {
			if ($this->City->delete()) {
				$response['type'] = 'success';
				$response['message'] = __('City has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('City could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} elseif ($this->request->is('post')) {
			if ($this->City->delete()) {
				$this->Flash->success(__('City has been deleted.'));
			} else {
				$this->Flash->error(__('City could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

}
