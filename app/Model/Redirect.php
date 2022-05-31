<?php
App::uses('AppModel', 'Model');

class Redirect extends AppModel {

	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not modify directly this property',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'URL is required.'
			),
			'isUnique' => array(
				'rule'=> 'isUnique',
				'message' => 'This URL already exists.',
			)
		)
	);

/**
 * Returns to redirect if one exists
 * @param  string $url
 * @return mixed string / boolean	String if URL exists, false otherwise
 */
	public function getRedirect($url = null) {
		if (!$url) {
			return false;
		}

		$redirect = $this->find('first', array('conditions' => array('Redirect.url LIKE' => $url), 'fields' => 'redirect'));

		if (!$redirect) {
			return false;
		}

		if (!isset($redirect['Redirect']['redirect']) || empty($redirect['Redirect']['redirect'])) {
			return '/';
		}

		if (substr($redirect['Redirect']['redirect'], 0, 1) === '/') {
			return $redirect['Redirect']['redirect'];
		} elseif(substr($redirect['Redirect']['redirect'], 0, 7) === 'http://') {
			return $redirect['Redirect']['redirect'];
		} elseif(substr($redirect['Redirect']['redirect'], 0, 8) === 'https://') {
			return $redirect['Redirect']['redirect'];
		} elseif(substr($redirect['Redirect']['redirect'], 0, 4) === 'www.') {
			return 'http://' . $redirect['Redirect']['redirect'];
		} else {
			return '/' . $redirect['Redirect']['redirect'];
		}
	}

/**
 * Saves multiple URLs on create
 * @param  array  $data
 * @return bool
 */
	public function saveMultiple($data = array()) {
		if (!$data) {
			throw new NotFoundException(__('Invalid Data'));
		}

		$this->set($data);
		if (!$this->validates($data)) {
			return false;
		}

		$urls = explode("\n", $data['Redirect']['urls']);

		foreach ($urls as $url) {
			if (empty($url)) {
				continue;
			}
			$create = array();
			$create['Redirect']['url']      = trim($url);
			$create['Redirect']['redirect'] = $data['Redirect']['redirect'];

			$this->create();
			if (!$this->save($create)) {
				return false;
			}
		}
		return true;
	}
}