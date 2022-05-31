<?php
/**
 * View Class for XML
 *
 * @author Jonathan Dalrymple
 * @author kvz
 */
class XmlEncodeView extends View {
	public $BluntXml;
	public function render ($action = null, $layout = null, $file = null) {
		if (!array_key_exists('response', $this->viewVars)) {
			trigger_error(
				'viewVar "response" should have been set by Rest component already',
				E_USER_ERROR
			);
			return false;
		}

		return $this->encode($this->viewVars['response']);
	}

	public function headers ($Controller, $settings) {
		if ($settings['debug'] > 2) {
			return null;
		}

		header('Content-Type: text/xml');
		$Controller->RequestHandler->respondAs('xml');
		return true;
	}

	public function encode ($response) {
		require_once dirname(dirname(__FILE__)) . '/Lib/BluntXml.php';
		$this->BluntXml = new BluntXml();
		return $this->BluntXml->encode(
			$response,
			Inflector::tableize($this->request->params['controller']) . '_response'
		);
	}
}
