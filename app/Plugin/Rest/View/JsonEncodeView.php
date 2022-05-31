<?php
/**
 * View Class for JSON
 *
 * @author Juan Basso
 * @author Jonathan Dalrymple
 * @author kvz
 * @url http://blog.cakephp-brasil.org/2008/09/11/trabalhando-com-json-no-cakephp-12/
 * @licence MIT
 */
class JsonEncodeView extends View {
	public $jsonTab = "  ";

	public function render ($action = null, $layout = null, $file = null) {
		if (!array_key_exists('response', $this->viewVars)) {
			trigger_error(
				'viewVar "response" should have been set by Rest component already',
				E_USER_ERROR
			);
			return false;
		}
		// JSONP: Wrap in callback function if requested
		if (array_key_exists('callbackFunc', $this->viewVars)) {
			return $this->viewVars['callbackFunc'] . '(' . $this->encode($this->viewVars['response']) . ');';
		} else {
			return $this->encode($this->viewVars['response']);
		}
	}

	public function headers ($Controller, $settings) {
		if ($settings['debug'] > 2) {
			return null;
		}

		header('Content-Type: application/json');
		$Controller->RequestHandler->respondAs('json');
		return true;
	}

	public function encode ($response, $pretty = false) {
		if ($pretty) {
			$encoded = $this->_encode($response);
			$pretty = $this->json_format($encoded);
			return $pretty;
		}
		return $this->_encode($response);
	}


	/**
	 * (Recursively) utf8_encode each value in an array.
	 *
	 * http://www.php.net/manual/es/function.utf8-encode.php#75422
	 *
	 * @param array $array
	 * @return array utf8_encoded
	 */
	public function utf8_encode_array ($array) {
		if (!is_array($array)) {
			return false; // argument is not an array, return false
		}

		$result_array = array();

		foreach ($array as $key => $value) {
			if ($this->array_type($array) === 'map') {
				// encode both key and value

				if (is_array($value)) {
					// recursion
					$result_array[utf8_encode($key)] = $this->utf8_encode_array($value);
				} else {
					// no recursion
					if (is_string($value)) {
						$result_array[utf8_encode($key)] = utf8_encode($value);
					} else {
						// do not re-encode non-strings, just copy data
						$result_array[utf8_encode($key)] = $value;
					}
				}
			} else if ($this->array_type($array) === 'vector') {
				// encode value only

				if (is_array($value)) {
					// recursion
					$result_array[$key] = $this->utf8_encode_array($value);
				} else {
					// no recursion
					if (is_string($value)) {
						$result_array[$key] = utf8_encode($value);
					} else {
						// do not re-encode non-strings, just copy data
						$result_array[$key] = $value;
					}
				}
			}
		}

		return $result_array;
	}

	/**
	 * Determines array type ("vector" or "map"). Returns false if not an array at all.
	 * (I hope a native function will be introduced in some future release of PHP, because
	 * this check is inefficient and quite costly in worst case scenario.)
	 *
	 * http://www.php.net/manual/es/function.utf8-encode.php#75422
	 *
	 * @param array $array The array to analyze
	 * @return string array type ("vector" or "map") or false if not an array
	 */
	public function array_type ($array) {
		if (!is_array($array)) {
			return false;
		}

		$next = 0;
		$return_value = 'vector'; // we have a vector until proved otherwise

		foreach ($array as $key => $value) {
			if ($key != $next) {
				$return_value = 'map'; // we have a map
				break;
			}

			$next++;
		}

		return $return_value;
	}

	/**
	 * PHP version independent json_encode
	 *
	 * Adapted from http://www.php.net/manual/en/function.json-encode.php#82904.
	 * Author: Steve (30-Apr-2008 05:35)
	 *
	 *
	 * @staticvar array $jsonReplaces
	 * @param array $response
	 *
	 * @return string
	 */
	public function _encode ($response) {
		$utf8_encoded = $this->utf8_encode_array($response);

		if (function_exists('json_encode') && is_string($json_encoded = json_encode($utf8_encoded))) {
			// PHP 5.2+, no utf8 problems
			return $json_encoded;
		}

		if (is_null($utf8_encoded)) {
			return 'null';
		}
		if ($utf8_encoded === false) {
			return 'false';
		}
		if ($utf8_encoded === true) {
			return 'true';
		}
		if (is_scalar($utf8_encoded)) {
			if (is_float($utf8_encoded)) {
				return floatval(str_replace(",", ".", strval($utf8_encoded)));
			}

			if (is_string($utf8_encoded)) {
				static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], utf8_encode($utf8_encoded)) . '"';
			} else {
				return $utf8_encoded;
			}
		}
		$isList = true;
		for ($i = 0, reset($utf8_encoded); $i < count($utf8_encoded); $i++, next($utf8_encoded)) {
			if (key($utf8_encoded) !== $i) {
				$isList = false;
				break;
			}
		}
		$result = array();
		if ($isList) {
			foreach ($utf8_encoded as $v) {
				$result[] = $this->_encode($v);
			}
			return '[' . join(',', $result) . ']';
		} else {
			foreach ($utf8_encoded as $k => $v) {
				$result[] = $this->_encode($k) . ':' . $this->_encode($v);
			}
			return '{' . join(',', $result) . '}';
		}
	}

	/**
	 * Pretty print JSON
	 * http://www.php.net/manual/en/function.json-encode.php#80339
	 *
	 * @param string $json
	 *
	 * @return string
	 */
	public function json_format ($json) {
		$new_json     = '';
		$indent_level = 0;
		$in_string    = false;

		$len  = strlen($json);

		for ($c = 0; $c < $len; $c++) {
			$char = $json[$c];
			switch ($char) {
				case '{':
				case '[':
					if (!$in_string) {
						$new_json .= $char . "\n" . str_repeat($this->jsonTab, $indent_level + 1);
						$indent_level++;
					} else {
						$new_json .= $char;
					}
					break;
				case '}':
				case ']':
					if (!$in_string) {
						$indent_level--;
						$new_json .= "\n" . str_repeat($this->jsonTab, $indent_level) . $char;
					} else {
						$new_json .= $char;
					}
					break;
				case ',':
					if (!$in_string) {
						$new_json .= ",\n" . str_repeat($this->jsonTab, $indent_level);
					} else {
						$new_json .= $char;
					}
					break;
				case ':':
					if (!$in_string) {
						$new_json .= ": ";
					} else {
						$new_json .= $char;
					}
					break;
				case '"':
					if ($c > 0 && $json[$c - 1] != '\\') {
						$in_string = !$in_string;
					}
				default:
					$new_json .= $char;
					break;
			}
		}

		// Return true json at all cost
		if (false === json_decode($new_json)) {
			// If we messed up the semantics, return original
			return $json;
		}

		return $new_json;
	}
}
