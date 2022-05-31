<?php
App::uses('AppModel', 'Model');
/**
 * Page Model
 *
 * @property User $User
 */
class Page extends AppModel {

/**
 * Model Name
 *
 * @var string
 */
	public $name = 'Page';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Virtual field
 *
 * @var string
 */
	public $virtualFields = array(
		'children' => "SELECT COUNT(id) FROM pages WHERE parent_id = Page.id",
		'revisions' => "SELECT COUNT(id) FROM revisions WHERE model_id = Page.id AND model = 'Page'"
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not modify directly this property',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Page title can not be empty.',
				'allowEmpty' => false
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'An article with the same title alredy exists.',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'article title can not have more then 160 characters.',
			),
		),
		'slug' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 160),
				'message' => 'Slug can not have more then 160 characters.',
				'allowEmpty' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Slug should be unique',
				'allowEmpty' => true
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Slug can not be empty.',
				'allowEmpty' => true
			),
			'regex' => array(
				'rule' => '/^[a-zA-Z0-9-]+$/',
				'message' => 'The page format must be only characters, numbers and dashes.',
				'allowEmpty' => true
			),
        ),
        'meta_title' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 60),
        		'message' => 'Meta title can not have more then 60 characters.',
        		'allowEmpty' => true
        	),
        ),
        'meta_description' => array(
        	'maxLength' => array(
        		'rule' => array('maxLength', 160),
        		'message' => 'Meta description can not have more then 160 characters.',
        		'allowEmpty' => true
        	),
        )
	);

/**
 * ActsAs
 *
 * @var array
 */
	public $actsAs = array('Tree', 'Revision' => array('fields' => 'content'));


//The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'model_id',
			'conditions' => array('model' => 'Page')
		)
	);

/**
 * Override parent before save for slug generation
 * Also handles ordering of the page
 *
 * @return boolean Always true
 */
	public function beforeSave($options = array()) {
		// Generating slug from page name
		if (!empty($this->data['Page']['name']) && empty($this->data['Page']['slug']) && isset($this->data['Page']['slug'])) {
			if (!empty($this->data['Page']['id'])) {
				$this->data['Page']['slug'] = $this->generateSlug($this->data['Page']['name'], $this->data['Page']['id']);
			} else {
				$this->data['Page']['slug'] = $this->generateSlug($this->data['Page']['name']);
			}
		}

		// seo meta data for the page
		if (isset($this->data[$this->alias]['content']) && empty($this->data[$this->alias]['meta_description'])) {
			$this->data[$this->alias]['meta_description'] = EMCMS_substr(stripAllHtmlTags($this->data[$this->alias]['content']), 0, 160);
		}


		// the page ordering
		if (empty($this->data['Page']['id'])) {

			if(!empty($this->data['Page']['top_show'])) {
				$this->data['Page']['top_order']  = $this->getLastOrderNumber('top');
			}

			if (!empty($this->data['Page']['bottom_show'])) {
				$this->data['Page']['bottom_order']  = $this->getLastOrderNumber('bottom');
			}
		}

		if (!empty($this->data['Page']['make_homepage'])) {
			$this->updateAll(array('Page.route' => null), array('Page.route' => '/'));
			$this->data['Page']['route'] = '/';
		}

		return parent::beforeSave($options);
	}

	public function afterFind($results, $primary = false) {
		if (!$results) {
			return array();
		}

		foreach ($results as $key => $result) {
			if (!empty($result[$this->alias]['route']) && $result[$this->alias]['route'] == '/') {
				$results[$key][$this->alias]['make_homepage'] = true;
			}
		}

		return $results;
	}

/**
 * Function to get last order number
 *
 * @param string $position The page position - usually top or bottom
 *
 * @return int Return last order number
 */
	public function getLastOrderNumber($position = null) {
		$this->recursive = -1;
		$lastItem = $this->find('first', array('conditions' => array($position.'_show' => 1), 'order' => array($position.'_order' => 'desc')));
		if (!empty($lastItem)) {
			return $lastItem['Page'][$position.'_order'] + 1;
		} else {
			return 0;
		}
	}

/**
 * Checks if a slug exists and returns it if it does
 * @param  string $slug
 * @param  bool   $returnErrors If set to true, an error will be thrown if no page exists, otherwise false is returned
 * @return array
 */
	public function get($slug = null, $returnErrors = true) {
		if (!$slug) {
			throw new NotFoundException(__('Invalid page'));
		}

		$this->contain();
		$page = $this->findBySlug($slug);

		if (!$page) {
			if (!$returnErrors) {
				return array();
			}

			throw new NotFoundException(__('Invalid page'));
		}

		return $page;
	}

	public function getPages($parent_id = null, $position = 'top') {
		return $this->find('all',
			array(
				'conditions' => array(
					'Page.'.$position.'_show' => true,
					'Page.parent_id' => $parent_id
				),
				'order' => 'Page.'.$position.'_order',
				'contain' => false
			)
		);
	}

/**
* This function builds the menu from our model to tie into the MenuBuilderHelper
*
* @param string $parent_id The parent_id which we are building from
* @param string $position Which menu we are building, usually the 'top'
* @return array The menu
*/
	public function menu($parentId = null, $position = 'top') {
		$menus = array();

		$fields = array('id', 'name', 'slug', 'parent_id', 'route', 'class', 'new_window');
		$pages = $this->find('all', array(
			'conditions' => array(
				'Page.' . $position . '_show' => true,
				'Page.parent_id' => $parentId
			),
			'order' => 'Page.' . $position . '_order',
			'contain' => false,
			'fields' => $fields
		));

		if (!$pages) {
			return array();
		}

		foreach ($pages as $key => $page) {
			$menu = array();
			$menu['title'] = $page['Page']['name'];
			$menu['class'] = $page['Page']['class'];
			if (!empty($page['Page']['route'])) {
				$menu['url'] = $page['Page']['route'];
			} else {
				$menu['url'] = '/' . $page['Page']['slug'];
			}

			$menu['new_window'] = $page['Page']['new_window'];

			// lets get the children
			$menu['children'] = $this->menu($page['Page']['id'], $position);

			$menus[] = $menu;
		}

		return $menus;
	}

/**
 * created a clean copy of a page
 * @param  int $id
 * @return array
 */
	public function getCopy($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid page'));
		}

		$this->contain();
		$page = $this->findById($id);

		if (!$page) {
			throw new NotFoundException(__('Invalid page'));
		}

		$fields = array('id', 'lft', 'rght', 'slug', 'created', 'modified');
		foreach ($fields as $field) {
			unset($page['Page'][$field]);
		}

		$page['Page']['name'] .= ' (Copy)';

		return $page;
	}
}