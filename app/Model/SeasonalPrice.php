<?php
App::uses('AppModel', 'Model');
/**
 * SeasonalPrice Model
 *
 * @property Property $Property
 */
class SeasonalPrice extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'model';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'Your can not modify directly the ID',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'start_date field can not be left blank',
			),
		),
		'end_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'end_date field can not be left blank',
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Property' => array(
		    'className' => 'Property',
		    'foreignKey' => 'model_id',
		    'conditions' => array(
		        'SeasonalPrice.model' => 'Property',
		    ),
		),
		'Experience' => array(
		    'className' => 'Experience',
		    'foreignKey' => 'model_id',
		    'conditions' => array(
		        'SeasonalPrice.model' => 'Experience',
		    ),
		),
	);
}
