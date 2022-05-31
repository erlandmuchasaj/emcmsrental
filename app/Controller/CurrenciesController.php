<?php
App::uses('AppController', 'Controller');
/**
 * Currencies Controller
 *
 * @property Currency $Currency
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CurrenciesController extends AppController {
	
/**
 * Name
 *
 * @var string
 */
	public $name = 'Currencies';

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * beforeFilter method
 *
 * @return void
 */
 	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * user authorization method
 *
 * @return void
 */

	public function isAuthorized($user = null) {
		if (in_array($this->action, array('index','view'))) {
			return true;
		}
	    // The owner of a post can edit and delete it
	    if (in_array($this->action, array('add','edit','delete'))) {
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
	public function admin_index() {
		$this->Currency->recursive = -1;
		$this->set('currencies', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Currency->exists($id)) {
			throw new NotFoundException(__('Invalid currency'));
		}
		$options = array('conditions' => array('Currency.' . $this->Currency->primaryKey => $id), 'recursive'=>-1);
		$this->set('currency', $this->Currency->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Currency->create();

			$code = $this->request->data['Currency']['code'];
			if (!array_key_exists($code, $this->Currency->currencySymbols)) {
				$this->Flash->warning(__('Currency selected is not supported.'));
				return $this->redirect($this->referer());
			}

			$this->request->data['Currency']['name'] = $this->Currency->currencyNames[$code];
			$this->request->data['Currency']['symbol'] = $this->Currency->currencySymbols[$code];

			if ($this->Currency->save($this->request->data)) {
				$this->Flash->success(__('Currency has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Currency could not be saved. Please, try again.'));
			}
		}

		$this->set('availableCurrencies', $this->Currency->currencyNames);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Currency->exists($id)) {
			throw new NotFoundException(__('Invalid currency'));
		}
		if ($this->request->is(array('post', 'put'))) {

			if (isset($this->request->data['Currency']['code'])) {
				$code = $this->request->data['Currency']['code'];
				if (!array_key_exists($code, $this->Currency->currencySymbols)) {
					$this->Flash->warning(__('Currency selected is not supported.'));
					return $this->redirect($this->referer());
				}
			}

			if ($this->Currency->save($this->request->data)) {
				$this->Flash->success(__('Currency has been updated.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Currency could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Currency.' . $this->Currency->primaryKey => $id));
			$this->request->data = $this->Currency->find('first', $options);
		}

		$this->set('availableCurrencies', $this->Currency->currencyNames);
	}

/**
 * publish method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_enable($id = null) {
		$this->Currency->id = $id;
		if (!$this->Currency->exists()) {
			throw new NotFoundException(__('Invalid Currency!'));
		}
		$this->request->allowMethod('post', 'put');

		if ($this->Currency->updateAll(array('status'=>'1'),array('Currency.' . $this->Currency->primaryKey => $id))) {
			$this->Flash->success(__('Currency has been activated Succesfully.'));
		} else {
			$this->Flash->error(__('Currency could not be not be activated. Try again!'));
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
	public function admin_disable($id = null) {

		$this->Currency->id = $id;
		if (!$this->Currency->exists()) {
			throw new NotFoundException(__('Invalid Question'));
		}

		$this->request->allowMethod('post', 'put');

		$currency = $this->Currency->read();

		if ((int)$currency['Currency']['is_default'] == 1) {
			$this->Flash->error(__('Sorry! You can not disable a default currency.'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Session->read('LocaleCurrency') === $currency['Currency']['code']) {
			// Clean cookie and session of currencies
			$this->Session->delete('LocaleCurrency');
			$this->Cookie->delete('currency');
		}

		if ($this->Currency->updateAll(array('status'=>'0'),array('Currency.' . $this->Currency->primaryKey => $id))) {
			$this->Flash->success(__('Currency was disabled Succesfully.'));
		} else {
			$this->Flash->error(__('Currency could not be disabled. Please Try again!'));
		}

		return $this->redirect($this->referer());
	}

/**
 * makeDefault method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_makeDefault($id = null) {
		$options = [
		    'conditions' => [
		        'Currency.' . $this->Currency->primaryKey => $id,
		        'Currency.status' => 1
		    ]
		];
		$currency = $this->Currency->find('first', $options);

		if (!$currency) {
			$this->Flash->error(__('Sorry! You can not set as default a disabled currency.'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->request->allowMethod('post', 'put');

		$this->Currency->updateAll(['is_default'=> '0']);

		if ($this->Currency->updateAll(['is_default'=> 1], ['Currency.' . $this->Currency->primaryKey => $id, 'Currency.status' => 1])) {
			// Clean cookie and session of currencies
			$this->Session->delete('LocaleCurrency');
			$this->Cookie->delete('currency');
			$this->Flash->success(__('%s has been set as default currency.', h($currency['Currency']['name'])));
		} else {
			$this->Flash->error(__('%s could not be set as default currency. Try again!', h($currency['Currency']['name'])));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {

		$this->Currency->id = $id;
		if (!$this->Currency->exists()) {
			throw new NotFoundException(__('Invalid currency'));
		}
		$this->request->allowMethod('post', 'delete');

		$currency = $this->Currency->find('first', array('conditions'=>array('Currency.' . $this->Currency->primaryKey => $id)));

		if ((int)$currency['Currency']['is_default'] == 1) {
			$this->Flash->error(__('Sorry! You can not delete a default currency.'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Currency->delete()) {
			$this->Flash->success(__('Currency has been deleted successfuly'));
		} else {
			$this->Flash->error(__('The currency could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
