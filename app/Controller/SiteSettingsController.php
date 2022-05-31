<?php
App::uses('AppController', 'Controller');
/*App::Import('ConnectionManager'); */
/**
 * SiteSettings Controller
 *
 * @property SiteSetting $SiteSetting
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SiteSettingsController extends AppController {

/**
 * Name
 *
 * @var string
 */
	public $name = 'SiteSettings';

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = [];

/**
 * Uses
 *
 * @var array
 */

// public $uses = array('SiteSettings, Banner');

/**
 * SiteSetting keys
 */
	const GENERAL = 'GENERAL';
	const CREDIT_CARD = 'CREDIT_CARD';
	const POLICY = 'POLICY';
	const SITE_FEE = 'SITE_FEE';
	const TERMS_AND_CONDITIONS = 'TERMS_AND_CONDITIONS';
	const NEW_USER = 'NEW_USER';
	const RESET_PASSWORD = 'RESET_PASSWORD';
	const HOME_SETTINGS = 'HOME_SETTINGS';
	const LOGO = 'LOGO';

/**
 * beforeFilter method
 *
 * @return void
 */
 	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('getSettings', 'loadSettings', 'featured');
	}


	public function beforeRender(){
		parent::beforeRender();
	}

/**
 * user authorization method
 *
 * @return void
 */
	public function isAuthorized($user = null) {
	    if ($user['role'] === 'admin') {
	        return true;
	    }
	    return parent::isAuthorized($user);
	}

/**
 * getSettings method
 *
 * @return array
 */
	public function getSettings() {
		$globalSettings = $this->SiteSetting->find('first',array('conditions' => array('key' => self::GENERAL), 'recursive' => -1));
		if (!empty($globalSettings)){
			$globalSettings = json_decode($globalSettings['SiteSetting']['value'], true);
		}
		if ($this->request->is('requested')) {
            return $globalSettings;
        }

        $this->set('globalSettings', $globalSettings);
	}

/**
 * loadSettings method
 *
 * @return array
 */
	public function loadSettings() {
		$settings = $this->SiteSetting->load();
		if ($this->request->is('requested')) {
            return $settings;
        }
        $this->set('settings', $settings);
	}

