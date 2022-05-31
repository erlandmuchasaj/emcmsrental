<?php
App::uses('AppModel', 'Model');
/**
 * Wishlist Model
 *
 * @property User $User
 * @property Property $Property
 */
class Wishlist extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not directly modify this attribute',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Wishlist name can not be empty',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'maxLength' => array(
				'rule' => array('maxLength', 50),
				'message' => 'Wishlist name can not have more than 50 characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'UserWishlist' => array(
			'className' => 'UserWishlist',
			'foreignKey' => 'wishlist_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

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
		),
	);

	public function afterFind($results, $primary = false) {
		if (!$primary) {
			return parent::afterFind($results, $primary);
		}

	    foreach ($results as $key => $wishlist) {
	    	$wishlist['Wishlist']['thumbnail'] = '';
	    	// geather all wishlist categories of this user
	    	$userWishlist = $this->UserWishlist->find('first', array(
	    		'conditions'=> array(
		    		'UserWishlist.wishlist_id'=>  $wishlist['Wishlist']['id'], 
		    		'UserWishlist.user_id' => AuthComponent::user('id')
	    		),
	    		'contain' => [
					'Property'
				]
	    	));
	    	if (isset($userWishlist['Property']['id'])) {
	    		$wishlist['Wishlist']['thumbnail'] = Router::url('/img/uploads/Property/'.$userWishlist['Property']['id'].'/PropertyPicture/medium/'.$userWishlist['Property']['thumbnail'], true);
	    	}
	       	$results[$key] = $wishlist;
	    }
	    return $results;
	}

	public function isInWishlist($model_id = null, $wishlist_id = null, $model = 'Property') {
		$model = Inflector::classify($model);
		// geather all wishlist categories of this user
		$isInWishlist = $this->UserWishlist->find('count', array(
			'conditions'=> array(
				'UserWishlist.user_id' => AuthComponent::user('id'),
				'UserWishlist.wishlist_id'=> $wishlist_id, 
				'UserWishlist.model_id' => $model_id,
				'UserWishlist.model' => $model,
				// 'UserWishlist.property_id' => $property_id,
			),
			'recursive' => -1,
			'callbacks' => false
		));
	    return (bool)$isInWishlist;
	}

}
