<?php
/**
 * All Froala plugin tests
 */
class AllFroalaTest extends CakeTestCase {

/**
 * Suite define the tests for this plugin
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Froala test');

		$path = CakePlugin::path('Froala') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}

}
