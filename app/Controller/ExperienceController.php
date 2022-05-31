<?php
App::uses('AppController', 'Controller');
/**
 * Experiences Controller
 *
 * @property Experience $Experience
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ExperienceController extends AppController {

	public $name = 'Experience';

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
			'index',
			'view',
			'check',
			'getReviews',
			'featured'
		);
	}

/**
 * user authorization method
 *
 * @return void
 */
	public function isAuthorized($user = null) {
		return parent::isAuthorized($user);
	}

/**
 * changeStatus method
 * Makes an Experience featured
 * 
 * @return void
 */	
	public function featured() {

		if (empty($this->request->params['requested'])) {
		    throw new ForbiddenException();
		}

		$options =  array(
		    'contain' => array(
		        'Currency',
		        'Category',
		        'Subcategory',
		        # HasMany
		        'Image' => array(
		        	// 'conditions' => ['Image.is_cover' => 1]
		        	'limit' => 1,
		        ),
		    ),
		    'conditions' => array(
		        'Experience.is_approved' => 'approved',
		        'Experience.is_featured' => 1,
		        'Experience.status' => 1,
		    ),
		    'order' => array('Experience.sort' => 'ASC'),
		    'maxLimit' => 15,
		    'recursive' => 0,
		);
		$experiences = $this->Experience->find('all', $options);

		// $this->set('experiences', $experiences);

		return $experiences;
	}

/**
 * view method
 *
 * @return void
 */
	public function view($id = null) {
		if (!$this->Experience->exists($id)) {
			throw new NotFoundException(__('Invalid experience'));
		}

		$experience = $this->Experience->getExperience($id);

		if (!$experience) {
			$this->Flash->error(__('The experience could not be found!'));
			return $this->redirect($this->referer());
		}

		$this->set('experience', $experience);
	}

/**
 * view method
 *
 * @return void
 */
	public function getReviews($id = null) {
		if (!$this->Experience->exists($id)) {
			throw new NotFoundException(__('Invalid experience'));
		}

		$reviews = $this->Experience->getReviews($id);

		return json_encode($reviews);
	}

