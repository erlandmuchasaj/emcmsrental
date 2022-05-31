<?php
App::uses('AppController', 'Controller');
/**
 * Wishlists Controller
 *
 * @property Wishlist $Wishlist
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class WishlistsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function wishlist_popup($model_id = null, $model = 'Property') {
		if ($this->request->is('ajax')){
			$this->autoRender = false;
			$this->layout = null;
		}

		$model = Inflector::classify($model);

		if (!$this->Wishlist->UserWishlist->{$model}->exists($model_id)) {
			throw new NotFoundException(__('Invalid %s', $model));
		}

		$wishlistCategories = $this->Wishlist->find('all', array(
			'conditions' => array(
				'Wishlist.user_id' => $this->Auth->user('id')
			)
		));
		foreach ($wishlistCategories as $key => $wishlistCategory) {
			if ($this->Wishlist->isInWishlist($model_id, $wishlistCategory['Wishlist']['id'], $model)) {
				$wishlistCategories[$key]['Wishlist']['short_listed'] = true;
			} else {
				$wishlistCategories[$key]['Wishlist']['short_listed'] = false;
			}
		}

		App::uses('Language', 'Model');
		$Language = new Language();
		$language_id = $Language->getActiveLanguageId();
		$this->Wishlist->UserWishlist->Property->unbindModel(array(
			'hasMany'=>array('PropertyTranslation')
		));
		$this->Wishlist->UserWishlist->Property->bindModel(array(
			'hasOne' => array(
				'PropertyTranslation' => array(
				    'foreignKey' => false,
				    'conditions' => array(
				    	'PropertyTranslation.property_id = Property.id', 
				    	'PropertyTranslation.language_id' => $language_id
				    ),
				    'className' => 'PropertyTranslation'
				),
			)
		));
		$options =  array(
		    'contain' => array(
		    	'PropertyTranslation',
		    	'User'
		    ),
		    'conditions' => array(
		        'Property.id' => $model_id
		    ),
		   	'fields' => array('Property.id', 'Property.country', 'Property.thumbnail', 'PropertyTranslation.title',  'User.image_path'),
		);
		$property = $this->Wishlist->UserWishlist->Property->find('first', $options);

		$this->set(compact('wishlistCategories','property'));
		$this->render('wishlist_popup', 'ajax'); 
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Wishlist->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => ['Wishlist.user_id' => $this->Auth->user('id')],
			'limit' => 30,
			'order' => array('Wishlist.created' => 'DESC'),
			'paramType' => 'querystring',
			'maxLimit' => 100
		);
		$this->set('wishlists', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Wishlist->exists($id)) {
			throw new NotFoundException(__('Invalid wishlist'));
		}
		$wishlist = $this->Wishlist->find('first', array('conditions' => array('Wishlist.' . $this->Wishlist->primaryKey => $id)));
		$this->set('wishlist', $wishlist);


		$this->Wishlist->UserWishlist->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => [
				'UserWishlist.wishlist_id'=> $id, 
				'UserWishlist.user_id' =>$this->Auth->user('id')
			],
			'contain' => [
				'Property'
			],
			'limit' => 30,
			'order' => array('UserWishlist.created' => 'DESC'),
			'paramType' => 'querystring',
			'maxLimit' => 100
		);
		$this->set('userWishlist', $this->Paginator->paginate('UserWishlist'));		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('ajax')){
			$this->autoRender = false;
			$this->layout = null;
		}

		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];


		if ($this->request->is('ajax')) {
			$this->Wishlist->create();
			$this->request->data['Wishlist']['user_id'] = $this->Auth->user('id');
			if ($this->Wishlist->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('Property was removed from your wishlist.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Property could not be removed from your wishlist. Please, try again.');
			}
			return json_encode($response);
		} elseif ($this->request->is('post')) {
			$this->Wishlist->create();
			$this->request->data['Wishlist']['user_id'] = $this->Auth->user('id');
			if ($this->Wishlist->save($this->request->data)) {
				$this->Flash->success(__('The wishlist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The wishlist could not be saved. Please, try again.'));
			}
		}
	}

/**
 * add method
 *
 * this function is used when adding a new property to wishlist
 *
 * @return void
 */
	public function addToWishlist($model_id = null, $wishlist_id = null, $model = 'Property') {
		if ($this->request->is('ajax')){
			$this->autoRender = false;
			$this->layout = null;
		}

		$model = Inflector::classify($model);

		if (!$this->Wishlist->UserWishlist->{$model}->exists($model_id)) {
			throw new NotFoundException(__('Invalid %s', $model));
		}

		if (!$this->Wishlist->exists($wishlist_id)) {
			throw new NotFoundException(__('Invalid wishlist'));
		}

		$response = [
			'message'=> '',
			'error' => 0,
			'type' 	=> 'info',
			'data' 	=> null,
		];

		if ($this->request->is('post')) {
			// property allredy exists from wishlist we remove it
			// else we add it 
			if (!$this->Wishlist->isInWishlist($model_id, $wishlist_id, $model)) {
				$this->Wishlist->UserWishlist->create();
				$this->request->data['UserWishlist']['user_id'] = $this->Auth->user('id');
				$this->request->data['UserWishlist']['wishlist_id'] = $wishlist_id;
				$this->request->data['UserWishlist']['model_id'] = $model_id;
				$this->request->data['UserWishlist']['model'] = $model;

				if ($this->Wishlist->UserWishlist->save($this->request->data)) {
					$response['type'] = 'success';
					$response['message'] = __('%s added to wishlist.', $model);
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('%s could not be added to wishlist. Please, try again.', $model);
				}
			} else {
				$options = array(
				    'UserWishlist.user_id' => $this->Auth->user('id'),
				    'UserWishlist.wishlist_id' => $wishlist_id, 
				    'UserWishlist.model_id' => $model_id,
				    'UserWishlist.model' => $model,
				);
				if ($this->Wishlist->UserWishlist->deleteAll($options, false)) {
					$response['type'] = 'success';
					$response['message'] = __('%s was removed from your wishlist.', $model);
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('%s could not be removed from your wishlist. Please, try again.', $model);
				}
			}
			return json_encode($response);
		}
	}	

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Wishlist->exists($id)) {
			throw new NotFoundException(__('Invalid wishlist'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Wishlist->save($this->request->data)) {
				$this->Flash->success(__('The wishlist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The wishlist could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Wishlist.' . $this->Wishlist->primaryKey => $id));
			$this->request->data = $this->Wishlist->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Wishlist->id = $id;
		if (!$this->Wishlist->exists()) {
			throw new NotFoundException(__('Invalid wishlist'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Wishlist->delete($id, true)) {
			$this->Flash->success(__('The wishlist has been deleted.'));
		} else {
			$this->Flash->error(__('The wishlist could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


/**
 * delete method
 *
 * @throws NotFoundException
 * @param int $id
 * @param int $wishlist_id the id of wishlist category ID
 * @return void
 */
	public function deleteElement($id = null, $wishlist_id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$this->Wishlist->UserWishlist->id = $id;
		if (!$this->Wishlist->UserWishlist->exists()) {
			throw new NotFoundException(__('Invalid wishlist'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Wishlist->UserWishlist->delete($id, true)) {
				$response['type'] = 'success';
				$response['message'] = __('Property was removed from your wishlist.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Property could not be removed from your wishlist. Please, try again.');
			}
			return json_encode($response);
		} elseif ($this->request->is('post')) {
			if ($this->Wishlist->UserWishlist->delete($id, true)) {
				$this->Flash->success(__('Property was removed from your wishlist.'));
			} else {
				$this->Flash->error(__('Property could not be removed from your wishlist. Please, try again.'));
			}
			return $this->redirect(array('action' => 'view', $wishlist_id ));
		}
	}

}
