<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {


	public $helpers = array('Html');

	/**
	 * url redirect after changing languages
	 * @param  [string | array]  $url
	 * @param  boolean $full
	 * @return
	 */
	public function url($url = null, $full = false) {
		if (is_array($url)) {
			if ((!isset($url['language']) || empty($url['language'])) && isset($this->params['language'])) {
				$languages = $this->getLanguageList('all');
				$availableLanguages = Hash::extract($languages, '{n}.Language.language_code');

				if (in_array($this->params['language'], $availableLanguages, true)) {
					$url['language'] = $this->params['language'];
				} else {
					$url['language'] = $this->getDefaultLanguageCode();
				}
			}
		}
		return parent::url($url, $full);
	}

	/**
	 * Display user avatar.
	 * By default show avatar of the logedin user, if parameter is passed
	 * show that instead
	 *
	 * @param  string $image_path image filename.
	 * @return void  show user avatar
	 */
	public function displayUserAvatar($image_path = null, $options = array()) {
		$directorySm = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;

		if (empty($options['alt'])) {
			$options['alt'] = __('User avatar');
		}

		if (empty($options['fullBase'])) {
			$options['fullBase'] = true;
		}

		if (!empty($options['size'])) {
			$size = trim($options['size']);
			$size = (in_array($size, ['xsmall', 'small', 'medium', 'large', 'xlarge'], true)) ? $size : 'small';
			unset($options['size']);
		} else {
			$size = 'small';
		}


		if ($image_path) {
			if (file_exists($directorySm.$image_path) && is_file($directorySm.$image_path)) {
				return $this->output($this->Html->image("uploads/User/{$size}/".$image_path, $options));
			} else {
				return $this->output($this->Html->image('avatars/avatar.jpg', $options));
			}
		} elseif (AuthComponent::user('id')) {
			if (file_exists($directorySm.AuthComponent::user('image_path')) && is_file($directorySm.AuthComponent::user('image_path'))) {
				return $this->output($this->Html->image("uploads/User/{$size}/".AuthComponent::user('image_path'), $options));
			} else {
				return $this->output($this->Html->image('avatars/avatar.jpg', $options));
			}
		} else {
			return $this->output($this->Html->image('avatars/avatar.jpg', $options));
		}
		return $this->output();
	}


	public function displayLogo($image_path = 'general/logo.png') {
		$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'SiteSetting'. DS.'logo'.DS;

		if ($image_path) {
			if (file_exists($directory.$image_path) && is_file($directory.$image_path)) {
				return $this->output("uploads/SiteSetting/logo/{$image_path}");
			} else {
				return $this->output('general/logo.png');
			}
		} else {
			return $this->output('general/logo.png');
		}
		return $this->output();
	}

	/**
	 * Replaces the special chars back to the 'real' chars.
	 * For example &amp; => &
	 *
	 * get_currency_symbol
	 * get_user_timezone
	 * get_user_default_language
	 *
	 *
	 * @param string $input the input-string
	 * @return string the manipulated string
	 */
	public function getActiveLanguageCode() {
		App::uses('Language', 'Model');
		$this->Language = new Language();
		return $this->Language->getActiveLanguageCode();
	}

	public function getActiveLanguageDirection() {
		App::uses('Language', 'Model');
		$this->Language = new Language();
		return $this->Language->getActiveLanguageDirection();
	}

	public function getDefaultLanguageCode() {
		App::uses('Language', 'Model');
		$this->Language = new Language();
		return $this->Language->getDefaultLanguageCode();
	}

	public function getLanguageList($type = 'list') {
		App::uses('Language', 'Model');
		$this->Language = new Language();
		return $this->Language->getLanguageList($type);
	}

	/**
	 * getLocalCurrency
	 * @return [type] [description]
	 */
	public function getDefaultCurrencyCode() {
		App::uses('Currency', 'Model');
		$this->Currency = new Currency();
		return $this->Currency->getDefaultCurrencyCode();
	}

	public function getDefaultCurrencySymbol() {
		App::uses('Currency', 'Model');
		$this->Currency = new Currency();
		return $this->Currency->getDefaultCurrencySymbol();
	}

	public function getLocalCurrency() {
		App::uses('Currency', 'Model');
		$this->Currency = new Currency();
		return $this->Currency->getLocalCurrency();
	}

	public function getCurrencyList($type = 'list') {
		App::uses('Currency', 'Model');
		$this->Currency = new Currency();
		return $this->Currency->getCurrencyList($type);
	}

	public function getData($type = 'capacity') {
		if ('capacity' === $type) {
			return [
				1=>__('%d Guest', 1),
				2=>__('%d Guests', 2),
				3=>__('%d Guests', 3),
				4=>__('%d Guests', 4),
				5=>__('%d Guests', 5),
				6=>__('%d Guests', 6),
				7=>__('%d Guests', 7),
				8=>__('%d Guests', 8),
				9=>__('%d Guests', 9),
				10=>__('%d Guests', 10),
				11=>__('%d Guests', 11),
				12=>__('%d Guests', 12),
				13=>__('%d Guests', 13),
				14=>__('%d Guests', 14),
				15=>__('%d Guests', 15),
				16=>__('%d+ Guests', 16),
			];
		} elseif ('bedrooms' === $type) {
			return [
				0=>__('Studio'),
				1=>__('%d Room', 1),
				2=>__('%d Rooms', 2),
				3=>__('%d Rooms', 3),
				4=>__('%d Rooms', 4),
				5=>__('%d Rooms', 5),
				6=>__('%d Rooms', 6),
				7=>__('%d Rooms', 7),
				8=>__('%d+ Rooms', 8),
			];
		} elseif ('beds' === $type) {
			return [
				1=>__('%d Bed',1),
				2=>__('%d Beds',2),
				3=>__('%d Beds',3),
				4=>__('%d Beds',4),
				5=>__('%d Beds',5),
				6=>__('%d Beds',6),
				7=>__('%d Beds',7),
				8=>__('%d Beds',8),
				9=>__('%d Beds',9),
				10=>__('%d Beds',10),
				11=>__('%d Beds',11),
				12=>__('%d+ Beds',12)
			];
		} elseif ('bathrooms' === $type) {
			return [
				'0.5'=>__('%s Bathroom','0.5'),
				1=>__('%d Bathroom',1),
				'1.5'=>__('%s Bathroom(s)','1.5'),
				2=>__('%d Bathroom(s)',2),
				'2.5'=>__('%s Bathroom(s)','2.5'),
				3=>__('%d Bathroom(s)',3),
				'3.5'=>__('%s Bathroom(s)','3.5'),
				4=>__('%d Bathroom(s)',4),
				'4.5'=>__('%s Bathroom(s)','4.5'),
				5=>__('%d Bathroom(s)',5),
				'5.5'=>__('%s Bathroom(s)','5.5'),
				6=>__('%d Bathroom(s)',6),
				'6.5'=>__('%s Bathroom(s)','6.5'),
				7=>__('%d Bathroom(s)',7),
				'7.5'=>__('%s Bathroom(s)','7.5'),
				8=>__('%d+ Bathroom(s)',8)
			];
		} elseif ('garages' === $type) {
			return [
				1=>__('%d Garage',1),
				2=>__('%d Garages',2),
				3=>__('%d Garages',3),
				4=>__('%d Garages',4),
				5=>__('%d Garages+',5)
			];
		} elseif ('property_type' === $type) {
			return [
				'rent' => __('Rent'),
				'sale' => __('Sale'),
			];
		} else {
			return null;
		}
	}

	public function getReservationLabel($status = 'payment_pending') {
		$statuses = [
			'payment_pending' => 'label label-default',
			'pending_approval' => 'label label-default',
			'declined' => 'label label-danger',
			'accepted' => 'label label-primary',
			'expired' => 'label label-danger',
			'payment_completed' => 'label label-info',
			'payment_error' => 'label label-danger',
			'canceled_by_host' => 'label label-danger',
			'canceled_by_traveler' => 'label label-danger',
			'awaiting_checkin' => 'label label-warning',
			'checkin' => 'label label-info',
			'awaiting_traveler_review' => 'label label-warning',
			'awaiting_host_review' => 'label label-warning',
			'completed' => 'label label-success',
			'after_checkin_canceled_by_host' => 'label label-danger',
			'after_checkin_canceled_by_guest' => 'label label-danger',
			'pending_reservation_canceled' => 'label label-danger',
		];

		if (isset($statuses[$status])) {
			return $statuses[$status];
		} else {
			return 'label label-default';
		}
	}
}