/**
 * view method
 *
 * @return void
 */
	public function check() {
		$this->autoRender = false;

		$response = [
			'error' => 0,
			'type' 	=> 'info',
			'data' 	=> null,
			'message' => '',
		];

		return json_encode($response);
	}


	/**
	 * view method
	 *
	 * @return void
	 */
		public function getAvailableDates($id = null) {
			if (!$this->Experience->exists($id)) {
				throw new NotFoundException(__('Invalid experience'));
			}

			$reviews = $this->Experience->getAvailableDates($id);

			return json_encode($reviews);
		}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {

		// $this->Experience->recursive = 0;
		// $this->set('experiences', $this->Paginator->paginate());
		
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if ($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$this->Paginator->settings = array(
			'limit' => $page_count,
			'order' => array('Experience.sort' => 'ASC'),
			'paramType' => 'querystring',
			'maxLimit' => 100,
			'recursive' => 0,
		);
		$experiences = $this->Paginator->paginate();
		$this->set(compact('experiences'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Experience->exists($id)) {
			throw new NotFoundException(__('Invalid experience'));
		}

		$options =  array(
		    'contain' => array(
		    	# BelongsTo
		        'User',
		        'Language',
		        'Timezone',
		        'Currency',
		        'Category',
		        'Subcategory',
		        # HasMany
		        'Image',
		        # HasOne
		        'Address' => [
		        	'Country',
		        ],
		    ),
		    'conditions' => array(
		        'Experience.' . $this->Experience->primaryKey => $id
		    ),
		    'recursive' => 0,
		);
		$experience = $this->Experience->find('first', $options);

		$this->set('experience', $experience);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {

		if ($this->request->is('post')) {

			$this->Experience->create();

			unset($this->request->data['Experience']['add_subcategory']);
			unset($this->request->data['Experience']['pack_list_nr']);

			$this->request->data['Experience']['user_id'] = $this->Auth->user('id');
			if ($this->Experience->saveAssociated($this->request->data)) {
				$this->Flash->success(__('The experience has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The experience could not be saved. Please, try again.'));
			}
		}

		$users = $this->Experience->User->find('list');
		$cities = $this->Experience->City->find('list');
		$languages = $this->Experience->Language->find('list');
		$timezones = $this->Experience->Timezone->find('list');
		$currencies = $this->Experience->Currency->find('list');
		$categories = $this->Experience->Category->find('list', array(
			'conditions' => array(
				'Category.status' => 1,
				'Category.model' => 'Experience',
			),
			'order' => array(
				'Category.name ASC',
			)
		));
		$subcategories = $this->Experience->Subcategory->find('list', array(
			'conditions' => array(
				'Subcategory.status' => 1,
				'Subcategory.model' => 'Experience',
			),
			'order' => array(
				'Subcategory.name ASC',
			)
		));
		$countries = $this->Experience->Address->Country->find('list', array(
			'fields' => array(
				'Country.id',
				'Country.name'
			),
			'order' => array(
				'Country.name ASC'
			)
		));

		$this->set(compact('users', 'cities', 'languages', 'timezones', 'currencies', 'categories', 'subcategories', 'countries'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Experience->exists($id)) {
			throw new NotFoundException(__('Invalid experience'));
		}
		if ($this->request->is(array('post', 'put'))) {

			unset($this->request->data['Experience']['add_subcategory']);
			unset($this->request->data['Experience']['pack_list_nr']);

			if ($this->Experience->saveAll($this->request->data, ['validate'=>'first', 'deep' => true])) {
				$this->Flash->success(__('The experience has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The experience could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Experience.' . $this->Experience->primaryKey => $id), 'recursive' => 0);
			$this->request->data = $this->Experience->find('first', $options);
		}

		$users = $this->Experience->User->find('list');
		$cities = $this->Experience->City->find('list');
		$languages = $this->Experience->Language->find('list');
		$timezones = $this->Experience->Timezone->find('list');
		$currencies = $this->Experience->Currency->find('list');
		$categories = $this->Experience->Category->find('list', array(
			'conditions' => array(
				'Category.status' => 1,
				'Category.model' => 'Experience',
			),
			'order' => array(
				'Category.name ASC',
			)
		));
		$subcategories = $this->Experience->Subcategory->find('list', array(
			'conditions' => array(
				'Subcategory.status' => 1,
				'Subcategory.model' => 'Experience',
			),
			'order' => array(
				'Subcategory.name ASC',
			)
		));
		$countries = $this->Experience->Address->Country->find('list', array(
			'fields' => array(
				'Country.id',
				'Country.name'
			),
			'order' => array(
				'Country.name ASC'
			)
		));

		$this->set(compact('users', 'cities', 'languages', 'timezones', 'currencies', 'categories', 'subcategories', 'countries'));
	}

/**
 * image method
 * Upload images for an experience
 * 
 * @return json
 */	
	public function admin_image($id = null) {
		$this->autoRender = false;
		$this->layout = null;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error'   => 0,	
			'type' 	  => 'info',
			'message' => '',
			'data' 	  => null,
		];

		$this->request->allowMethod('post', 'put');

		$this->Experience->id = $id;
		if (!$this->Experience->exists()) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('This experience does not exists!');
			return json_encode($response);
		}

		// Allow  MAX X images per property defined in site_configuration file
		$countPictures = (int) $this->Experience->Image->find('count', [
			'conditions' => array(
				'Image.model_id' => $id,
				'Image.model' => 'Experience',
			),
		]);

		$max_number = (int) Configure::read('Website.max_img_pic_property');
		if ($countPictures && ($countPictures > $max_number)) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Maximum number of images per one Experience reached. Delete some images first before you continue.');
			return json_encode($response);
		}

		$baseDir = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . 'Experience' . DS . $id . DS;

		App::uses('UploadLib', 'Lib');
		$this->UploadLib = new UploadLib($baseDir, true);

		$validate = $this->UploadLib->validateUpload($_FILES);
		if ($validate['is_valid'] !== true) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = $validate['message'];
			return json_encode($response);
		}


		$isUploaded = $this->UploadLib->uploadFile($_FILES);
		if ($isUploaded['is_valid'] !== true) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = $isUploaded['message'];
			return json_encode($response);
		}

		$data['Image']['model_id'] = $id;
		$data['Image']['model'] = 'Experience';
		$data['Image']['src'] = $isUploaded['filename'];

		$this->Experience->Image->create();
		if ($this->Experience->Image->save($data)) {
			$response['type'] = 'success';
			$response['message'] = __('Image uploaded successfully.');
		} else {
			if (file_exists($isUploaded['mainFile']) && is_file($isUploaded['mainFile'])) {
				@chmod($isUploaded['mainFile'], 0777); // NT ?
				@unlink($isUploaded['mainFile']);
			}
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Image could not be uploaded. Please Try again!');
		}

		return json_encode($response);
	}

