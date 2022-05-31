<?php
App::uses('DispatcherFilter', 'Routing');
App::uses('ClassRegistry', 'Utility');

class MaintenanceFilter extends DispatcherFilter {
	public function beforeDispatch(CakeEvent $event) {
		try {
			$setting = ClassRegistry::init('SiteSetting')->load('GENERAL');
			if (isset($setting['site_status']) && (int) $setting['site_status'] === 1) {
				Configure::write('Maintenance.enable', true);
			}
		} catch (Exception $e) {
			// nothing to do here
		}
		return $event;
	}
}