<?php
/**
 * View Class for CSV
 *
 * @author Primeminister
 */
class CsvEncodeView extends View {
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

		header('Content-Type: text/csv');
		$Controller->RequestHandler->respondAs('csv');
		return true;
	}

	/**
	 * create csv string from response
	 *
	 * @param array $response with 'meta' and 'data' part
	 *
	 * @return string
	 **/
	public function encode ($response) {
		// if status ok then remove meta part. If not ok then only show status and feedback message
		if ($response['meta']['status'] === 'ok') {
			unset($response['meta']);
		} else {
			return 'status: '.$response['meta']['status'] . "\n" .
				'message:'. $response['meta']['feedback']['message'] . "\n";
		}

		// set everything from data part to one single one dimensional array
		$data = $response['data'][$this->request->params['controller']];
		unset($response);
		// put headers from array keys as first row
		$fields = array_keys($data[0]);
		array_unshift($data, $fields);
		// now make the csv file
		$csv = '';
		foreach ($data AS $rec) {
			$csv .= $this->_putcsv($rec);
		}
		return $csv;
	}

	/**
	 * Creating a file resource to php://temp so we don;t save a real file and
	 * return the string of that csv line
	 *
	 * @param array  $row
	 * @param string $delimiter
	 * @param string $enclosure
	 * @param string $eol
	 *
	 * @return string
	 */
	protected function _putcsv ($row, $delimiter = ';', $enclosure = '"', $eol = "\n") {
		static $fp = false;
		if ($fp === false) {
			$fp = fopen('php://temp', 'r+');
		} else {
			rewind($fp);
		}

		if (fputcsv($fp, $row, $delimiter, $enclosure) === false) {
			return false;
		}
		rewind($fp);
		$csv = fgets($fp);
		if ($eol != PHP_EOL) {
			$csv = substr($csv, 0, (0 - strlen(PHP_EOL))) . $eol;
		}
		return $csv;
	}
}