/**
 * site setting method
 *
 * @return void
 */
	public function admin_index() {

		$siteSetting = $this->SiteSetting->find('first', array('conditions' => array('key' => self::GENERAL)));

		if (isset($siteSetting) && !empty($siteSetting)) {
			$data = json_decode($siteSetting['SiteSetting']['value'], true);
			if (!empty($data)) {
				$this->request->data = am($this->request->data, $data);
			} else {
				$this->request->data['SiteSetting'] = Configure::read('Website');
			}
		} else {
			// first time grab default value from config folder
			$this->request->data['SiteSetting'] = Configure::read('Website');
		}
		
		$this->request->data['SiteSetting']['key'] = self::GENERAL;

		$this->loadModel('Language');
		$this->loadModel('Currency');

		$languages = $this->Language->find('list', [
			'conditions' => ['Language.status'=>1],
			'order' => ['Language.sort' => 'asc'],
			'fields' => ['Language.language_code', 'Language.name'],
			'recursive'=>-1
		]);

		$currencies = $this->Currency->find('list', [
			'conditions' => ['Currency.status'=>1],
			'order' => ['Currency.sort' => 'asc'],
			'fields' => ['Currency.code', 'Currency.name'],
			'recursive'=>-1
		]);

		$timezones = $this->SiteSetting->query('SELECT Timezone.name as name, Timezone.name as value  FROM timezones AS Timezone');
		$timezones = Hash::extract($timezones, '{n}.Timezone');

		$this->set(compact('languages', 'currencies', 'timezones'));
	}

	public function admin_credit_card() {
		$this->request->data['SiteSetting']['key'] = self::CREDIT_CARD;
		$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
		if (isset($siteSetting) && !empty($siteSetting)){
			//$data = unserialize($setting['SiteSetting']['value']);
			$data = json_decode($siteSetting['SiteSetting']['value'], true);
			if (isset($data) && !empty($data)){
				$this->request->data = am($this->request->data, $data);
			}
		}
	}

	public function admin_policy() {
		$this->helpers[] = 'Froala.Froala';
		$this->request->data['SiteSetting']['key'] = self::POLICY;
		$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
		if (isset($siteSetting) && !empty($siteSetting)){
			//$data = unserialize($setting['SiteSetting']['value']);
			$data = json_decode($siteSetting['SiteSetting']['value'], true);
			if (isset($data) && !empty($data)){
				$this->request->data = am($this->request->data, $data);
			}
		}
	}

	public function admin_terms_conditions() {
		$this->helpers[] = 'Froala.Froala';
		$this->request->data['SiteSetting']['key'] = self::TERMS_AND_CONDITIONS;
		$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
		if (isset($siteSetting) && !empty($siteSetting)){
			//$data = unserialize($setting['SiteSetting']['value']);
			$data = json_decode($siteSetting['SiteSetting']['value'], true);
			if (isset($data) && !empty($data)){
				$this->request->data = am($this->request->data, $data);
			}
		}
	}

	public function admin_siteFee() {
		$this->request->data['SiteSetting']['key'] = self::SITE_FEE;
		$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
		if (isset($siteSetting) && !empty($siteSetting)){
			$data = json_decode($siteSetting['SiteSetting']['value'], true);
			if (isset($data) && !empty($data)){
				$this->request->data = am($this->request->data, $data);
			}
		}
	}

	public function admin_home_settings() {
		$this->request->data['SiteSetting']['key'] = self::HOME_SETTINGS;
		$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
		if ($siteSetting) {
			$data = json_decode($siteSetting['SiteSetting']['value'], true);
			if (isset($data) && !empty($data)){
				$this->request->data = am($this->request->data, $data);
			}
		}
	}

	/**
	 * index method
	 *
	 * @return null
	 */
	public function admin_logo() {
		if ($this->request->is('ajax')){
			$this->layout = null;
			$this->autoRender = false;
		}

		$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS . $this->SiteSetting->alias . DS . 'logo' . DS;

		if ($this->request->is(array('post', 'put'))) {
			$errors = [];
			$response = [
				'error' 	=> 0,		// 0 | 1
				'type' 		=> 'info',	// info, warning, error, success
				'message' 	=> '',
				'data' 		=> null,
			];

			// array to hold proper formated data
			$siteSetting = array();
			// prepare the data for DB to be saved
			$siteSetting['SiteSetting']['key'] = $this->request->data['SiteSetting']['key'];

			// first we validate if it is as wee need the array posted to controller
			$this->SiteSetting->set($this->request->data);

			// Then we check if is one of our supported fields
			if (!isset($this->request->data['SiteSetting']['key']) || empty($this->request->data['SiteSetting']['key'])) {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('You can not directly modify SiteSetting [KEY] value!');
				return json_encode($response);
			}
			
			if (empty($this->request->data['SiteSetting']['logo']['name'])) {
				unset($this->request->data['SiteSetting']['logo']);
			}

			$oldPicPath = '';
			$oldSetting = $this->SiteSetting->find('first', ['conditions' => array('key' => self::LOGO)]);
			
			if (isset($oldSetting['SiteSetting']['value']) && !empty($oldSetting['SiteSetting']['value'])) {
				$oldSettingData = json_decode($oldSetting['SiteSetting']['value'], true);
				if (isset($oldSettingData['SiteSetting']['logo']) && !empty($oldSettingData['SiteSetting']['logo'])) {
					$oldPicPath = (string)$oldSettingData['SiteSetting']['logo'];
				}
			}

			App::uses('UploadLib', 'Lib');

			if (isset($this->request->data['SiteSetting']['logo'])) {

				$this->UploadLogo = new UploadLib($directory, false, 1048576);

				$validate = $this->UploadLogo->validateUpload($this->request->data['SiteSetting'], 'logo');
				if ($validate['is_valid'] !== true) {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = $validate['message'];
					return json_encode($response);
				}

				$isUploadedLogo = $this->UploadLogo->uploadFile($this->request->data['SiteSetting'], [], 'logo');
				if ($isUploadedLogo['is_valid'] !== true) {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = $isUploadedLogo['message'];
					return json_encode($response);
				}

				$this->request->data['SiteSetting']['logo'] = $isUploadedLogo['filename'];
				# - Here chech which was uploaded and delete the old one
				$siteSetting['SiteSetting']['value'] = json_encode(array('SiteSetting' => $this->request->data['SiteSetting']));
				if ($this->SiteSetting->save($siteSetting)) {
					$deleteOldLogo = $directory.$oldPicPath;
					if (!empty($deleteOldLogo)) {
						if (file_exists($deleteOldLogo) && is_file($deleteOldLogo)) {
							@unlink($deleteOldLogo); 
						}
					}
					$response['error'] = 0;
					$response['type'] = 'success';
					$response['message'] = 'Site setting logo has been updated.';  
				} else {
					if (file_exists($isUploadedLogo['mainFile']) && is_file($iisUploadedLogosUploaded['mainFile'])) {
						@chmod($isUploadedLogo['mainFile'], 0777); // NT ?
						@unlink($isUploadedLogo['mainFile']);
					}

					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = 'Site setting logo could not be updated. Please try again!';  
				}
			} 

			return json_encode($response);
			exit;
		} else {
			$this->request->data['SiteSetting']['key'] = self::LOGO;
			$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
			if (isset($siteSetting) && !empty($siteSetting)){
				//$data = unserialize($setting['SiteSetting']['value']);
				$data = json_decode($siteSetting['SiteSetting']['value'], true);
				if (isset($data) && !empty($data)){
					$this->request->data = am($this->request->data, $data);
				}
			}
		}
	}

	/**
	 * send email method
	 * elements that can be used throughout application as email constants are
	 * {user_name},
	 * {user_surname},
	 * {site_name},
	 * {user_email},
	 * {site_email},
	 * {user_activation_link}
	 * {user_password}
	 *
	 * @return json
	 */
	public function admin_email($type = 'new_user'){
		$this->helpers[] = 'Froala.Froala';

		$this->autoRender = false;
		if ($type === 'new_user'){
			$this->request->data['SiteSetting']['key'] = self::NEW_USER;
			$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
			if (isset($siteSetting) && !empty($siteSetting)){
				$data = json_decode($siteSetting['SiteSetting']['value'], true);
				if (!empty($data)){
					$this->request->data = am($this->request->data,$data);
				}
			}
			$this->render('admin_new_user');
		} elseif ($type === 'reset_password'){
			$this->request->data['SiteSetting']['key'] = self::RESET_PASSWORD;
			$siteSetting = $this->SiteSetting->find('first',array('conditions' => array('key' => $this->request->data['SiteSetting']['key'])));
			if (isset($siteSetting) && !empty($siteSetting)){
				$data = json_decode($siteSetting['SiteSetting']['value'], true);
				if (!empty($data)){
					$this->request->data = am($this->request->data,$data);
				}
			}
			$this->render('admin_reset_password');
		}
	}

	/**
	 * save method
	 *
	 * @return json
	 */
		public function admin_save($key = null) {
			$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS . $this->SiteSetting->alias . DS . 'logo' . DS;
			$logoUpload = false;
			$oldPicPath = '';


			$this->autoRender = false;
			// This is Standart FOrmat for all Ajax Call
			$response = [
				'error' 	=> 0,		// 0 | 1
				'type' 		=> 'info',	// info, warning, error, success
				'message' 	=> '',
				'data' 		=> null,
			];

			// array to hold proper formated data
			$siteSetting = array();

			// first we validate if it is as wee need the array posted to controller
			$this->SiteSetting->set($this->request->data);

			// Then we check if is one of our supported fields
			if (!isset($this->request->data['SiteSetting']['key']) || empty($this->request->data['SiteSetting']['key'])) {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('You can not directly modify SiteSetting [KEY] value!');
				return json_encode($response);
			}

			if (self::GENERAL === $this->request->data['SiteSetting']['key'] && $key === self::GENERAL) {
				$this->SiteSetting->validate = $this->SiteSetting->general_settings;
			}

			if (self::CREDIT_CARD === $this->request->data['SiteSetting']['key'] && $key === self::CREDIT_CARD) {
				//
			}

			if (self::POLICY === $this->request->data['SiteSetting']['key'] && $key === self::POLICY) {
				//
			}

			if (self::TERMS_AND_CONDITIONS === $this->request->data['SiteSetting']['key'] && $key === self::TERMS_AND_CONDITIONS) {
				//
			}

			if (!$this->SiteSetting->validates()) {
				// it validated logic
				$errors = $this->SiteSetting->validationErrors;
				if (count($errors)) {
					$strError = '';
					foreach ($errors as $error){
						if (is_array($error)){
							$strError .= "<div>".implode("<br />", $error)."</div>";
						}else{
							$strError .= "<div>".$error ."</div><br />";
						}
					}
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = $strError;
					$response['data'] =$this->SiteSetting->invalidFields();
				}
			    return json_encode($response);
			}

			if (self::GENERAL === $this->request->data['SiteSetting']['key'] && $key === self::GENERAL) {
				$oldSetting = $this->SiteSetting->find('first', ['conditions' => array('key' => self::GENERAL)]);
				if (isset($oldSetting['SiteSetting']['value']) && !empty($oldSetting['SiteSetting']['value'])) {
					$oldSettingData = json_decode($oldSetting['SiteSetting']['value'], true);
					if (isset($oldSettingData['SiteSetting']['logo']) && !empty($oldSettingData['SiteSetting']['logo'])) {
						if (!is_array($oldSettingData['SiteSetting']['logo'])) {
							$oldPicPath = (string)$oldSettingData['SiteSetting']['logo'];
						}
					}
				}

				// Handle logo
				if (isset($this->request->data['SiteSetting']['logo']['name']) && !empty($this->request->data['SiteSetting']['logo']['name'])) {
					$logoUpload = true; # <= important

					App::uses('UploadLib', 'Lib');

					$this->UploadLogo = new UploadLib($directory, false, 1048576);

					$uploadValidate = $this->UploadLogo->validateUpload($this->request->data['SiteSetting'], 'logo');
					if ($uploadValidate['is_valid'] !== true) {
						$response['error'] = 1;
						$response['type'] = 'error';
						$response['message'] = $uploadValidate['message'];
						return json_encode($response);
					}

					$isUploadedLogo = $this->UploadLogo->uploadFile($this->request->data['SiteSetting'], [], 'logo');
					if ($isUploadedLogo['is_valid'] !== true) {
						$response['error'] = 1;
						$response['type'] = 'error';
						$response['message'] = $isUploadedLogo['message'];
						return json_encode($response);
					}
					$this->request->data['SiteSetting']['logo'] = $isUploadedLogo['filename'];
				} else {
					$this->request->data['SiteSetting']['logo'] = $oldPicPath;
				}
			}

			// prepare the data for DB to be saved
			$siteSetting['SiteSetting']['key'] = $this->request->data['SiteSetting']['key'];
			$siteSetting['SiteSetting']['value'] = json_encode(array('SiteSetting' => $this->request->data['SiteSetting']));

			// try to save the posted data
			$this->SiteSetting->validate = $this->SiteSetting->validate;
			if ($this->SiteSetting->save($siteSetting)) {
				// IF we uploaded logo delete the okd one
				if ($logoUpload) {
					$deleteOldLogo = $directory.$oldPicPath;
					if (!empty($deleteOldLogo)) {
						if (file_exists($deleteOldLogo) && is_file($deleteOldLogo)) {
							@unlink($deleteOldLogo); 
						}
					}
				}

				$response['error'] = 0;
				$response['type'] = 'success';
				$response['message'] = __('Site Settings has been saved successfully.');
			} else {
				if ($logoUpload) {
					// if SiteSetting Could not be saved remove uploaded image.
					if (file_exists($isUploadedLogo['mainFile']) && is_file($iisUploadedLogosUploaded['mainFile'])) {
						@chmod($isUploadedLogo['mainFile'], 0777); // NT ?
						@unlink($isUploadedLogo['mainFile']);
					}
				}

				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Site settings could not be saved. Please Try again!');
			}

			return json_encode($response);
		}


