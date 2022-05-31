<?php
App::uses('AppController', 'Controller');
/**
 * CityPlaces Controller
 *
 * @property CityPlace $CityPlace
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CityPlacesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CityPlace->recursive = 0;
		$this->set('cityPlaces', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->CityPlace->exists($id)) {
			throw new NotFoundException(__('Invalid city place'));
		}
		$options = array('conditions' => array('CityPlace.' . $this->CityPlace->primaryKey => $id));
		$this->set('cityPlace', $this->CityPlace->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CityPlace->create();
			if (empty($this->request->data['CityPlace']['image_path']['name'])) {
				unset($this->request->data['CityPlace']['image_path']);
			}
			if ($this->CityPlace->save($this->request->data)) {
				$this->Flash->success(__('The city place has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city place could not be saved. Please, try again.'));
			}
		}
		$cities = $this->CityPlace->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->CityPlace->exists($id)) {
			throw new NotFoundException(__('Invalid city place'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['CityPlace']['image_path']['name'])) {
				unset($this->request->data['CityPlace']['image_path']);
			}
			if ($this->CityPlace->save($this->request->data)) {
				$this->Flash->success(__('The city place has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city place could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CityPlace.' . $this->CityPlace->primaryKey => $id));
			$this->request->data = $this->CityPlace->find('first', $options);
		}
		$cities = $this->CityPlace->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->CityPlace->id = $id;
		if (!$this->CityPlace->exists()) {
			throw new NotFoundException(__('Invalid city place'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CityPlace->delete()) {
			$this->Flash->success(__('The city place has been deleted.'));
		} else {
			$this->Flash->error(__('The city place could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
