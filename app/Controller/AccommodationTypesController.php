<?php
App::uses('AppController', 'Controller');
/**
 * AccommodationTypes Controller
 *
 * @property AccommodationType $AccommodationType
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AccommodationTypesController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$language_id = $this->AccommodationType->Language->getActiveLanguageId();

		$this->Paginator->settings =  array(
			'conditions' => array('AccommodationType.language_id' => $language_id),
			'contain' => array('Language'),
			'limit' => 20,
			'recursive'=>0,
			'paramType' => 'querystring',
			'order' => array('AccommodationType.accommodation_type_name' => 'asc'),
		);

		$accommodationTypes = $this->paginate('AccommodationType');
		$this->set(compact('accommodationTypes'));
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {

		if (!$this->AccommodationType->exists($id)) {
			throw new NotFoundException(__('Invalid accommodation type'));
		}

		$accId = $this->AccommodationType->field('accommodation_type_id', array('AccommodationType.' . $this->AccommodationType->primaryKey => $id));

		if (!$accId) {
			throw new NotFoundException(__('Invalid accommodation type'));
		}

		$options = array(
			'conditions' => array('AccommodationType.accommodation_type_id' => $accId),
			'contain' => array('Language'),
			'recursive' => 0
		);
		$accommodationTypeList = $this->AccommodationType->find('all', $options);


		$this->set('accommodationTypeList', $accommodationTypeList);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		$accommodation_type_id = $this->AccommodationType->nextAvailableId();

		if ($this->request->is('post')) {
			$this->AccommodationType->create();

			$id_lang_default = $this->AccommodationType->Language->getDefaultLanguageId();
			$defaultName = '';
			if (isset($this->request->data['AccommodationType'][$id_lang_default])) {
				$defaultName = $this->request->data['AccommodationType'][$id_lang_default]['accommodation_type_name'];
			}
			foreach ($this->request->data['AccommodationType'] as $id_lang => &$accommodation) {
				if (empty($accommodation['accommodation_type_name'])) {
					$accommodation['accommodation_type_name'] = $defaultName;
				}
			}
			unset($accommodation);

			if ($this->AccommodationType->saveMany($this->request->data['AccommodationType'])) {
				$this->Flash->success(__('Accommodation Type has been saved succesfully.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Accommodation Type could not be saved. Please, try again.'));
			}
		}

		$languages = $this->AccommodationType->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
		$this->set(compact('languages', 'accommodation_type_id'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		
		if (!$this->AccommodationType->exists($id)) {
			throw new NotFoundException(__('Invalid accommodation type'));
		}

		$accId = $this->AccommodationType->field('accommodation_type_id', array('AccommodationType.' . $this->AccommodationType->primaryKey => $id));
		if (!$accId) {
			throw new NotFoundException(__('Invalid accommodation type'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->AccommodationType->saveMany($this->request->data['AccommodationType'])) {
				$this->Flash->success(__('Accommodation Type has been updated succesfully.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Accommodation Type could not be updated. Please, try again.'));
			}
		}

		$translations = $this->AccommodationType->find('all', [
			'conditions' => [
				'AccommodationType.accommodation_type_id' => $accId
			],
			'contain' => [
				'Language',
			],
		]);

		$languages = $this->AccommodationType->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
		$this->set(compact('languages', 'translations'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_editLanguage($id = null, $language_id = null) {
		if (!$this->AccommodationType->exists($id)) {
			throw new NotFoundException(__('Invalid accommodation type'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->AccommodationType->save($this->request->data)) {
				$this->Flash->success(__('Accommodation Type language has been updated succesfully.'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Flash->error(__('Accommodation Type language could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AccommodationType.' . $this->AccommodationType->primaryKey => $id));
			$this->request->data = $this->AccommodationType->find('first', $options);
		}

		$language = $this->AccommodationType->Language->find('first', array('conditions' => array('Language.id' => $language_id), 'recursive'=>-1));
		$this->set(compact('language'));
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

		if ($this->request->is(['post', 'delete'])) {

			$this->AccommodationType->id = $id;
			if (!$this->AccommodationType->exists()) {
				throw new NotFoundException(__('Invalid accommodation type'));
			}

			$accId = $this->AccommodationType->field('accommodation_type_id', array('AccommodationType.' . $this->AccommodationType->primaryKey => $id));
			if (!$accId) {
				throw new NotFoundException(__('Invalid accommodation type'));
			}

			if ($this->request->is('ajax')) {
	
				if ($this->AccommodationType->deleteAll(['AccommodationType.accommodation_type_id' => $accId])) {
					$response['type'] = 'success';
					$response['message'] = __('Accommodation Type has been deleted succesfully.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Accommodation Type could not be deleted. Please, try again.');
				}
				return json_encode($response);
			} else {

				if ($this->AccommodationType->deleteAll(['AccommodationType.accommodation_type_id' => $accId])) {
					$this->Flash->success(__('Accommodation Type has been deleted succesfully.'));
				} else {
					$this->Flash->error(__('Accommodation Type could not be deleted. Please, try again.'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

}