/**
 | ============|
 |  Banner Add |
 | ============|
 */

/**
 * featured method
 *
 * @access public
 * @return void
 */
	public function featured() {
	    if (empty($this->request->params['requested'])) {
	        throw new ForbiddenException();
	    }
	    // Most visited properties
	    return ClassRegistry::init('Banner')->getBanners(4);
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_banner() {
		
		$this->loadModel('Banner');

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}
		$this->Paginator->settings =  array(
			'limit' => $page_count,
			'order' => array('Banner.sort' => 'asc'),
		);
		$banners = $this->paginate('Banner');

		$this->set(compact('banners'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_addBanner() {

		$this->loadModel('Banner');

		if ($this->request->is('post')) {
			$this->Banner->create();
			if (empty($this->request->data['Banner']['image_path']['name'])) {
				unset($this->request->data['Banner']['image_path']);
			}
			if ($this->Banner->save($this->request->data, array('validate'=>'first'))) {
				$this->Flash->success(__('Banner has been saved.'));
				return $this->redirect(array('admin'=>true, 'controller' => 'site_settings', 'action' => 'banner'));
			} else {
				$this->Flash->error(__('Banner could not be saved. Please, try again.'));
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
	public function admin_editBanner($id = null) {
		$this->loadModel('Banner');

		if (!$this->Banner->exists($id)) {
			throw new NotFoundException(__('Invalid banner'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if (empty($this->request->data['Banner']['image_path']['name'])) {
				unset($this->request->data['Banner']['image_path']);
			}
			if ($this->Banner->save($this->request->data)) {
				$this->Flash->success(__('Banner has been updated Succesfully.'));
				return $this->redirect(array('action' => 'banner'));
			} else {
				$this->Flash->error(__('Banner could not be updated. Please, try again.'));
				// return $this->redirect(Router::url($this->referer(), true ) );
			}
		} else {
			$this->request->data = $this->Banner->find('first', array(
				'conditions' => array('Banner.' . $this->Banner->primaryKey => $id)
			));
		}
	}

/**
 * Sort method
 *
 * @return void
 */
	public function admin_sortBanner() {
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
					$query = " UPDATE banners SET sort={$count} WHERE id={$idval}";
					$this->SiteSetting->query($query);
					$count ++;
				}
				$response['type'] = 'success';
				$response['message'] = __('Banner sort changed successfully.');
			}
		}
		return json_encode($response);
	}

/**
 * changeStatus method
 *
 * @return void
 */
	public function admin_changeBannerStatus() {
		$this->loadModel('Banner');

		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->is('ajax')){
			if ($this->Banner->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('You successfully changed this banner status.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Banner status could not be changed. Please Try again!');
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
	public function admin_deleteBanner($id = null) {
		$this->loadModel('Banner');

		$this->Banner->id = $id;
		if (!$this->Banner->exists()) {
			throw new NotFoundException(__('Invalid Banner'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Banner->delete()) {
			$this->Flash->success(__('Banner has been deleted.'));
		} else {
			$this->Flash->error(__('Banner could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'banner'));
	}

}
