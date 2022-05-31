<?php // In app/Lib/Event/FaqListener.php

App::uses('CakeEventListener', 'Event');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeLog', 'Log');
class FaqListener implements CakeEventListener {

    public function implementedEvents() {
    	return [
            'Model.Faq.created' => 'sendNotificationEmail'
        ];
    }

    public function sendNotificationEmail(CakeEvent $Event) {
    	// If you want to use a Model inside a listener you will need to use 
    	// ClassRegistry::init().
		// CakeLog::write('error', 'Stuff is broken here');
		// // Anywhere in your application
		// CakeLog::debug('Got here');
		return true;
    }

}
