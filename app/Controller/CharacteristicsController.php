<?php
App::uses('AppController', 'Controller');
/**
 * Characteristics Controller
 *
 * @property Characteristic $Characteristic
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CharacteristicsController extends AppController {

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
		$language_id =	$this->Characteristic->CharacteristicTranslation->Language->getActiveLanguageId();

		// $this->Characteristic->unbindModel([
		// 	'hasMany'=>['CharacteristicTranslation']
		// ]);
		// $this->Characteristic->bindModel(array(
		// 	'hasOne' => array(
		// 		'CharacteristicTranslation' => array(
		// 		    'foreignKey' => 'characteristic_id',
		// 		    'conditions' => array(
		// 		    	'CharacteristicTranslation.characteristic_id = Characteristic.id',
		// 		    	'CharacteristicTranslation.language_id' => $language_id
		// 		    ),
		// 		    'className' => 'CharacteristicTranslation'
		// 		),
		// 	)
		// ));

		$this->Paginator->settings =  array(
			'joins' => array(
				array(
					'table' => 'characteristic_translations',
					'alias' => 'CharacteristicTranslation',
					'type' => 'LEFT',
					'conditions' => array('CharacteristicTranslation.characteristic_id = Characteristic.id')
				)
			),
			'conditions' => array('CharacteristicTranslation.language_id' => $language_id),
			'fields' => array(
				'Characteristic.id',
				'Characteristic.icon',
				'Characteristic.icon_class',
				'CharacteristicTranslation.id',
				'CharacteristicTranslation.characteristic_name',
			),
			'limit' => 20,
			'order' => array('Characteristic.id' => 'asc'),
			'contain' => 'CharacteristicTranslation',
			'paramType' => 'querystring',
			'recursive' => 0
		);
		$characteristics = $this->paginate('Characteristic');
		$this->set(compact('characteristics'));
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Characteristic->exists($id)) {
			throw new NotFoundException(__('Invalid characteristic'));
		}

		$options = array(
			'contain' => array(
				'CharacteristicTranslation.Language',
			),
			'conditions' => array(
				'Characteristic.'.$this->Characteristic->primaryKey => $id
			),
		);
		$this->set('characteristic', $this->Characteristic->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @throws NotFoundException
	 * @return void
	 */
	public function admin_add() {

		if ($this->request->is('post')) {

			$this->Characteristic->create();
			if (empty($this->request->data['Characteristic']['icon']['name'])) {
				unset($this->request->data['Characteristic']['icon']);
			}

			/**
			 * Here we can grab default language and dublicate 
			 * to all the fields if they are emtpy
			 */
			$id_lang_default = $this->Characteristic->CharacteristicTranslation->Language->getDefaultLanguageId();
			$defaultName = '';
			if (isset($this->request->data['CharacteristicTranslation'][$id_lang_default])) {
				$defaultName = $this->request->data['CharacteristicTranslation'][$id_lang_default]['characteristic_name'];
			}
			foreach ($this->request->data['CharacteristicTranslation'] as $id_lang => &$characteristic) {
				if (empty($characteristic['characteristic_name'])) {
					$characteristic['characteristic_name'] = $defaultName;
				}
			}
			unset($characteristic);

			$this->Characteristic->set($this->request->data);
			if ($this->Characteristic->validates()) {
			    // it validated logic
			    if ($this->Characteristic->saveAssociated($this->request->data, ['validate'=>'first',  'deep' => false])) {
			    	$this->Flash->success(__('The characteristic has been saved.'));
			    	return $this->redirect(array('action' => 'index'));
			    } else {
			    	$errors = $this->Characteristic->validationErrors;
			    	$this->Flash->error(__('The characteristic could not be saved. Please, try again.'));
			    }
			} else {
			    // didn't validate logic
		    	$this->Flash->error(__('The characteristic could not be saved. Please, try again.'));
			}
		}

		$languages = $this->Characteristic->CharacteristicTranslation->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
		$this->set(compact('languages', 'errors'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {

		if (!$this->Characteristic->exists($id)) {
			throw new NotFoundException(__('Invalid characteristic'));
		}


		if ($this->request->is(array('post', 'put'))) {

			if (empty($this->request->data['Characteristic']['icon']['name'])) {
				unset($this->request->data['Characteristic']['icon']);
			}

			// /**
			//  * Here we can grab default language and dublicate 
			//  * to all the fields if they are emtpy
			//  */
			// $id_lang_default = $this->Characteristic->CharacteristicTranslation->Language->getDefaultLanguageId();
			// $defaultName = '';
			// if (isset($this->request->data['CharacteristicTranslation'][$id_lang_default])) {
			// 	$defaultName = $this->request->data['CharacteristicTranslation'][$id_lang_default]['characteristic_name'];
			// }
			// foreach ($this->request->data['CharacteristicTranslation'] as $id_lang => &$characteristic) {
			// 	if (empty($characteristic['characteristic_name'])) {
			// 		$characteristic['characteristic_name'] = $defaultName;
			// 	}
			// }
			// unset($characteristic);

			if ($this->Characteristic->saveAssociated($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The characteristic has been updated.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The characteristic could not be updated. Please, try again.'));
			}

		} else {
			$this->Characteristic->Behaviors->load('Containable');
			$this->request->data = $this->Characteristic->find('first', [
				'contain' => [
					'CharacteristicTranslation.Language'
				],
				'conditions' => [
					'Characteristic.' . $this->Characteristic->primaryKey => $id
				],
			]);
		}

		$languages = $this->Characteristic->CharacteristicTranslation->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
		$this->set(compact('languages'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_editLanguage($id = null, $language_id = null) {

		if (!$this->Characteristic->CharacteristicTranslation->exists($id)) {
			throw new NotFoundException(__('Invalid characteristic translation'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$redirect_id = $this->request->data['CharacteristicTranslation']['characteristic_id'];
			if ($this->Characteristic->CharacteristicTranslation->save($this->request->data)) {
				$this->Flash->success(__('The characteristic translation has been updated.'));
				return $this->redirect(array('admin'=>true ,'controller'=>'characteristics' ,'action' => 'view', $redirect_id));
			} else {
				$this->Flash->error(__('The characteristic translation could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CharacteristicTranslation.' . $this->Characteristic->CharacteristicTranslation->primaryKey => $id));
			$this->request->data = $this->Characteristic->CharacteristicTranslation->find('first', $options);
		}

		$language = $this->Characteristic->CharacteristicTranslation->Language->find('first', array('conditions' => array('Language.id' => $language_id), 'recursive'=>-1));
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

			$this->Characteristic->id = $id;
			if (!$this->Characteristic->exists()) {
				throw new NotFoundException(__('Invalid characteristic'));
			}

			if ($this->request->is('ajax')) {
				if ($this->Characteristic->delete($id, true)) {
					$response['type'] = 'success';
					$response['message'] = __('Characteristic has been deleted succesfully.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Characteristic could not be deleted. Please, try again.');
				}
				return json_encode($response);
			} else {
				if ($this->Characteristic->delete($id, true)) {
					$this->Flash->success(__('The characteristic has been deleted.'));
				} else {
					$this->Flash->error(__('The characteristic could not be deleted. Please, try again.'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

}
