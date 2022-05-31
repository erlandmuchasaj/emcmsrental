<?php
App::uses('AppController', 'Controller');
/**
 * Faqs Controller
 *
 * @property Faq $Faq
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FaqsController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Faqs';

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = [];

/**
 * beforeFilter method
 *
 * @return void
 */
 	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

/**
 * user authorization method
 *
 * @return void
 */

	public function isAuthorized($user = null) {
		if (in_array($this->action, array('index'))) {
			return true;
		}
	    // The owner of a post can edit and delete it
	    if (in_array($this->action, array('admin_index','admin_add','admin_edit', 'admin_delete'))) {
	        if ($user['role'] === 'admin') {
	            return true;
	        }
	    }
	    return parent::isAuthorized($user);
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'conditions' => array(
				'Faq.status' => 1
			),
			'limit' => 50,
			'order' => ['Faq.sort' => 'ASC'],
			'recursive' => -1,
			'paramType' => 'querystring'
		);
		$faqs = $this->Paginator->paginate();
		$this->set('faqs', $faqs);
	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}
		$faqs = $this->Faq->find('all', array('recursive' => 0, 'order' => array('Faq.sort ASC')));
        $this->set('faqs', $faqs);
	}

/**
 * Sort method
 *
 * @return void
 */
	public function admin_sort() {
		$this->autoRender = false;
		$this->request->onlyAllow('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->is('ajax')) {
			if ($this->request->data['action'] == 'sort'){
				$array	= $this->request->data['arrayorder'];
				$count = 1;
				foreach ($array as $idval) {
					$query = " UPDATE faqs SET sort={$count} WHERE id={$idval}";
					$this->Faq->query($query);
					$count ++;
				}
				$response['type'] = 'success';
				$response['message'] = __('Sort changed successfully.');
			}
		}
		return json_encode($response);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
		$this->set('faq', $this->Faq->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		$this->helpers[] = 'Froala.Froala';
		if ($this->request->is('post')) {
			$this->Faq->create();
			if ($this->Faq->save($this->request->data)) {
				$this->Flash->success(__('Faq question has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Faq question could not be saved. Please Try again!'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->helpers[] = 'Froala.Froala';
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Faq->save($this->request->data)) {
				$this->Flash->success(__('The faq has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The faq could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
			$this->request->data = $this->Faq->find('first', $options);
		}
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

		if ($this->request->is('ajax')){
			if ($this->Faq->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('You successfully changed this faq question status.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Faq question Status could not be changed. Please Try again!');
			}
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

		if ($this->request->is('post')) {
			$this->Faq->id = $id;
			if ($this->request->is('ajax')) {
				if ($this->Faq->delete()) {
					$response['type'] = 'success';
					$response['message'] = __('Faq question has been deleted.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Faq question could not be deleted. Please Try again!');
				}
				return json_encode($response);
			} else {
				if ($this->Faq->delete()) {
					$this->Flash->success(__('Faq question has been deleted.'));
				} else {
					$this->Flash->error(__('Faq question could not be deleted. Please Try again!'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

/**
 * publish method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_publish($id = null) {
		if (!$this->request->is('post') && !$this->request->is('put')) {
        		throw new MethodNotAllowedException();
    	}
		$this->Faq->id = $id;
		if (!$this->Faq->exists()) {
			throw new NotFoundException(__('Invalid Question!'));
		}
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Faq->updateAll(array('status'=>'1'),array('Faq.' . $this->Faq->primaryKey => $id))) {
				$this->Flash->success(__('Question published Succesfully.'));
				return $this->redirect(array('controller'=>'faqs','action' => 'index','admin'=>true));
			} else {
				$this->Flash->error(__('Question was not published. Please Try again!'));
			}
		}
		return $this->redirect($this->referer());
	}

/**
 * unpublish method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_unpublish($id = null) {
		if (!$this->request->is('post') && !$this->request->is('put')) {
        		throw new MethodNotAllowedException();
    	}
		$this->Faq->id = $id;
		if (!$this->Faq->exists()) {
			throw new NotFoundException(__('Invalid Question'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Faq->updateAll(array('status'=>'0'),array('Faq.' . $this->Faq->primaryKey => $id))) {
				$this->Flash->success(__('Question unpublished Succesfully.'));
				return $this->redirect(array('admin'=>true,'controller'=>'faqs','action' => 'index'));
			} else {
				$this->Flash->error(__('Question was not unpublished. Please Try again!'));
			}
		}
		return $this->redirect($this->referer());
	}

}
