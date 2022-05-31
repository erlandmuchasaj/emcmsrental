<?php
// Here we attach all the events
// gllobally
// 
App::uses('ClassRegistry', 'Utility');
App::uses('CakeEventManager', 'Event');
App::uses('PropertyListener', 'Lib/Event');
App::uses('FaqListener', 'Lib/Event');


// $Property = ClassRegistry::init('Property');
// $Property->getEventManager()->attach(new PropertyListener());

CakeEventManager::instance()->attach(new PropertyListener());
CakeEventManager::instance()->attach(new FaqListener());
