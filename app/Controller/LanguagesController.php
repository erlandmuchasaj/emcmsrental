<?php
App::uses('AppController', 'Controller');
/**
 * Languages Controller
 *
 * @property Language $Language
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LanguagesController extends AppController {

	/**
	 * Name
	 *
	 * @var string
	 */
	public $name = 'Languages';

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	/**
	 * beforeFIlter method
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
	    // The owner of a post can edit and delete it
	    if (in_array($this->action, array('admin_index', 'admin_view', 'admin_add', 'admin_edit', 'admin_enable', 'admin_disable', 'admin_makeDefault', 'admin_delete'))) {
	        if ($user['role'] !== 'admin') {
	            return false;
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
		$this->Language->recursive = -1;
		$this->set('languages', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Language->exists($id)) {
			throw new NotFoundException(__('Invalid language'));
		}
		$options = array('conditions' => array('Language.' . $this->Language->primaryKey => $id),'recursive'=>-1);
		$this->set('language', $this->Language->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {

		if ($this->request->is('post')) {
			$this->Language->create();

			$code = $this->request->data['Language']['language_code'];
			if (!array_key_exists($code, $this->Language->l10nMap)) {
				$this->Flash->warning(__('Language selected is not supported.'));
				return $this->redirect($this->referer());
			}

			$this->request->data['Language']['name'] =  $this->Language->l10nMap[$code];
			$this->request->data['Language']['locale'] =  $this->Language->l10nToIso[$code];

			if ($this->Language->save($this->request->data)) {
				$this->Flash->success(__('The language has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The language could not be saved. Please, try again.'));
			}
		}

		$this->set('availableLanguages', $this->Language->l10nMap);
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->Language->exists($id)) {
			throw new NotFoundException(__('Invalid language'));
		}
		if ($this->request->is(array('post', 'put'))) {

			if (isset($this->request->data['Language']['language_code'])) {
				$code = $this->request->data['Language']['language_code'];
				if (!array_key_exists($code, $this->Language->l10nMap)) {
					$this->Flash->warning(__('Language selected is not supported.'));
					return $this->redirect($this->referer());
				}
				$this->request->data['Language']['name'] =  $this->Language->l10nMap[$code];
				$this->request->data['Language']['locale'] =  $this->Language->l10nToIso[$code];
			}

			if ($this->Language->save($this->request->data)) {
				$this->Flash->success(__('The language has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The language could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Language.' . $this->Language->primaryKey => $id));
			$this->request->data = $this->Language->find('first', $options);
		}

		$this->set('availableLanguages', $this->Language->l10nMap);
	}

	/**
	 * publish method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_enable($id = null) {

		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid Language!'));
		}

		$this->request->allowMethod('post', 'put');

		if ($this->Language->updateAll(array('status'=>'1'),array('Language.' . $this->Language->primaryKey => $id))) {
			$this->Flash->success(__('Language has been activated Succesfully.'));
		} else {
			$this->Flash->error(__('Language could not be not be activated. Try again!'));
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

		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}

		$this->request->allowMethod('post', 'put');

		$language = $this->Language->read();

		if ((int)$language['Language']['is_default'] == 1) {
			$this->Flash->error(__('Sorry! You can not disable a default language.'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Session->read('Config.language') === $language['Language']['language_code']) {
			// Clean cookie and session of language
			$this->Session->delete('Config.language');
			$this->Cookie->delete('lang');
		}

		if ($this->request->is(array('post', 'put'))) {	
			if ($this->Language->updateAll(array('status'=>'0'), array('Language.' . $this->Language->primaryKey => $id))) {
				$this->Flash->success(__('Language was disabled Succesfully.'));
			} else {
				$this->Flash->error(__('Language could not be disabled. Please Try again!'));
			}
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
		        'Language.' . $this->Language->primaryKey => $id,
		        'Language.status' => 1
		    ]
		];
		$language = $this->Language->find('first', $options);

		if (!$language) {
			$this->Flash->error(__('Sorry! You can not set as default a disabled language.'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->request->allowMethod('post', 'put');

		$this->Language->updateAll(['is_default'=> '0']);

		if ($this->Language->updateAll(['is_default'=> 1], ['Language.' . $this->Language->primaryKey => $id, 'Language.status' => 1])) {
			// Clean cookie and session of languages
			$this->Session->delete('Config.language');
			$this->Cookie->delete('lang');
			$this->Flash->success(__('%s has been set as default language.', h($language['Language']['name'])));
		} else {
			$this->Flash->error(__('%s could not be set as default language. Try again!', h($language['Language']['name'])));
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
		
		$this->Language->id = $id;
		if (!$this->Language->exists()) {
			throw new NotFoundException(__('Invalid language'));
		}

		$this->request->allowMethod('post', 'delete');

		if ($this->Language->isDefault($id)) {
			$this->Flash->error(__('You can not delete a default language.'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Language->delete()) {
			$this->Flash->success(__('The language has been deleted.'));
		} else {
			$this->Flash->error(__('The language could not be deleted. Please, try again.'));
		}

		return $this->redirect(array('action' => 'index'));
	}

}
