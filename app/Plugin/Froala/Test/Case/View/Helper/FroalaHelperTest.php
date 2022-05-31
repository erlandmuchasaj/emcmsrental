<?php
/**
 * CakePHP Froala WYSIWYG Plugin
 *
 * Copyright 2014, Froala (http://www.froala.com)
 *
 */

App::uses('Controller', 'Controller');
App::uses('HtmlHelper', 'View/Helper');
App::uses('FroalaHelper', 'Froala.View/Helper');

/**
 * TheFroalaTestController class
 *
 * @package       Froala.Test.Case.View.Helper
 */
class TheFroalaTestController extends Controller {

/**
 * name property
 *
 * @var string 'TheTest'
 */
	public $name = 'TheTest';

/**
 * uses property
 *
 * @var mixed null
 */
	public $uses = null;
}

/**
 * FroalaHelperTest class
 *
 * @package       Froala.Test.Case.View.Helper
 */
class FroalaTest extends CakeTestCase {

/**
 * Helper being tested
 *
 * @var object FroalaHelper
 * @access public
 */
	public $Froala = null;

/**
 * @var array
 * @access public
 */
	public $configs = array(
		'basic' => array(
			'toolbarInline' => false,
			'buttons' => '["bold", "italic", "underline"]'
		)
	);

/**
 * startTest
 *
 * @return void
 * @access public
 */
	public function setUp() {
		Configure::write('Asset.timestamp', false);

		$this->View = new View(null);
		$this->Froala = new FroalaHelper($this->View);
		$this->Froala->Html = $this->getMock('HtmlHelper', array('script'), array($this->View));
	}

/**
 * endTest
 *
 * @return void
 * @access public
 */
	public function tearDown() {
		unset($this->Froala, $this->View);
	}

/**
 * testEditor
 *
 * @return void
 * @access public
 */
	public function testEditor() {
		$this->Froala->Html->expects($this->any())
			->method('scriptBlock')
			->with(
				'<script type="text/javascript">
				//<![CDATA[
				Froala.init({
				toolbarInline : "false",
				buttons : ["bold", "italic", "underline"]
				});

				//]]>
				</script>',
				array('toolbarInline' => false));
		$this->Froala->configs = $this->configs;
		$this->Froala->editor(".selector", 'basic');

		$this->expectException('OutOfBoundsException');
		$this->Froala->editor(".selector", 'invalid-config');
	}

/**
 * testEditor with app wide options
 *
 * @return void
 * @access public
 */
	public function testEditorWithDefaults() {
		$this->assertTrue(Configure::write('Froala.editorOptions', array('height' => '100px')));

		$this->Froala->Html->expects($this->any())
			->method('scriptBlock')
			->with(
				'<script type="text/javascript">
				//<![CDATA[
				Froala.init({
				height : "100px"
				});

				//]]>
				</script>',
				array('toolbarInline' => false));
		$this->Froala->beforeRender('test.ctp');
		$this->Froala->editor('.selector', array());

		$this->Froala->Html->expects($this->any())
			->method('scriptBlock')
			->with(
				'<script type="text/javascript">
				//<![CDATA[
				Froala.init({
				height : "50px"
				});

				//]]>
				</script>',
				array('toolbarInline' => false));
		$this->Froala->editor('.selector', array('height' => '50px'));
	}

/**
 * testBeforeRender
 *
 * @return void
 * @access public
 */
	public function testBeforeRender() {
		$this->Froala->Html->expects($this->any())
			->method('script')
			->with(
        array(
          '/Froala/js/froala_editor.min.js',
          '/Froala/js/plugins/align.min.js',
          '/Froala/js/plugins/char_counter.min.js',
          '/Froala/js/plugins/code_beautifier.min.js',
          '/Froala/js/plugins/code_view.min.js',
          '/Froala/js/plugins/colors.min.js',
          '/Froala/js/plugins/draggable.min.js',
          '/Froala/js/plugins/emoticons.min.js',
          '/Froala/js/plugins/entities.min.js',
          '/Froala/js/plugins/file.min.js',
          '/Froala/js/plugins/font_family.min.js',
          '/Froala/js/plugins/font_size.min.js',
          '/Froala/js/plugins/fullscreen.min.js',
          '/Froala/js/plugins/image_manager.min.js',
          '/Froala/js/plugins/image.min.js',
          '/Froala/js/plugins/inline_style.min.js',
          '/Froala/js/plugins/line_breaker.min.js',
          '/Froala/js/plugins/link.min.js',
          '/Froala/js/plugins/lists.min.js',
          '/Froala/js/plugins/paragraph_format.min.js',
          '/Froala/js/plugins/paragraph_style.min.js',
          '/Froala/js/plugins/quick_insert.min.js',
          '/Froala/js/plugins/quote.min.js',
          '/Froala/js/plugins/save.min.js',
          '/Froala/js/plugins/table.min.js',
          '/Froala/js/plugins/url.min.js',
          '/Froala/js/plugins/video.min.js'),
				array('toolbarInline' => false));
		$this->Froala->beforeRender('test.ctp');

		$this->Froala->Html->expects($this->any())
            ->method('css')
            ->with(
                array(
                  '/Froala/css/froala_editor.min.css',
                  '/Froala/css/froala_style.min.css',
                  '/Froala/css/plugins/char_counter.min.css',
                  '/Froala/css/plugins/code_view.min.css',
                  '/Froala/css/plugins/colors.min.css',
                  '/Froala/css/plugins/draggable.min.css',
                  '/Froala/css/plugins/emoticons.min.css',
                  '/Froala/css/plugins/file.min.css',
                  '/Froala/css/plugins/fullscreen.min.css',
                  '/Froala/css/plugins/image_manager.min.css',
                  '/Froala/css/plugins/image.min.css',
                  '/Froala/css/plugins/line_breaker.min.css',
                  '/Froala/css/plugins/quick_insert.min.css',
                  '/Froala/css/plugins/table.min.css',
                  '/Froala/css/plugins/video.min.css'
                ));
        $this->Froala->beforeRender('test.ctp');
	}

}