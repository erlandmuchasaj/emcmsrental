<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

	public $name = 'Pages';

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Paginator'
	);

/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('display', 'home', 'index', 'maintenance');
	}

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display_pages() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}

		if (in_array('..', $path, true) || in_array('.', $path, true)) {
		    throw new ForbiddenException();
		}

		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}



	public function display($slug = null) {

		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}

		if (in_array('..', $path, true) || in_array('.', $path, true)) {
		    throw new ForbiddenException();
		}

		$slug = $page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$slug = $path[0];
		}

		if (!empty($path[1])) {
			$subpage = $path[1];
		}

		$page = $this->Page->get($slug);

		// lets check for a 301 redirect
		if (!empty($page['Page']['route']) && $page['Page']['route'] !== '/' . trim($this->params->url, '/\\')) {
			return $this->redirect('/' . trim($page['Page']['route'], '/\\'), 301);
		}

		if (!empty($page['Page']['view']) && $page['Page']['view'] === 'contact' && $this->request->is('post')) {
			try {
				$this->loadModel('Contact');
				$this->Contact->saveContact($this->request->data, $page['Page']['view']);
				$this->Flash->success(__('Thank you for contacting us, we will be in touch with you shortly regarding your query.'));
				if (!empty($page['Page']['post_route'])) {
					return $this->redirect($page['Page']['post_route']);
				}
				return $this->redirect($this->referer(['action'=>'display', $slug]));
			} catch (Exception $e) {
				$this->Flash->error($e->getMessage());
			}
		}

		$this->set('page', $page);
		$this->set('subpage', $subpage);
		
		$this->set('title_for_layout',  Inflector::humanize($page['Page']['meta_title']));

		if (!empty($page['Page']['meta_description'])) {
			$this->set('meta_description', $page['Page']['meta_description']);
		}

		if (!empty($page['Page']['meta_keywords'])) {
			$this->set('meta_keywords', $page['Page']['meta_keywords']);
		}

		if (!empty($page['Page']['view'])) {
			try {
				$this->render(trim($page['Page']['view'], '/\\'));
			} catch (MissingViewException $e) {
				if (Configure::read('debug')) {
					throw $e;
				}
				throw new NotFoundException();
			}
		}
	}

	public function index() {
	}

/**
 ** Maintenance template
 */
	public function maintenance() {
		$this->set('title_for_layout', __('Maintenance'));
		$this->layout = 'commingsoon';
		// return $this->render('/Pages/maintenance');
	}

/**
 * admin preview all page structure map
 *
 * @param  int $parentId find all children of this parent if null get all.
 * @param  string $search   search query
 * @return void
 */
	public function admin_index($parentId = null, $search = null) {
		if(!empty($this->request->data['Page']['search'])) {
			$this->redirect(array(0, $this->request->data['Page']['search']));
		}

		$conditions = array();

		if (!empty($search)) {
			$conditions['or'] = array(
				'Page.name LIKE' => '%'.$search.'%',
				'Page.meta_title LIKE' => '%'.$search.'%',
				'Page.slug LIKE' => '%'.$search.'%',
				'Page.content LIKE' => '%'.$search.'%'
			);
		} else {
			$conditions['parent_id'] = $parentId;
		}

		if ($parentId) {
			$this->Page->contain();
			$parent = $this->Page->findById($parentId, 'name');
			if(empty($parent)) {
				throw new NotFoundException(__('Invalid page'));
			}

			$parents = $this->Page->getPath($parentId, array('id', 'name'));
			$this->set(compact('parent', 'parents'));
		}

		//if (Configure::read('Content.topMenu')) {
			$this->set('topPages', $this->Page->find('all', array('conditions' => array('top_show' => true, 'element' => false, $conditions), 'order' => array('top_order' => 'asc'), 'contain' => false)));
		//}
		//if (Configure::read('Content.bottomMenu')) {
			$this->set('bottomPages', $this->Page->find('all', array('conditions' => array('bottom_show' => true, 'element' => false, $conditions), 'order' => array('bottom_order' => 'asc'), 'contain' => false)));
		//}
		$this->set('staticPages', $this->Page->find('all', array('conditions' => array('top_show' => false, 'bottom_show' => false, 'element' => false, $conditions), 'order' => array('Page.name' => 'asc'), 'contain' => false)));

		$this->set('parent_id', $parentId);
		$this->set('search', $search);
	}

