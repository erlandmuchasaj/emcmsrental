<?php
App::uses('AppController', 'Controller');
/**
 * Articles Controller
 *
 * @property Article $Article
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ArticlesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = [];

/**
 * beforeFIlter method
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view');
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function index() {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}
		
		$this->set('title_for_layout', __('Blog'));
		
		$this->Paginator->settings =  array(
			'limit' => 12,
			'conditions' => array('Article.status' => 1),
			'order' => array('Article.sort' => 'asc'),
			'recursive' => 0
		);
		$articles = $this->paginate('Article');

		$featuredArticles = $this->Article->find('all', array(
			'conditions' => array('Article.is_featured' => 1),
			'order' => array('Article.sort' => 'asc'),
			'recursive' => 0,
			'limit' => 5,
		));

		$categories = $this->Article->Category->find('all', [
			'conditions' => array(
				'Category.status' => 1,
				'Category.model' => 'Article',
			),
			'order' => array('Category.sort' => 'asc'),
			'recursive' => -1
		]);
		$this->set(compact('articles','categories','featuredArticles'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		$article = $this->Article->find('first', array(
			'conditions' => array('Article.' . $this->Article->primaryKey => $id),
			'contain' => [
				'User',
				'Category'
			]
		));
		$articleNeighbors = $this->Article->find('neighbors', array(
			'order' =>  array('Article.sort' => 'asc'),
			'field' => 'id', 
			'value' => $id
		));

		//$conditions = array();
		$conditionOR = '';
		if (isset($article['Article']['article_tags']) && !empty($article['Article']['article_tags'])) {
			$keywords = explode(',' , $article['Article']['article_tags']);
			foreach ($keywords as $key => $tag){
				if ($key==0) {
					$conditionOR .= "(Article.article_tags LIKE '%{$tag}%')";
				} else {
					$conditionOR .=" OR (Article.article_tags LIKE '%{$tag}%')";
				}
			}
		}
		//$conditions = array($conditionOR);

		$relatedArticles = $this->Article->find('all', array(
				'conditions' => $conditionOR,
				'order' => array('Article.sort' => 'asc'),
				'recursive' => 0,
				'limit' => 3,
			)
		);
		$categories = $this->Article->Category->find('all', [
			'conditions' => array('Category.model' => 'Article', 'Category.status' => 1),
			'order' => array('Category.sort' => 'asc'),
			'recursive' => -1
		]);
		$this->set(compact('article','categories','articleNeighbors','relatedArticles'));

	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($search = null) {
		if ($this->request->is('ajax')){
			$this->layout = null;
		}

		$page_count = Configure::check('Website.per_page_count') ? Configure::read('Website.per_page_count') : 20;
		if($this->Session->check('per_page_count')) {
			$page_count = $this->Session->read('per_page_count');
		}

		$conditions = array();
		if ($this->request->is('post')) {
			$this->redirect(array('action' => 'index', $this->request->data['Article']['search']));
		} elseif (isset($search) && !empty($search)) {
			$conditions['or'] = array(
				'Article.title LIKE' => '%' . $search . '%', 
				'Article.summary LIKE' => '%' . $search . '%', 
				'Article.content LIKE' => '%' . $search . '%'
			);
		}

		$this->Paginator->settings =  array(
			'conditions' => $conditions,
			'limit' => $page_count,
			'order' => array('Article.sort' => 'asc', 'Article.date' => 'desc', 'Article.id' => 'desc'),
			'recursive' => 0,
			'contain' => array('Category')
		);
		$articles = $this->paginate('Article');

		$this->set(compact('articles', 'search'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id), 'recursive'=>0);
		$this->set('article', $this->Article->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->helpers[] = 'Froala.Froala';
		if ($this->request->is('post')) {
			$this->Article->create();
			
			if (empty($this->request->data['Article']['featured_image']['name'])) {
				unset($this->request->data['Article']['featured_image']);
			}

			$this->request->data['Article']['user_id'] = $this->Auth->user('id');

			if (empty($this->request->data['Article']['slug'])) {
				$this->request->data['Article']['slug'] = $this->Article->generateSlug($this->request->data['Article']['title']);
			}


			if ($this->Article->save($this->request->data)) {
				$this->Flash->success(__('Article has been added Succesfully.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Article could not be added. Please, try again.'));
			}
		}

		$categories = $this->Article->Category->find('list',array(
			'fields' => array('Category.id', 'Category.name'),
			'order' => array('Category.sort' => 'asc'),
			'conditions' => array(
				'Category.model' => 'Article',
				'Category.status' => 1
			)
		));
		$this->set(compact('categories'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {

		$this->helpers[] = 'Froala.Froala';

		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}

		if ($this->request->is(array('post', 'put'))) {

			if (empty($this->request->data['Article']['featured_image']['name'])) {
				unset($this->request->data['Article']['featured_image']);
			}

			if (empty($this->request->data['Article']['slug'])) {
				$this->request->data['Article']['slug'] = $this->Article->generateSlug($this->request->data['Article']['title']);
			}

			if ($this->Article->save($this->request->data)) {
				$this->Flash->success(__('Article has been updated Succesfully.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('Article could not be updated. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
			$this->request->data = $this->Article->find('first', $options);
		}
		$categories = $this->Article->Category->find('list', [
			'fields' => array('Category.id', 'Category.name'),
			'order' => array('Category.sort' => 'asc'),
			'conditions' => array(
				'Category.model' => 'Article',
				'Category.status' => 1
			)
		]);

		$this->set(compact('categories'));
	}


/**
 * Sort method
 *
 * @return void
 */
	public function admin_sort() {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->is('ajax')) {
			if ($this->request->data['action'] === 'sort'){
				$array = $this->request->data['arrayorder'];
				$count = 1;
				foreach ($array as $idval) {
					$query = " UPDATE articles SET sort={$count} WHERE id={$idval}";
					$this->Article->query($query);
					$count ++;
				}
				$response['type'] = 'success';
				$response['message'] = __('Sort changed successfully.');
			}
		}
		return json_encode($response);
	}

