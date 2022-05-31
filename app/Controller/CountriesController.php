<?php
App::uses('AppController', 'Controller');
/**
 * Countries Controller
 *
 * @property Country $Country
 * @property PaginatorComponent $Paginator
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CountriesController extends AppController {

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
		$this->Auth->allow('getCountries','getStatesByCountry');
	}

/**
 * getCountries method
 *
 * @return array country list
 */
	public function getCountries() {
		$this->autoRender = false;
		$this->layout = null;
		$this->request->allowMethod('ajax');
		return $this->Country->find('all');
	}

/**
 * getStatesByCountry method
 * retunr an option list of all states belonging to a country
 *
 * @return html
 */
	public function getStatesByCountry($id) {
		$this->autoRender = false;
		$this->layout = null;
		$this->request->allowMethod('ajax');
		return $this->Country->getStatesByCountryId($id);
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
			'order' => array('Country.sort' => 'asc'),
		);
		$countries = $this->paginate('Country');
		$this->set(compact('countries'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Country->exists($id)) {
			throw new NotFoundException(__('Invalid country'));
		}
		$options = array('conditions' => array('Country.' . $this->Country->primaryKey => $id));
		$this->set('country', $this->Country->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Country->create();
			if ($this->Country->save($this->request->data)) {
				$this->Flash->success(__('The country has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The country could not be saved. Please, try again.'));
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
		if (!$this->Country->exists($id)) {
			throw new NotFoundException(__('Invalid country'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Country->save($this->request->data)) {
				$this->Flash->success(__('The country has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The country could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Country.' . $this->Country->primaryKey => $id));
			$this->request->data = $this->Country->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		throw new NotFoundException(__('Invalid country'));
		$this->Country->id = $id;
		if (!$this->Country->exists()) {
			throw new NotFoundException(__('Invalid country'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Country->delete()) {
			$this->Flash->success(__('The country has been deleted.'));
		} else {
			$this->Flash->error(__('The country could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
