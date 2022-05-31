<?php
App::uses('AppController', 'Controller');
/**
 * Fees Controller
 *
 * @property Fee $Fee
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class FeesController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Fees';

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');


////////////////////////////////////////////////////////////////////////////////////
/**
 * beforeFilter method
 *
 * @return void
 */
 	public function beforeFilter() {
		parent::beforeFilter();		
	} 
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////
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
	    if (in_array($this->action, array('add','edit', 'delete'))) {
	        if ($user['role'] === 'admin') {
	            return true;
	        }
	    }
	    return parent::isAuthorized($user);
	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////	
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Fee->recursive = 0;
		$this->set('fees', $this->Paginator->paginate());
	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Fee->exists($id)) {
			throw new NotFoundException(__('Invalid fee'));
		}
		$options = array('conditions' => array('Fee.' . $this->Fee->primaryKey => $id));
		$this->set('fee', $this->Fee->find('first', $options));
	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////	
/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Fee->create();
			if ($this->Fee->save($this->request->data)) {
				$this->Session->setFlash(__('The fee has been saved.'),'flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fee could not be saved. Please, try again.'),'flash_error');
			}
		}
	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////	
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Fee->exists($id)) {
			throw new NotFoundException(__('Invalid fee'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Fee->save($this->request->data)) {
				$this->Session->setFlash(__('The fee has been saved.'),'flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fee could not be saved. Please, try again.'),'flash_error');
			}
		} else {
			$options = array('conditions' => array('Fee.' . $this->Fee->primaryKey => $id));
			$this->request->data = $this->Fee->find('first', $options);
		}
	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////	
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Fee->id = $id;
		if (!$this->Fee->exists()) {
			throw new NotFoundException(__('Invalid fee'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Fee->delete()) {
			$this->Session->setFlash(__('The fee has been deleted.'),'flash_success');
		} else {
			$this->Session->setFlash(__('The fee could not be deleted. Please, try again.'),'flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}
////////////////////////////////////////////////////////////////////////////////////


}
