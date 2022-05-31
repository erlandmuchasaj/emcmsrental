<?php
App::uses('AppController', 'Controller');
/**
 * Images Controller
 *
 * @property Image $Image
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ImagesController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Images';

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
 * Add Image Caption
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function caption($id = null) {
		$this->autoRender = false;
		$this->request->allowMethod('ajax');

		$response = [
			'error' => 0,		
			'type' 	=> 'info',
			'message'=> '',
			'data' 	=> null,
		];

		if (!$this->Image->exists($id)) {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Image that you are trying to access doos not exist!');
			return json_encode($response);
		}

		if ($this->Image->save($this->request->data)) {
			$response['type'] = 'success';
			$response['message'] = __('Image caption has been saved successfully.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Image caption could not be saved. Please try again!');
		}
		return json_encode($response);
	}

/**
 * Sort method
 *
 * @return void
 */
	public function sort($id = null) {
		$this->autoRender = false;
		$this->request->allowMethod('ajax');
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' => 0,
			'type' 	=> 'info',
			'message' => '',
			'data' 	=> null,
		];

		$array = $this->request->data['arrayorder'];
		$count = 1;
		foreach ($array as $idval) {
			$query = "UPDATE images SET sort={$count} WHERE id={$idval}";
			$this->Image->query($query);
			$count ++;
		}
		
		$response['type'] = 'success';
		$response['message'] = __('Sort changed successfully.');

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
	public function delete($id = null) {
		$this->autoRender = false;

		$response = [
			'error' => 0,		
			'type' 	=> 'info',
			'message' => '',
			'data' 	=> null,
		];

		$this->request->allowMethod('post', 'delete');

		if (!$this->Image->exists($id)) {
			throw new NotFoundException(__('Invalid property picture'));
		}

		if ($this->request->is('ajax')) {
			if ($this->Image->delete($id)) {
				$response['type'] = 'success';
				$response['message'] = __('Image has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Image could not be deleted. Please Try again!');
			}
			return json_encode($response);
		} else {
			if ($this->Image->delete($id)) {
				$this->Flash->success(__('Image has been deleted.'));
			} else {
				$this->Flash->error(__('Image could not be deleted. Please Try again!'));
			}
			return $this->redirect($this->referer());
		}
	}

}