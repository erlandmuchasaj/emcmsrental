<?php
App::uses('AppController', 'Controller');
/**
 * RoomTypes Controller
 *
 * @property RoomType $RoomType
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class RoomTypesController extends AppController {

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
		$language_id = $this->RoomType->Language->getActiveLanguageId();

		$this->Paginator->settings =  array(
			'conditions' => array('RoomType.language_id' => $language_id),
			'contain' => array('Language'),
			'limit' => 20,
			'recursive'=>-1,
			'paramType' => 'querystring',
			'order' => array('RoomType.room_type_name' => 'asc'),
		);

		$roomTypes = $this->paginate('RoomType');
        $this->set(compact('roomTypes'));
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->RoomType->exists($id)) {
			throw new NotFoundException(__('Invalid room type'));
		}

		$roomId = $this->RoomType->field('room_type_id', array('RoomType.' . $this->RoomType->primaryKey => $id));

		if (!$roomId) {
			throw new NotFoundException(__('Invalid room type'));
		}

		$options =  array(
			'conditions' => array('RoomType.room_type_id' => $roomId),
			'contain' => array('Language'),
			'recursive'=>-1
		);
		$this->set('roomTypeList', $this->RoomType->find('all', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		$room_type_id = $this->RoomType->nextAvailableId();

		if ($this->request->is('post')) {
			$this->RoomType->create();

			// prepare default language
			$id_lang_default = $this->RoomType->Language->getDefaultLanguageId();
			$defaultName = '';
			if (isset($this->request->data['RoomType'][$id_lang_default])) {
				$defaultName = $this->request->data['RoomType'][$id_lang_default]['room_type_name'];
			}
			foreach ($this->request->data['RoomType'] as $id_lang => &$roomType) {
				if (empty($roomType['room_type_name'])) {
					$roomType['room_type_name'] = $defaultName;
				}
			}
			unset($roomType);

			if ($this->RoomType->saveMany($this->request->data['RoomType'])) {
				$this->Flash->success(__('The room type has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The room type could not be saved. Please, try again.'));
			}
		}

		$languages = $this->RoomType->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
		$this->set(compact('languages', 'room_type_id'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {

		if (!$this->RoomType->exists($id)) {
			throw new NotFoundException(__('Invalid room type'));
		}

		$roomId = $this->RoomType->field('room_type_id', array('RoomType.' . $this->RoomType->primaryKey => $id));
		if (!$roomId) {
			throw new NotFoundException(__('Invalid room type'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->RoomType->saveMany($this->request->data['RoomType'])) {
				$this->Flash->success(__('Room type has been updated successfully.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Room Type could not be updated. Please, try again.'));
			}
		}

		$translations = $this->RoomType->find('all', [
			'conditions' => [
				'RoomType.room_type_id' => $roomId
			],
			'contain' => [
				'Language',
			],
		]);

		$languages = $this->RoomType->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
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
		if (!$this->RoomType->exists($id)) {
			throw new NotFoundException(__('Invalid room type'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RoomType->save($this->request->data)) {
				$this->Flash->success(__('Room Type language has been updated succesfully.'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Flash->error(__('Room Type language could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RoomType.' . $this->RoomType->primaryKey => $id));
			$this->request->data = $this->RoomType->find('first', $options);
		}

		$language = $this->RoomType->Language->find('first', array('conditions' => array('Language.id' => $language_id), 'recursive'=>-1));
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

			$this->RoomType->id = $id;
			if (!$this->RoomType->exists()) {
				throw new NotFoundException(__('Invalid room type'));
			}

			$room_type_id = $this->RoomType->field('room_type_id', array('RoomType.' . $this->RoomType->primaryKey => $id));
			if (!$room_type_id) {
				throw new NotFoundException(__('Invalid room type'));
			}

			if ($this->request->is('ajax')) {
				if ($this->RoomType->deleteAll(array('RoomType.room_type_id' => $room_type_id))) {
					$response['type'] = 'success';
					$response['message'] = __('Room Type has been deleted succesfully.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Room Type could not be deleted. Please, try again.');
				}
				return json_encode($response);
			} else {
				if ($this->RoomType->deleteAll(array('RoomType.room_type_id' => $room_type_id))) {
					$this->Flash->success(__('Room Type has been deleted succesfully.'));
				} else {
					$this->Flash->error(__('Room Type could not be deleted. Please, try again.'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}
}