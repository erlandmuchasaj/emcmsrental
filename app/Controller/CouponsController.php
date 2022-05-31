<?php
App::uses('AppController', 'Controller');
/**
 * Coupons Controller
 *
 * @property Coupon $Coupon
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CouponsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash', 'CurrencyConverter.CurrencyConverter');

/**
 * checkCode method
 *
 * @return bool
 */
	public function checkCode($code) {
		$this->autoRender = false;

		if ($this->Coupon->isSameCoupon($code)) {
			$this->Flash->error(__('Coupon code allready exist.'));
			return false;
		} else {
			return true;
		}
	}

/**
 * checkCode method
 *
 * @return bool
 */
	public function checkPrice($couponPrice) {
		$this->autoRender = false;

		$currency = $this->request->data['Coupon']['currency'];
		$price_converted = $this->CurrencyConverter->convert('EUR', $this->request->data['Coupon']['currency'], 10, 1, 4);

		if ($couponPrice < round($price_converted)) {
			$this->Flash->error(__('Coupon Price should be above or equal to. %s %s', $currency, $price_converted));
			return false;
		} else {
			return true;
		}
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Coupon->recursive = 0;
		$this->set('coupons', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Coupon->exists($id)) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		$options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
		$this->set('coupon', $this->Coupon->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Coupon->create();
			$this->request->data['Coupon']['user_id'] = $this->Auth->user('id');
			if ($this->Coupon->save($this->request->data)) {
				$this->Flash->success(__('The coupon has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The coupon could not be saved. Please, try again.'));
			}
		}
		$currencies = $this->Coupon->Property->Currency->find('list', array(
			'fields' => array('Currency.code', 'Currency.name'),
			'conditions' => array('Currency.status' => 1),
			'recursive' => -1
		));
		$this->set(compact('currencies'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Coupon->exists($id)) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Coupon->save($this->request->data)) {
				$this->Flash->success(__('The coupon has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The coupon could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
			$this->request->data = $this->Coupon->find('first', $options);
		}
		$currencies = $this->Coupon->Property->Currency->find('list', array(
			'fields' => array('Currency.code', 'Currency.name'),
			'conditions' => array('Currency.status' => 1),
			'recursive' => -1
		));
		$this->set(compact('currencies'));
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

		if ($this->Coupon->save($this->request->data, false)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed coupon status.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Coupon status could not be changed. Please Try again!');
		}

		return json_encode($response);
	}


/**
 * admin_delete method
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
		
		$this->Coupon->id = $id;
		if (!$this->Coupon->exists()) {
			throw new NotFoundException(__('Invalid coupon'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Coupon->delete()) {
				$response['type'] = 'success';
				$response['message'] = __('Coupon has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Coupon could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} elseif ($this->request->is(['post', 'delete'])) {
			if ($this->Coupon->delete()) {
				$this->Flash->success(__('Coupon has been deleted.'));
			} else {
				$this->Flash->error(__('Coupon could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		} else {
			throw new MethodNotAllowedException(__('Method Not Allowed'));
		}
	}


}
