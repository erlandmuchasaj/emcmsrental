<?php
App::uses('AppController', 'Controller');
/**
 * Blocks Controller
 *
 * @property Block $Block
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class BlocksController extends AppController {

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
 * Order
 *
 * @var array
 */
	public $order = array('Block.name');

/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		if (!empty($this->Auth)) {
			$this->Auth->allow('index','view','changePageCount');
		}
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function get($slug = null) {
		return $this->Block->get($slug);
	}
////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($search = null) {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = array();
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'index', $this->request->data['Block']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array('Block.name LIKE' => '%' . $search . '%', 'Block.content LIKE' => '%' . $search . '%');
		}

		$this->Paginator->settings =  array(
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => 'Block.name',
			'recursive' => 0,
			'contain' => false
		);
		$blocks = $this->paginate('Block');
		$this->set(compact('blocks', 'search'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Block->exists($id)) {
			throw new NotFoundException(__('Invalid Block'));
		}
		$options = array('conditions' => array('Block.' . $this->Block->primaryKey => $id), 'recursive'=>-1);
		$this->set('block', $this->Block->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->helpers[] = 'Froala.Froala';
		if ($this->request->is('post')) {
			$this->Block->create();
			if ($this->Block->save($this->request->data)) {
				$this->Flash->success(__('The content block has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The content block could not be saved. Please, try again.'));
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
	public function admin_edit($id = null, $revision = null) {
		$this->helpers[] = 'Froala.Froala';
		if (!$this->Block->exists($id)) {
			throw new NotFoundException(__('Invalid content block'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Block->save($this->request->data)) {
				$this->Flash->success(__('Block has been updated Succesfully.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Block could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Block.' . $this->Block->primaryKey => $id));
			$this->request->data = $this->Block->find('first', $options);
			if ($revision) {
				$this->request->data['Block'] = $this->Block->Revision->get($revision, $this->request->data['Block']);
			}
		}
	}


/**
 * Sort method
 *
 * @return void
 */
	public function admin_sort() {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->is('ajax')) {
			if ($this->request->data['action'] === 'sort'){
				$array = $this->request->data['arrayorder'];
				$count = 1;
				foreach ($array as $idval) {
					$query = " UPDATE blocks SET sort={$count} WHERE id={$idval}";
					$this->Block->query($query);
					$count ++;
				}
				$response['type'] = 'success';
				$response['message'] = __('Sort changed successfully.');
			}
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

		if ($this->request->is('ajax')){
			if ($this->Block->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('You successfully changed this content Block status.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Content Block Status could not be changed. Please Try again!');
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
			$this->Block->id = $id;
			if ($this->request->is('ajax')) {
				if ($this->Block->delete()) {
					$response['type'] = 'success';
					$response['message'] = __('The content block has been deleted.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('The content block could not be deleted. Please, try again!');
				}
				return json_encode($response);
			} else {
				if ($this->Block->delete()) {
					$this->Flash->success(__('The content block has been deleted.'));
				} else {
					$this->Flash->error(__('The content block could not be deleted. Please, try again!'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}


}
