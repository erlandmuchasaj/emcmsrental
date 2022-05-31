<?php
/**
 * Rest Component Test
 *
 * Copyright 2009, Kevin van Zonneveld.
 *
 * Licensed under BSD style License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009, Kevin van Zonneveld.
 * @link http://github.com/kvz/cakephp-rest-plugin
 * @version 0.1
 * @author Kevin van Zonneveld <kvz@php.net>
 */
App::import('Controller', 'Component');
App::import('Component', array('Rest.Rest', 'Auth'));
App::import('Controller', 'AppController');

/**
 * Fake methods to reflecit things in testcase
 * and/org access to protected methods (better not)
 *
 */
class MockRestComponent extends RestComponent {
	/**
	 * Let's not really set headers in testmode
	 *
	 * @param <type> $ext
	 */
	public function headers($ext = false) {
		return null;
	}
}

class TestRestController extends AppController {
	public $components = array('RequestHandler', 'MockRest');
	public $uses = array();
}

/**
 * Rest Component Test Case
 *
 * @author Kevin van Zonneveld
 */
class RestComponentTest extends CakeTestCase {

	public $settings = array(
		'debug' => 2,
		'extensions' => array('xml', 'json'),
		'view' => array(
			'extract' => array('server.DnsDomain' => 'dns_domains.0'),
		),
		'index' => array(
			'extract' => array('rows.{n}.DnsDomain' => 'dns_domains'),
		),
	);

	public function setUp() {
		parent::setUp();
		$request = new CakeRequest(null, false);
		$request->params['ext'] = 'json';

		$this->Controller = new TestRestController($request, $this->getMock('CakeResponse'));

		$collection = new ComponentCollection();
		$collection->init($this->Controller);
		$this->Rest = new MockRestComponent($collection, $this->settings);
		$this->Rest->request = $request;
		$this->Rest->response = $this->getMock('CakeResponse');

		$this->Controller->Components->init($this->Controller);
	}

	public function testInitialize() {
		$this->Rest->initialize($this->Controller);
		$this->assertEqual($this->Rest->settings['debug'], $this->settings['debug']);
	}

	public function testIsActive() {
		$this->Rest->initialize($this->Controller);
		$this->assertTrue($this->Rest->isActive());

		$this->Rest->isActive = false;
		$this->assertFalse($this->Rest->isActive());

		$this->Rest->isActive = null;
		$this->assertTrue($this->Rest->isActive());
	}

	public function testControllers() {
		//prd($this->Rest->controllers());
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->Rest, $this->Controller);

	}
}
