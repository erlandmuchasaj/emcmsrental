<?php
App::uses('AppModel', 'Model');
/**
 * Price Model
 *
 * @property User $User
 */
class Price extends AppModel {
	/**
	 * Model Name
	 *
	 * @var string
	 */	
	public $name = 'Price';

	/**
	 * User Table
	 *
	 * @var string
	 */	
	public $useTable = 'prices';

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
	public $displayField = 'model';

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = [
		'Property' => [
			'className' => 'Property',
			'foreignKey' => 'model_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		]
	];

}
