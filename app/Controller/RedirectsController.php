<?php
App::uses('AppController', 'Controller');
/**
 * Redirects Controller
 *
 * @property Redirects $Redirects
 */
class RedirectsController extends AppController {

	public function admin_index($search = null) {
		$conditions = array();

		if ($this->request->is('ajax')){
			$this->layout = null;
		}


		if (!empty($this->request->data)) {
			$this->redirect(array('action' => 'index', $this->request->data['Redirect']['search']));
		} elseif(!empty($search)) {
			$conditions['or'] = array('Redirect.url LIKE' => '%' . $search . '%', 'Redirect.redirect LIKE' => '%' . $search . '%');
		}

		$this->paginate = array(
			'conditions' => $conditions, 
			'limit' => 35, 
			'order' => array('Redirect.url' => 'asc'),
			'recursive' => -1,
			'contain' => false
		);
		$this->set('redirects', $this->paginate());
		$this->set(compact('search')); 
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Redirect->create();
			if ($this->Redirect->saveMultiple($this->request->data)) {
				$this->Flash->success(__('The redirect(s) has been created successfully.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Flash->error(__('There was a problem creating the redirect, please review the errors below and try again.'));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid redirect'));
		}

		$this->Redirect->contain();
		$redirect = $this->Redirect->findById($id);
		if (!$redirect) {
			throw new NotFoundException(__('Invalid redirect'));
		}

		if ($this->request->is(array('put', 'post'))) {
			if ($this->Redirect->save($this->request->data)) {
				$this->Flash->success(__('The redirect has been updated successfully.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Flash->error(__('There was a problem updating the redirect, please review the errors below and try again.'));
			}
		} else {
			$this->request->data = $redirect;
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
				if ($this->Redirect->save($this->request->data)) {
					$response['type'] = 'success';
					$response['message'] = __('You successfully changed this Redirect status.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Redirect Status could not be changed. Please Try again!');
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
				$this->Redirect->id = $id;
				if ($this->request->is('ajax')) {
					if ($this->Redirect->delete()) {
						$response['type'] = 'success';
						$response['message'] = __('The redirect has been deleted.');
					} else {
						$response['error'] = 1;
						$response['type'] = 'error';
						$response['message'] = __('The redirect could not be deleted. Please, try again!');
					}
					return json_encode($response);
				} else {
					if ($this->Redirect->delete()) {
						$this->Flash->success(__('The redirect has been deleted.'));
					} else {
						$this->Flash->error(__('The redirect could not be deleted. Please, try again!'));
					}
					return $this->redirect(array('action' => 'index'));
				}
			}
		}
}