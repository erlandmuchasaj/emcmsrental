<?php
App::uses('AppController', 'Controller');
/**
 * Contacts Controller
 *
 * @property Contact $Contact
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ContactsController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'Contacts';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Csv','Xls');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * beforeFilter method
 *
 * @return void
 */
 	public function beforeFilter() {
		parent::beforeFilter();
 		$this->Auth->allow('ajaxAddContact');
	}

/**
 * Ajax Add CONTACT method
 *
 * @return void
 */
	public function ajaxAddContact(){
		$this->autoRender = false;
		$this->layout = null;
		$this->request->onlyAllow('ajax');

		$response = array();
		$response['error'] = 0;
		$response['message'] = '';

		if ($this->request->is('post')) {
			$this->Contact->create();
			if(!$this->Contact->save($this->request->data)){
				$errors = $this->Contact->validationErrors;
				if (!empty($errors) && count($errors) > 0){
					$strError = '';
					foreach ($errors as $error){
						if (is_array($error)){
							$strError .= "<div>".implode("<br />", $error)."</div>";
						}else{
							$strError .= "<div>".$error ."</div>";
						}
					}
					$response['error'] = 1;
					$response['message'] = $strError;
				}
			} else {
				$lastID = $this->Contact->getLastInsertId();
				$contact = $this->Contact->find('first', array('conditions' => array('Contact.id' => $lastID), 'recursive' => 0));
				//Send Mail To Traveller
				$viewVars = array('sitename' =>  Configure::read('Website.name'));
				$maincontent  = __('Thank you for using our portal.');
				$maincontent .= __('<br>Your email has been saved to our newsletter list and, you will be notified when the site will be online.<br>');
				$maincontent .= __('<p>Thanks and Regards,</p>');
				$maincontent .= __('%s Team.', Configure::read('Website.name'));
				$maincontent .= '<br>';
				$optionsEmail = array(
					'viewVars' => $viewVars,
					'subject' => __('Contact'),
					'content' => $maincontent
				);

				if (!empty($contact['Contact']['email'])) {
					parent::__sendMail($contact['Contact']['email'], $optionsEmail);
				}
				$response['message'] =__('Contact was added successfully!');
			}
			echo json_encode($response);
			exit;
		}
	}


/**
 * contact_request method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function contact_request($id = null) {
		if (!$this->Contact->exists($id)) {
			throw new NotFoundException(__('Invalid contact'));
		}
		$options = array('conditions' => array('Contact.' . $this->Contact->primaryKey => $id));
		$this->set('contact', $this->Contact->find('first', $options));
	}

/**
 * contact_response method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function contact_response($id = null) {
		if (!$this->Contact->exists($id)) {
			throw new NotFoundException(__('Invalid contact'));
		}

		
		$options = array('conditions' => array('Contact.' . $this->Contact->primaryKey => $id));
		$this->set('contact', $this->Contact->find('first', $options));
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($search = null) {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}
		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if ($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = array();
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'index', '?' => array('search' => $this->request->data['Contact']['search'])));
		} elseif (isset($this->request->query['search']) && !empty($this->request->query['search'])) {
			$search = $this->request->query['search'];
			$conditions['or'] = array('Contact.email LIKE' => '%' . $search . '%', 'Contact.subject LIKE' => '%' . $search . '%', 'Contact.message LIKE' => '%' . $search . '%');
		}

		$this->Paginator->settings =  array(
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => 'Contact.id',
			'recursive' => -1,
			'contain' => false,
			'paramType' => 'querystring'
		);
		$contacts = $this->paginate('Contact');
		$this->set(compact('contacts', 'search'));

	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Contact->exists($id)) {
			throw new NotFoundException(__('Invalid contact'));
		}
		$options = array('conditions' => array('Contact.' . $this->Contact->primaryKey => $id));
		$this->set('contact', $this->Contact->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Contact->create();
			if ($this->Contact->save($this->request->data)) {
				$this->Flash->success(__('The contact has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The contact could not be saved. Please, try again.'));
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
		if (!$this->Contact->exists($id)) {
			throw new NotFoundException(__('Invalid contact'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Contact->save($this->request->data)) {
				$this->Flash->success(__('The contact has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The contact could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Contact.' . $this->Contact->primaryKey => $id));
			$this->request->data = $this->Contact->find('first', $options);
		}
	}

/**
 * is_read method
 *
 * @return void
 * @description mark as read messages.
 */
	public function admin_isRead($id = null){
		$this->autoRender = false;
		$this->Contact->save($this->request->data,false);
	}

/**
 * admin_csv method
 *
 * @return mix
 */
	public  function admin_csv(){
		Configure::write('debug', '0');
		$this->layout = null;
		$this->autoLayout = false;
		$this->set('contacts', $this->Contact->find('all', array('fields'=>array( 'email', 'subject', 'message', 'created'))));
	}

/**
 * admin_xls method
 *
 * @return mix
 */
	public function admin_xls() {
	  	Configure::write('debug', '0');
		$this->layout = null;
		$this->autoLayout = false;
		$this->set('contacts', $this->Contact->find('all', array('fields'=>array('email', 'subject', 'message', 'created'))));
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

		// $this->Contact->id = $id;
		// if ($this->request->is(['post', 'delete']))
			
		if ($this->request->is('ajax')) {
			if ($this->Contact->delete($id)) {
				$response['type'] = 'success';
				$response['message'] = __('The contact has been deleted.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('The contact could not be deleted. Please, try again!');
			}
			return json_encode($response);
		} else {
			if ($this->Contact->delete($id)) {
				$this->Flash->success(__('The contact has been deleted.'));
			} else {
				$this->Flash->error(__('The contact could not be deleted. Please, try again!'));
			}
			return $this->redirect(array('action' => 'index'));
		}
	}

}
