<?php
App::uses('AppController', 'Controller');
/**
 * HomeSliders Controller
 *
 * @property HomeSlider $HomeSlider
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class HomeSlidersController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'HomeSliders';
	
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * Paginator Settings
 *
 * @var array
 */
	public $paginator_settings = array('limit' => 20,'order' => array('HomeSlider.sort' => 'asc'));

/**
 * beforeFilter method
 *
 * @return void
 */
 	public function beforeFilter() {
 		$this->Auth->allow('load');
		if (in_array($this->action, array('admin_deleteAll'))) {
			$this->Security->validatePost = false;
			$this->Security->csrfCheck = false;
		}
		parent::beforeFilter();
	}

/**
 * user authorization method
 *
 * @return void
 */

	public function isAuthorized($user = null) {
	    if (in_array($this->action, array('load'))) {
	    	return true;
	    }
	    return parent::isAuthorized($user);
	}

/**
 * load
 * Load Slider images on homescreen
 * 
 * @return json
 */
	public function load() {
		$this->layout = null;
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		$response['data'] = $this->HomeSlider->getSlider();
		return json_encode($response);
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}
		$this->Paginator->settings =  array(
			'limit' => $page_count,
			'order' => array('HomeSlider.sort' => 'asc'),
		);
		$homeSliders = $this->paginate('HomeSlider');
		$this->set(compact('homeSliders'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->HomeSlider->exists($id)) {
			throw new NotFoundException(__('Invalid home slider'));
		}
		$options = array('conditions' => array('HomeSlider.' . $this->HomeSlider->primaryKey => $id));
		$this->set('homeSlider', $this->HomeSlider->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->HomeSlider->create();
			if (empty($this->request->data['HomeSlider']['image_path']['name'])) {
				unset($this->request->data['HomeSlider']['image_path']);
			}
			if ($this->HomeSlider->save($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('The home slider has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The home slider could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->HomeSlider->exists($id)) {
			throw new NotFoundException(__('Invalid home slider'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['HomeSlider']['image_path']['name'])) {
				unset($this->request->data['HomeSlider']['image_path']);
			}
			if ($this->HomeSlider->save($this->request->data)) {
				$this->Flash->success(__('Slider image has been updated Succesfully.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Slider image could not be updated. Please, try again.'));
				// return $this->redirect(Router::url($this->referer(), true ) );
			}
		} else {
			$this->request->data = $this->HomeSlider->find('first', array(
				'conditions' => array('HomeSlider.' . $this->HomeSlider->primaryKey => $id)
			));
		}
	}

/**
 * Sort method
 *
 * @return void
 */
	public function admin_sort() {
		$this->autoRender = false;
		// This is Standart Format for all Ajax Call
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
					$query = " UPDATE home_sliders SET sort={$count} WHERE id={$idval}";
					$this->HomeSlider->query($query);
					$count ++;
				}
				$response['type'] = 'success';
				$response['message'] = __('Sort changed successfully.');
			}
		}
		return json_encode($response);
	}

/**
 * changeStatus method
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
			if ($this->HomeSlider->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('You successfully changed this Slider status.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Slider Status could not be changed. Please Try again!');
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

		if ($this->request->is('post')) {
			$this->HomeSlider->id = $id;
			if ($this->request->is('ajax')) {
				if ($this->HomeSlider->delete()) {
					$response['type'] = 'success';
					$response['message'] = __('Slider image has been deleted.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Slider image could not be deleted. Please Try again!');
				}
				return json_encode($response);
			} else {
				if ($this->HomeSlider->delete()) {
					$this->Flash->success(__('Slider image has been deleted.'));
				} else {
					$this->Flash->error(__('Slider image could not be deleted. Please Try again!'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_deleteAll($id = null) {
		$this->autoRender = false;
		$this->autoLayout = false;
		if(!empty($this->request->data)){
			$atLeastOneIsSelected = false;
			foreach($this->request->data['HomeSlider']['order_id'] as $key => $value) {
				if (isset($value) && $value!=0 && $value!='0') {
					$atLeastOneIsSelected = true;
				}
			}
		    if ($atLeastOneIsSelected) {
		        $selectedReferences = $this->request->data['HomeSlider']['order_id'];
		        foreach ($selectedReferences as $singleReference) {
		            $this->HomeSlider->id = $singleReference;
		            $this->HomeSlider->delete();
		        }
		        $this->Session->setFlash(__('image(s) has been deleted.'),'flash_success');
		    } else{
		    	$this->Session->setFlash(__('Select at least 1 image.'),'flash_error');
		    }
		} else {
			$this->Session->setFlash(__('Select at least 1 image!'),'flash_error');
		}
		 return $this->redirect($this->referer());
	}

}