/**
 * changeStatus method
 *
 * @return void
 */
	public function admin_changeStatus(){
		$this->autoRender = false;
		$this->layout = null;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];


		if ($this->Article->save($this->request->data)) {
			$response['type'] = 'success';
			$response['message'] = __('You successfully changed this Article status.');
		} else {
			$response['error'] = 1;
			$response['type'] = 'error';
			$response['message'] = __('Article Status could not be changed. Please Try again!');
		}

		return json_encode($response);
	}

/**
 * changeStatus method
 *
 * @return void
 */
	public function admin_changeFeatureStatus(){
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];
		
		if ($this->request->is('ajax')){
			if ($this->Article->save($this->request->data)) {
				$response['type'] = 'success';
				$response['message'] = __('You successfully changed this Article feature status.');
			} else {
				$response['error'] = 1;
				$response['type'] = 'error';
				$response['message'] = __('Article feature Status could not be changed. Please Try again!');
			}
		}
		return json_encode($response);
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->autoRender = false;
		// This is Standart FOrmat for all Ajax Call
		$response = [
			'error' 	=> 0,		// 0 | 1
			'type' 		=> 'info',	// info, warning, error, success
			'message' 	=> '',
			'data' 		=> null,
		];

		if ($this->request->is('post')) {
			$this->Article->id = $id;
			if ($this->request->is('ajax')) {
				if ($this->Article->delete()) {
					$response['type'] = 'success';
					$response['message'] = __('Article has been deleted.');
				} else {
					$response['error'] = 1;
					$response['type'] = 'error';
					$response['message'] = __('Article could not be deleted. Please Try again!');
				}
				return json_encode($response);
			} else {
				if ($this->Article->delete()) {
					$this->Flash->success(__('Article has been deleted.'));
				} else {
					$this->Flash->error(__('Article could not be deleted. Please Try again!'));
				}
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

}
