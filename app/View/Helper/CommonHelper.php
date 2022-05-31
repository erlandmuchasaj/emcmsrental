<?php
App::uses('AppHelper', 'View/Helper');
App::uses('Hash', 'Utility');

/**
 * All site-wide necessary stuff for the view layer
 */
class CommonHelper extends AppHelper {

	public $helpers = ['Session', 'Html'];

	/**
	 * Convenience method for clean ROBOTS allowance
	 *
	 * @param string|array $type - private/public or array of (noindex,nofollow,noarchive,...)
	 * @return string HTML
	 */
	public function metaRobots($type = null) {
		if ($type === null && ($meta = Configure::read('Config.robots')) !== null) {
			$type = $meta;
		}
		$content = [];
		if ($type === 'public') {
			$content['robots'] = ['index', 'follow', 'noarchive'];
		} elseif (is_array($type)) {
			$content['robots'] = $type;
		} else {
			$content['robots'] = ['noindex', 'nofollow', 'noarchive'];
		}

		$return = '<meta name="robots" content="' . implode(',', $content['robots']) . '"/>';
		return $return;
	}

	/**
	 * Convenience method for clean meta name tags
	 *
	 * @param string $name: author, date, generator, revisit-after, language
	 * @param mixed $content: if array, it will be seperated by commas
	 * @return string HTML Markup
	 */
	public function metaName($name, $content = null) {
		if (empty($name) || empty($content)) {
			return '';
		}

		$content = (array)$content;
		$return = '<meta name="' . $name . '" content="' . implode(', ', $content) . '"/>';
		return $return;
	}

	/**
	 * Convenience method for meta description
	 *
	 * @param string $content
	 * @param string $language (iso2: de, en-us, ...)
	 * @param array $additionalOptions
	 * @return string HTML Markup
	 */
	public function metaDescription($content, $language = null, $options = []) {
		if (!empty($language)) {
			$options['lang'] = mb_strtolower($language);
		} elseif ($language !== false) {
			$options['lang'] = Configure::read('Config.locale');
		}
		return $this->Html->meta('description', $content, $options);
	}

	/**
	 * Convenience method to output meta keywords
	 *
	 * @param string|array $keywords
	 * @param string $language (iso2: de, en-us, ...)
	 * @param bool $escape
	 * @return string HTML Markup
	 */
	public function metaKeywords($keywords = null, $language = null, $escape = true) {
		if ($keywords === null) {
			$keywords = Configure::read('Config.keywords');
		}
		if (is_array($keywords)) {
			$keywords = implode(', ', $keywords);
		}
		if ($escape) {
			$keywords = h($keywords);
		}
		if (!empty($language)) {
			$options['lang'] = mb_strtolower($language);
		} elseif ($language !== false) {
			$options['lang'] = Configure::read('Config.locale');
		}
		return $this->Html->meta('keywords', $keywords, $options);
	}

	/**
	 * Convenience function for "canonical" SEO links
	 *
	 * @param mixed $url
	 * @param bool $full
	 * @return string HTML Markup
	 */
	public function metaCanonical($url = null, $full = false) {
		$canonical = $this->Html->url($url, $full);
		$options = ['rel' => 'canonical', 'type' => null, 'title' => null];
		return $this->Html->meta('canonical', $canonical, $options);
	}

	/**
	 * Convenience method for "alternate" SEO links
	 *
	 * @param mixed $url
	 * @param mixed $lang (lang(iso2) or array of langs)
	 * lang: language (in ISO 6391-1 format) + optionally the region (in ISO 3166-1 Alpha 2 format)
	 * - de
	 * - de-ch
	 * etc
	 * @return string HTML Markup
	 */
	public function metaAlternate($url, $lang, $full = false) {
		//$canonical = $this->Html->url($url, $full);
		$url = $this->Html->url($url, $full);
		//return $this->Html->meta('canonical', $canonical, array('rel'=>'canonical', 'type'=>null, 'title'=>null));
		$lang = (array)$lang;
		$res = [];
		foreach ($lang as $language => $countries) {
			if (is_numeric($language)) {
				$language = '';
			} else {
				$language .= '-';
			}
			$countries = (array)$countries;
			foreach ($countries as $country) {
				$l = $language . $country;
				$options = ['rel' => 'alternate', 'hreflang' => $l, 'type' => null, 'title' => null];
				$res[] = $this->Html->meta('alternate', $url, $options) . PHP_EOL;
			}
		}
		return implode('', $res);
	}

	/**
	 * Convenience method for META Tags
	 *
	 * @param mixed $url
	 * @param string $title
	 * @return string HTML Markup
	 */
	public function metaRss($url, $title = null) {
		$tags = [
			'meta' => '<link rel="alternate" type="application/rss+xml" title="%s" href="%s"/>',
		];
		if (empty($title)) {
			$title = __('Subscribe to this feed');
		} else {
			$title = h($title);
		}

		return sprintf($tags['meta'], $title, $this->url($url));
	}

	/**
	 * Convenience method for META Tags
	 *
	 * @param string $type
	 * @param string $content
	 * @return string HTML Markup
	 */
	public function metaEquiv($type, $value, $escape = true) {
		$tags = [
			'meta' => '<meta http-equiv="%s"%s/>',
		];
		if ($value === null) {
			return '';
		}
		if ($escape) {
			$value = h($value);
		}
		return sprintf($tags['meta'], $type, ' content="' . $value . '"');
	}


	/**
	 * Still necessary?
	 *
	 * @param array $fields
	 * @return string HTML
	 */
	public function displayErrors($fields = []) {
		$res = '';
		if (!empty($this->validationErrors)) {
			if ($fields === null) { # catch ALL
				foreach ($this->validationErrors as $alias => $error) {
					list($alias, $fieldname) = explode('.', $error);
					$this->validationErrors[$alias][$fieldname];
				}
			} elseif (!empty($fields)) {
				foreach ($fields as $field) {
					list($alias, $fieldname) = explode('.', $field);

					if (!empty($this->validationErrors[$alias][$fieldname])) {
						$res .= $this->_renderError($this->validationErrors[$alias][$fieldname]);
					}
				}
			}
		}
		return $res;
	}

	protected function _renderError($error, $escape = true) {
		if ($escape !== false) {
			$error = h($error);
		}
		return '<div class="error-message">' . $error . '</div>';
	}

	/**
	 * Prevents site being opened/included by others/websites inside frames
	 *
	 * @return string
	 */
	public function framebuster() {
		return $this->Html->scriptBlock('if (top!=self) top.location.ref=self.location.href;');
	}

}
