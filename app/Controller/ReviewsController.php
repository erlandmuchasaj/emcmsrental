<?php
App::uses('AppController', 'Controller');
/**
 * Reviews Controller
 *
 * @property Review $Review
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ReviewsController extends AppController {

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
		parent::beforeFilter();
		$this->Auth->allow(
			'listReview'
		);
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'conditions' => array(
				'OR' => array(
					array('Review.user_by'=> $this->Auth->user('id')),
					array('Review.user_to'=>$this->Auth->user('id'))
				),
			),
			'contain' => array (
				'UserBy', 
				'UserTo',
				'Reservation',
				'Property'
			),
			'limit' => 25,
			'order' => array('Message.id' => 'asc'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
			'recursive' => 0
		);
		$this->set('reviews', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Review->exists($id)) {
			throw new NotFoundException(__('Invalid review'));
		}
		$options = array('conditions' => array('Review.' . $this->Review->primaryKey => $id), 'recursive'=>0);
		$this->set('review', $this->Review->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($id = null) {
		if ($this->request->is('post')) {
			$this->Review->create();
			if ($this->Review->save($this->request->data)) {
				$this->Flash->success(__('The review has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The review could not be saved. Please, try again.'));
			}
		}
		$reservations = $this->Review->Reservation->find('list');
		$properties = $this->Review->Property->find('list');
		$this->set(compact('reservations', 'properties'));
	}

/**
 * reviews method
 *
 * @return void
 */
	public function listReview($id = null, $model = 'Property') {
		$this->Paginator->settings = array(
			'conditions' => array(
				// 'Review.is_dummy' => 0,
				'Review.status' => 1,
				'Review.model_id' => $id,
				'Review.model' => $model,
				'Review.review_by' => 'guest'
			),
			'contain' => [
				'UserBy',
				'Property'
			],
			'limit' => 15,
			'order' => array('Review.id' => 'asc'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
			'recursive' => 0
		);
		$this->set('reviews', $this->Paginator->paginate());

		return $this->render('list');
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Review->recursive = 0;
		$this->Paginator->settings = array(
			'contain' => array (
				'UserBy', 
				'UserTo',
				'Reservation',
				'Property'
			),
			'limit' => 25,
			'order' => array('Review.id' => 'asc'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
		);
		$this->set('reviews', $this->Paginator->paginate());

	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Review->exists($id)) {
			throw new NotFoundException(__('Invalid review'));
		}
		$options = array('conditions' => array('Review.' . $this->Review->primaryKey => $id), 'recursive'=>0);
		$this->set('review', $this->Review->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		throw new NotFoundException(__('Invalid review'));

		if ($this->request->is('post')) {
			$this->Review->create();
			if ($this->Review->save($this->request->data)) {
				$this->Flash->success(__('The review has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The review could not be saved. Please, try again.'));
			}
		}
		
		$reservations = $this->Review->Reservation->find('list');
		$properties = $this->Review->Property->find('list');
		$this->set(compact('reservations', 'properties'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {

		$this->Flash->warning(__('The review can not be edited right now.'));
		return $this->redirect(array('action' => 'index'));

		if (!$this->Review->exists($id)) {
			throw new NotFoundException(__('Invalid review'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Review->save($this->request->data)) {
				$this->Flash->success(__('The review has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The review could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Review.' . $this->Review->primaryKey => $id));
			$this->request->data = $this->Review->find('first', $options);
		}
		$reservations = $this->Review->Reservation->find('list');
		$properties = $this->Review->Property->find('list');
		$this->set(compact('reservations', 'properties'));
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

		if ($this->Review->save($this->request->data, false)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed Review status.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Review status could not be changed. Please Try again!');
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
		
		$this->Review->id = $id;
		if (!$this->Review->exists()) {
			throw new NotFoundException(__('Invalid Review'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Review->delete()) {
				$response['type'] = 'success';
				$response['message'] = __('Review has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Review could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} elseif ($this->request->is(['post', 'delete'])) {
			if ($this->Review->delete()) {
				$this->Flash->success(__('Review has been deleted.'));
			} else {
				$this->Flash->error(__('Review could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		} else {
			throw new MethodNotAllowedException(__('Method Not Allowed'));
		}
	}

}
