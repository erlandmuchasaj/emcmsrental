<?php
App::uses('AppController', 'Controller');
/**
 * PropertyPictures Controller
 *
 * @property PropertyPicture $PropertyPicture
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PropertyPicturesController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'PropertyPictures';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = [];

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * save Images comming from dropzone
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function processImage($property_id = null) {
		$this->autoRender = false;
		$this->layout = null;
		$this->request->allowMethod('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> __('Image uploaded successfully.'),
			'data' 		=> null,
		];

		if (!$property_id) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Property ID is not set. Please refresh the page and try again!');
			return json_encode($response);
		}

		if (!$this->PropertyPicture->Property->exists($property_id)) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Property that you are trying to access does not exist. Please refresh the page and try again!');
			return json_encode($response);
		}

		// Allow  MAX X images per property defined in site_configuration file
		$countPictures = (int) $this->PropertyPicture->find('count', array('conditions' => array('PropertyPicture.property_id'=>$property_id)));
		$max_number = (int) Configure::read('Website.max_img_pic_property');
		if ($countPictures && $countPictures > $max_number) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Maximum number of images per one property reached. Delete some images first before you continue.');
			return json_encode($response);
		}

		$baseDir = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . 'Property' . DS . $property_id . DS . 'PropertyPicture' . DS;

		App::uses('UploadLib', 'Lib');
		$this->UploadLib = new UploadLib($baseDir, true);


		$validate = $this->UploadLib->validateUpload($_FILES);
		if ($validate['is_valid'] !== true) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = $validate['message'];
			return json_encode($response);
		}

		$this->PropertyPicture->create();
		$isUploaded = $this->UploadLib->uploadFile($_FILES);
		if (isset($isUploaded['is_valid']) && ($isUploaded['is_valid'] === true)) {
			$data['PropertyPicture']['property_id'] = $property_id;
			$data['PropertyPicture']['image_path'] = $isUploaded['filename'];
			$data['PropertyPicture']['user_id'] = $this->Auth->user('id');
			if (!$this->PropertyPicture->save($data)) {
				if (file_exists($isUploaded['mainFile']) && is_file($isUploaded['mainFile'])) {
					@chmod($isUploaded['mainFile'], 0777); // NT ?
					@unlink($isUploaded['mainFile']);
				}
			}
			$this->PropertyPicture->updateThumbnail($property_id);
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = $isUploaded['message'];
			return json_encode($response);
		}
		$this->PropertyPicture->clear();
		return json_encode($response);
	}

/**
 * Add Image Caption
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function addCaption($id = null) {
		$this->autoRender = false;
		$this->request->allowMethod('ajax');

		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if (!$id) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Prperty Picture ID is not set. Please refresh the page and try again!');
			return json_encode($response);
		}

		if (!$this->PropertyPicture->exists($id)) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Prperty Picture that you are trying to access doos not exist. Please refresh the page and try again!');
			return json_encode($response);
		}

		if ($this->PropertyPicture->save($this->request->data)) {
			$response['type'] = 'success';
			$response['message'] = __('Prperty Picture caption has been saved successfully.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Prperty Picture caption could not be saved. Please refresh the page and try again!');
		}
		return json_encode($response);
	}

/**
 * Load Images
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function loadImages($property_id = null) {
		$this->autoRender = false;
		$this->layout = null;

		$this->request->allowMethod('ajax');

		if (!$property_id) {
			echo __('Property ID is not set. Please refresh the page and try again!');
			exit;
		}

		if (!$this->PropertyPicture->Property->exists($property_id)) {
			echo  __('Property that you are trying to access does not exist. Please refresh the page and try again!');
			exit;
		}

		$this->PropertyPicture->updateThumbnail($property_id);

		if (isset($this->request->data['action']) && $this->request->data['action'] === 'get_images') {
			$propertyImages = $this->PropertyPicture->find('all', [
				'conditions'=> array('PropertyPicture.property_id'=>$property_id), 
				'order' => array('PropertyPicture.sort ASC'),
				'recursive' => -1,
				'callbacks' => false,
			]);
			$this->set('propertyImages', $propertyImages);
			$this->render('load_images', 'ajax');
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$this->request->allowMethod('post', 'delete');

		if (!$this->PropertyPicture->exists($id)) {
			throw new NotFoundException(__('Invalid property picture'));
		}

		if ($this->request->is('ajax')) {
			if ($this->PropertyPicture->delete($id, true)) {
				$response['type'] = 'success';
				$response['message'] = __('PropertyPicture has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('PropertyPicture could not be deleted. Please Try again!');
			}
			$property_id = $this->PropertyPicture->field('property_id', array('id' => $id));
			$this->PropertyPicture->updateThumbnail($property_id);
			return json_encode($response);
		} else {
			if ($this->PropertyPicture->delete($id, true)) {
				$this->Flash->success(__('PropertyPicture has been deleted.'));
			} else {
				$this->Flash->error(__('PropertyPicture could not be deleted. Please Try again!'));
			}
			$property_id = $this->PropertyPicture->field('property_id',array('id' => $id));
			$this->PropertyPicture->updateThumbnail($property_id);
			return $this->redirect(array('action' => 'index'));
		}
	}

/**
 * Sort method
 *
 * @return void
 */
	public function sortImages($property_id = null) {
		$this->autoRender = false;
		$this->request->allowMethod('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if (isset($this->request->data['action']) && $this->request->data['action'] === 'sort') {
			$array = $this->request->data['arrayorder'];
			$count = 1;
			foreach ($array as $idval) {
				$query = "UPDATE property_pictures SET sort={$count} WHERE id={$idval}";
				$this->PropertyPicture->query($query);
				$count ++;
			}
			$this->PropertyPicture->updateThumbnail($property_id);
			$response['type'] = 'success';
			$response['message'] = __('Sort changed successfully.');
		}
		return json_encode($response);
	}

}