/**
 * add page
 *
 * @param  int $parentId    id of the parent page
 * @param  int $duplicateId id of the page to dublicate
 * @return vido
 */
	public function admin_add($parentId = null, $duplicateId = null) {
		$this->helpers[] = 'Froala.Froala';
		if ($this->request->is('post')) {
			$this->Page->create();
			$this->request->data['Page']['user_id'] = $this->Auth->user('id');
			if ($this->Page->save($this->request->data)) {
				$this->Flash->success(__('The page has been added successfully.'));
				$this->redirect(array('action'=>'index', $this->request->data['Page']['parent_id']));
			} else {
				$this->Flash->error(__('There was a problem adding the page, please review the errors below and try again.'));
			}
		} elseif ($duplicateId) {
			$this->request->data = $this->Page->getCopy($duplicateId);
		} else {
			$this->request->data['Page']['parent_id'] = $parentId;
		}

		$this->set('pages', $this->Page->generateTreeList(array('Page.element' => false), null, '{n}.Page.name', '-> '));
	}

/**
 * edit page
 * @param  int $id       primary key of the page being edited
 * @param  int $revision revision key
 * @return void          page
 */
	public function admin_edit($id = null, $revision = null) {
		if (!$id) {
			throw new BadRequestException(__('missing page argument: ID.'));
		}
		$this->helpers[] = 'Froala.Froala';
		// not sure why, but the Revision Model needs to be loaded manually, and loaded here to work!
		$this->loadModel('Revision');
		$this->Page->contain();
		$page = $this->Page->findById($id);
		if (!$page) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Page->save($this->request->data)) {
				$this->Flash->success(__('The page has been updated successfully.'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Flash->error(__('There was a problem saving the page, please review the errors below and try again.'));
			}
		} else {
			$this->request->data = $page;
			if ($revision) {
				$this->request->data['Page'] = $this->Page->Revision->get($revision, $this->request->data['Page']);
			}
		}
		$this->set('page', $page);
		$this->set('pages', $this->Page->generateTreeList(array('Page.element' => false), null, '{n}.Page.name', '-> '));
	}

	public function admin_save($position = 'top') {
		$this->layout = false;
		$message = '';
		if (!empty($_POST)) {
			$data = $_POST;
			foreach ($data['page'] as $order => $id) {
				// lets get the old modified date to ensure that it isn't updated
				$page = $this->Page->findById($id, array('id', 'modified'));
				if (!empty($page)) {
					$page['Page'][$position . '_show']  = 1;
					$page['Page'][$position . '_order'] = $order;
					$this->Page->save($page);
				}
			}
			$message = __('The ordering has been saved successfully.');
		}
		$this->set('message', $message);
	}

	public function admin_reorder() {
		$this->Page->reorder();
		$this->Flash->success(__('The pages were reordered successfully.'));
		$this->redirect($this->referer(array('action'=>'index')));
	}

	public function admin_recover() {
		$this->Page->recover('parent');
		$this->Flash->success(__('The pages were recovered successfully.'));
		$this->redirect(array('action'=>'index'));
	}

	public function admin_delete($id = null) {
		if (!$id) {
			throw new BadRequestException(__('Page id is not set. Please refresh the page and try again!'));
		}

		$page = $this->Page->findById($id, 'id');
		if (!$page) {
			throw new NotFoundException(__('Invalid page'));
		}

		$this->request->allowMethod('post', 'delete');
		if ($this->Page->delete($id)) {
			$this->Flash->success(__('The page was successfully deleted.'));
		} else {
			$this->Flash->error(__('There was a problem deleting this page.'));
		}
		$this->redirect(array('action' => 'index'));
	}

}
