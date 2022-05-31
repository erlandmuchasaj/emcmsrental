<?php
App::uses('AppController', 'Controller');
/**
 * Safeties Controller
 *
 * @property Safety $Safety
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SafetiesController extends AppController {

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
		$language_id =	$this->Safety->SafetyTranslation->Language->getActiveLanguageId();

		$this->Paginator->settings =  array(
			'joins' => array(
				array(
					'table' => 'safety_translations',
					'alias' => 'SafetyTranslation',
					'type' => 'LEFT',
					'conditions' => array('SafetyTranslation.safety_id = Safety.id')
				)
			),
			'conditions' => array('SafetyTranslation.language_id' => $language_id),
			'limit' => 20,
			'order' => array('Safety.id' => 'ASC'),
			'fields' => array(
				'Safety.id',
				'Safety.icon',
				'Safety.icon_class',
				'SafetyTranslation.id',
				'SafetyTranslation.safety_name',
			),
			'paramType' => 'querystring',
			'recursive' => -1
		);
		$safeties = $this->paginate('Safety');
		$this->set(compact('safeties'));
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Safety->exists($id)) {
			throw new NotFoundException(__('Invalid safety'));
		}

		$options = array(
			'contain' => array(
				'SafetyTranslation.Language',
			),
			'conditions' => array(
				'Safety.'.$this->Safety->primaryKey => $id
			),
		);
		$this->set('safety', $this->Safety->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Safety->create();
			if (empty($this->request->data['Safety']['icon']['name'])) {
				unset($this->request->data['Safety']['icon']);
			}

			/**
			 * Here we can grab default language and dublicate 
			 * to all the fields if they are emtpy
			 */
			$id_lang_default = $this->Safety->SafetyTranslation->Language->getDefaultLanguageId();
			$defaultName = '';
			if (isset($this->request->data['SafetyTranslation'][$id_lang_default])) {
				$defaultName = $this->request->data['SafetyTranslation'][$id_lang_default]['safety_name'];
			}
			foreach ($this->request->data['SafetyTranslation'] as $id_lang => &$safety) {
				if (empty($safety['safety_name'])) {
					$safety['safety_name'] = $defaultName;
				}
			}
			unset($safety);

			if ($this->Safety->saveAssociated($this->request->data, array('validate'=>'first', 'deep' => false))) {
				$this->Flash->success(__('The safety has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				// didn't validate logic
				$errors = $this->Safety->validationErrors;
				$this->Flash->error(__('The safety could not be saved. Please, try again.'));
			}
		}

		$languages = $this->Safety->SafetyTranslation->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
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

		if (!$this->Safety->exists($id)) {
			throw new NotFoundException(__('Invalid safety'));
		}

		if ($this->request->is(array('post', 'put'))) {

			if (empty($this->request->data['Safety']['icon']['name'])) {
				unset($this->request->data['Safety']['icon']);
			}

			// /**
			//  * Here we can grab default language and dublicate 
			//  * to all the fields if they are emtpy
			//  */
			// $defaultName = '';
			// $id_lang_default = $this->Safety->SafetyTranslation->Language->getDefaultLanguageId();
			// if (isset($this->request->data['SafetyTranslation'][$id_lang_default])) {
			// 	$defaultName = $this->request->data['SafetyTranslation'][$id_lang_default]['safety_name'];
			// }
			// foreach ($this->request->data['SafetyTranslation'] as $id_lang => &$safety) {
			// 	if (empty($safety['safety_name'])) {
			// 		$safety['safety_name'] = $defaultName;
			// 	}
			// }
			// unset($safety);

			if ($this->Safety->saveAssociated($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The safety has been updated.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The safety could not be updated. Please, try again.'));
			}
		} else {
			$this->Safety->Behaviors->load('Containable');
			$this->request->data = $this->Safety->find('first', array(
				'contain' => [
					'SafetyTranslation.Language'
				],
				'conditions' => array('Safety.' . $this->Safety->primaryKey => $id),
			));
		}

		$languages = $this->Safety->SafetyTranslation->Language->find('all', array('conditions' => array('Language.status' => 1), 'recursive'=>-1));
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
		if (!$this->Safety->SafetyTranslation->exists($id)) {
			throw new NotFoundException(__('Invalid safety translation'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$redirect_id = $this->request->data['SafetyTranslation']['safety_id'];
			if ($this->Safety->SafetyTranslation->save($this->request->data)) {
				$this->Flash->success(__('The safety translation has been updated.'));
				return $this->redirect(array('admin'=>true, 'controller'=>'safeties', 'action' => 'view', $redirect_id));
			} else {
				$this->Flash->error(__('The safety translation could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SafetyTranslation.' . $this->Safety->SafetyTranslation->primaryKey => $id));
			$this->request->data = $this->Safety->SafetyTranslation->find('first', $options);
		}

		$language = $this->Safety->SafetyTranslation->Language->find('first', array('conditions' => array('Language.id' => $language_id), 'recursive'=>-1));
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

			$this->Safety->id = $id;
			if (!$this->Safety->exists()) {
				throw new NotFoundException(__('Invalid safety'));
			}

			if ($this->request->is('ajax')) {
				if ($this->Safety->delete($id, true)) {
					$response['type'] = 'success';
					$response['message'] = __('Safety has been deleted succesfully.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Safety could not be deleted. Please, try again.');
				}
				return json_encode($response);
			} else {
				if ($this->Safety->delete($id, true)) {
					$this->Flash->success(__('The safety has been deleted.'));
				} else {
					$this->Flash->error(__('The safety could not be deleted. Please, try again.'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

}
