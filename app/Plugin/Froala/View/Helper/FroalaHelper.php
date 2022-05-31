<?php
/**
 * Copyright 2014, Froala (http://www.froala.com)
 *
 */

/**
 * Froala Helper
 *
 * @package Froala
 * @subpackage Froala.View.Helper
 */

class FroalaHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array('Html');

/**
 * Configuration
 *
 * @var array
 */
	public $configs = [];

/**
 * Default values
 *
 * @var array
 */
	protected $_defaults = [];

/**
 * Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = []) {
		parent::__construct($View, $settings);
		$configs = Configure::read('Froala.configs');
		if (!empty($configs) && is_array($configs)) {
			$this->configs = $configs;
		}
	}

/**
 * Adds a new editor to the script block in the head
 *
 * @see http://editor.froala.com/docs/options for a list of keys
 * @param mixed If array camel cased Froala Init config keys, if string it checks if a config with that name exists
 * @return void
 */
	public function editor($selector = null, $options = []) {
		if (is_string($options)) {
			if (isset($this->configs[$options])) {
				$options = $this->configs[$options];
			} else {
				throw new OutOfBoundsException(sprintf(__('Invalid Froala configuration preset %s'), $options));
			}
		}

		$options = array_merge($this->_defaults, $options);

		$scriptPosition = [];
		if (isset($options['block']) && !empty($options['block'])) {
			$scriptPosition = array('block' => $options['block']);
			unset($options['block']);
		}

		$lines = '';
		foreach ($options as $option => $value) {
			$lines .= Inflector::underscore($option) . ' : "' . $value . '",' . "\n";
		}
		// remove last comma from lines to avoid the editor breaking in Internet Explorer
		$lines = rtrim($lines);
		$lines = rtrim($lines, ',');

		$this->Html->scriptBlock('
		(function($){
			$(document).ready(function() {
				"use strict";
				$("'.$selector.'").froalaEditor({' . "\n" . $lines . "\n" . '});
				// remove the notice from the FroalaEditor
				$("div.fr-wrapper").first("div").find("a").remove();
			});
		})(jQuery);', $scriptPosition);
	}

/**
 * beforeRender callback
 *
 * @param string $viewFile The view file that is going to be rendered
 *
 * @return void
 */
	public function beforeRender($viewFile) {
		$appOptions = Configure::read('Froala');
		if ($appOptions !== false && is_array($appOptions)) {
			$this->_defaults = $appOptions;
		}
		$this->Html->script(
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
				'/Froala/js/plugins/help.min.js',
				'/Froala/js/plugins/image.min.js',
				'/Froala/js/plugins/image_manager.min.js',
				'/Froala/js/plugins/inline_style.min.js',
				'/Froala/js/plugins/line_breaker.min.js',
				'/Froala/js/plugins/link.min.js',
				'/Froala/js/plugins/lists.min.js',
				'/Froala/js/plugins/paragraph_format.min.js',
				'/Froala/js/plugins/paragraph_style.min.js',
				'/Froala/js/plugins/print.min.js',
				'/Froala/js/plugins/quick_insert.min.js',
				'/Froala/js/plugins/quote.min.js',
				'/Froala/js/plugins/special_characters.min.js',
				'/Froala/js/plugins/save.min.js',
				'/Froala/js/plugins/table.min.js',
				'/Froala/js/plugins/url.min.js',
				'/Froala/js/plugins/video.min.js',
				'/Froala/js/plugins/word_paste.min.js'
			),
			array('toolbarInline' => false, 'block'=>'scriptBottomMiddle', 'fullBase'=>true)
		);
		$this->Html->css(
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
				'/Froala/css/plugins/help.min.css',
				'/Froala/css/plugins/image_manager.min.css',
				'/Froala/css/plugins/image.min.css',
				'/Froala/css/plugins/line_breaker.min.css',
				'/Froala/css/plugins/quick_insert.min.css',
				'/Froala/css/plugins/special_characters.min.css',
				'/Froala/css/plugins/table.min.css',
				'/Froala/css/plugins/video.min.css'
			),
			null,
			array('block'=>'cssMiddle', 'fullBase'=>true)
		);
	}

}