/**
 * loadImages method
 * Load all images of an Experience
 * 
 * @return mixed
 */	
	public function admin_loadImages($id = null) {
		$this->autoRender = false;
		$this->layout = null;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error'   => 0,	
			'type' 	  => 'info',
			'message' => '',
			'data' 	  => null,
		];

		$this->request->allowMethod('post', 'put');

		$this->Experience->id = $id;
		if (!$this->Experience->exists()) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Experience feature status could not be changed. Please Try again!');
			return json_encode($response);
		}

		$images = $this->Experience->Image->find('all', [
			'conditions' => array(
				'Image.model_id' => $id,
				'Image.model' => 'Experience',
			), 
			'order' => array('Image.sort ASC'),
			'recursive' => -1,
			'callbacks' => false,
		]);

		$this->set('images', $images);
		$this->render('load_images', 'ajax');
	}

/**
 * admin_status method
 * Change admin approval status of an Experience
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_status($id = null) {

		$this->request->allowMethod('post', 'put');

		$this->Experience->id = $id;
		if (!$this->Experience->exists()) {
			$this->Flash->error(__('The experience could not be found.'));
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Experience->saveField('is_approved', $this->request->data['Experience']['is_approved'])) {
			$this->Flash->success(__('The experience status has been changed.'));
		} else {
			$this->Flash->error(__('The experience could not be changed. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * changeStatus method
 * Makes an Experience featured
 * 
 * @return void
 */	
	public function admin_featured() {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->Experience->save($this->request->data)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed feature status of this experience.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Experience feature status could not be changed. Please Try again!');
		}

		return json_encode($response);
	}

/**
 * changeStatus method
 * Change user status of Experience
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

		if ($this->request->is('ajax')){
			if ($this->Experience->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('You successfully changed this experience status.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Experience status could not be changed. Please Try again!');
			}
		}
		return json_encode($response);
	}

/**
 * Sort method
 *
 * @return void
 */	
	public function admin_sort() {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->is('ajax')) {
			if ($this->request->data['action'] == 'sort'){
				$array	= $this->request->data['arrayorder'];						
				$count = 1;
				foreach ($array as $idval) {
					$query = "UPDATE experiences SET sort={$count} WHERE id={$idval}";
					$this->Experience->query($query);
					$count ++;
				}
				$response['type'] = 'success';
				$response['message'] = __('Sort changed successfully.');
			}
		}
		return json_encode($response);
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

		$this->request->allowMethod('post', 'delete');

		if (!$this->Experience->exists($id)) {
			throw new NotFoundException(__('Invalid experience'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Experience->delete($id)) {
				$response['type'] = 'success';
				$response['message'] = __('Experience has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Experience could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} else {
			if ($this->Experience->delete($id)) {
				$this->Flash->success(__('Experience has been deleted.'));
			} else {
				$this->Flash->error(__('Experience could not be deleted. Please Try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

/**
 * admin_categories method
 *
 * @return void
 */
	public function admin_categories() {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) { 
			$page_count = $this->Session->read('per_page_count');
		}


		$this->Paginator->settings = array(
			'limit' => $page_count,
			'order' => array('Category.sort' => 'asc'),
			'conditions' => array(
			    'Category.model' => 'Experience',
			),
			'recursive' => -1,
			'paramType' => 'querystring',
			'maxLimit' => 100,
		);

		$categories = $this->paginate('Category');
		$this->set(compact('categories')); 
	}

}
