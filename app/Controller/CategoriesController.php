<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CategoriesController extends AppController {

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
	public $helpers = array('Froala.Froala');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($type = 'Article') {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if ($this->Session->check('per_page_count')) { 
			$page_count = $this->Session->read('per_page_count');
		}

		if ($type && !in_array($type, ['Article', 'Experience', true])) {
			$type = 'Article';
		}

		$this->Paginator->settings = array(
			'limit' => $page_count,
			'order' => array('Category.sort' => 'asc'),
			// 'conditions' => array(
			//	'Category.model' => $type,
			// ),
			'recursive' => -1,
			'paramType' => 'querystring',
			'maxLimit' => 100,
		);

		$categories = $this->paginate('Category');
		$this->set(compact('categories')); 
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($type = null) {
		if ($type && !in_array($type, ['Article', 'Experience', 'Service'])) {
			$type = 'Article';
		}

		if ($this->request->is('post')) {
			$this->request->data['Category']['slug'] = $this->Category->generateSlug($this->request->data['Category']['name']);
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('Category has been added Succesfully.'));

				if ('Experience' === $type) {
					return $this->redirect(array('controller' => 'experience', 'action' => 'categories'));
				}

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Category could not be added. Please, try again.'));
			}
		}

		$this->set('type', $type);
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Category']['slug'] = $this->Category->generateSlug($this->request->data['Category']['name']);
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('Category has been updated succesfully.'));

				// if ('Experience' === $this->request->data['Category']['model']) {
				// 	return $this->redirect(array('controller' => 'experience', 'action' => 'categories'));
				// }
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Category could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
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
			if ($this->Category->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('You successfully changed this category status.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Category Status could not be changed. Please Try again!');
			}
		}
		return json_encode($response);
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
			if ($this->request->data['action'] == 'sort'){
				$array	= $this->request->data['arrayorder'];						
				$count = 1;
				foreach ($array as $idval) {
					$query = "UPDATE categories SET sort={$count} WHERE id={$idval}";
					$this->Category->query($query);
					$count ++;
				}
				$response['type'] = 'success';
				$response['message'] = __('Sort changed successfully.');
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
			$this->Category->id = $id;
			if ($this->request->is('ajax')) {
				if ($this->Category->delete()) {
					$response['type'] = 'success';
					$response['message'] = __('Category has been deleted.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Category could not be deleted. Please Try again!');
				}
				return json_encode($response);
			} else {
				if ($this->Category->delete()) {
					$this->Flash->success(__('Category has been deleted.'));
				} else {
					$this->Flash->error(__('Category could not be deleted. Please Try again!'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

}
