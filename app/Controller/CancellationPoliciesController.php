<?php
App::uses('AppController', 'Controller');
/**
 * CancellationPolicies Controller
 *
 * @property CancellationPolicy $CancellationPolicy
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CancellationPoliciesController extends AppController {


/**
 * Helpers
 *
 * @var array
 */
	public $helpers = [];

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CancellationPolicy->recursive = 0;
		$this->set('cancellationPolicies', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->CancellationPolicy->exists($id)) {
			throw new NotFoundException(__('Invalid cancellation policy'));
		}
		$options = array('conditions' => array('CancellationPolicy.' . $this->CancellationPolicy->primaryKey => $id));
		$this->set('cancellationPolicy', $this->CancellationPolicy->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->helpers[] = 'Froala.Froala';

		if ($this->request->is('post')) {
			$this->CancellationPolicy->create();
			if ($this->CancellationPolicy->save($this->request->data)) {
				$this->Flash->success(__('The cancellation policy has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The cancellation policy could not be saved. Please, try again.'));
			}
		}

		$days = [];
		for ($i=1; $i<=28; $i++) {
			$days[$i] = $i;
		}
		$this->set(
			compact(
				'days'
			)
		);
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->helpers[] = 'Froala.Froala';
		if (!$this->CancellationPolicy->exists($id)) {
			throw new NotFoundException(__('Invalid cancellation policy'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->CancellationPolicy->save($this->request->data)) {
				$this->Flash->success(__('The cancellation policy has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The cancellation policy could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CancellationPolicy.' . $this->CancellationPolicy->primaryKey => $id));
			$this->request->data = $this->CancellationPolicy->find('first', $options);
		}

		$days = [];
		for ($i=1; $i<=28; $i++) {
			$days[$i] = $i;
		}
		$this->set(
			compact(
				'days'
			)
		);
	}


/**
 * admin_hostCancellation method
 *
 * @throws NotFoundException
 * @param string $text
 * @return void
 */
	public function admin_hostCancellation($text = null) {
		App::uses('Currency', 'Model');
		$Currency = new Currency();

		App::uses('HostCancellationPolicy', 'Model');
		$HostCancellationPolicy = new HostCancellationPolicy();

		if ($this->request->is(array('post', 'put'))) {
			
			if (!$HostCancellationPolicy->exists($this->request->data['HostCancellationPolicy']['id'])) {
				throw new NotFoundException(__('Invalid host cancellation policy'));
			}

			if ($HostCancellationPolicy->save($this->request->data)) {
				$this->Flash->success(__('Host cancellation policy has been updated.'));
				return $this->redirect(array('action' => 'hostCancellation'));
			} else {
				$this->Flash->error(__('Host cancellation policy could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $HostCancellationPolicy->find('first', array('conditions' => array('HostCancellationPolicy.id'=>1)));
		}

		$currencies = $Currency->find('list', array(
		    'fields' => array('Currency.code', 'Currency.name'),
		    'recursive' => 0
		));
		$days = [];
		$months = [];
		for ($i=1; $i<=28; $i++) {
			$days[$i] = $i;
			if ($i<=12) {
				$months[$i] = $i;
			}
		}
		$this->set(compact('days', 'months', 'currencies'));
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

		if ($this->CancellationPolicy->save($this->request->data, false)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed this CancellationPolicy status.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('CancellationPolicy Status could not be changed. Please Try again!');
		}

		return json_encode($response);
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->CancellationPolicy->id = $id;
		if (!$this->CancellationPolicy->exists()) {
			throw new NotFoundException(__('Invalid cancellation policy'));
		}

		$this->request->allowMethod('post', 'delete');

		if ($this->CancellationPolicy->checkCancellation($id) != 0) {
			$this->Flash->error(__('Your chosen cancellation policy is used by some lists.'));
		}

		if ($this->CancellationPolicy->delete()) {
			$this->Flash->success(__('The cancellation policy has been deleted.'));
		} else {
			$this->Flash->error(__('The cancellation policy could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
