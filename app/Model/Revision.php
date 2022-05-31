<?php
App::uses('AppModel', 'Model');
/**
 * Revision Model
 *
 */
class Revision extends AppModel {

	public $belongsTo = 'User';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'revision';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'revision' => array(
			'rule' => 'notBlank',
			'message' => 'Please enter the value for revision'
		),
		'model_id' => array(
			'rule' => 'notBlank',
			'message' => 'Please enter the value for model_id'
		),
		'model' => array(
			'rule' => 'notBlank',
			'message' => 'Please enter the value for model'
		),
		'field' => array(
			'rule' => 'notBlank',
			'message' => 'Please enter the value for field'
		)
	);

/**
 * Takes the posted data and updates it with the revision
 * @param  string $revision
 * @param  array  $data
 * @return array
 */
	public function get($key = null, $data = array()) {
		if (!$key) {
			throw new NotFoundException(__('Invalid Revision'));
		}

		$this->recursive = -1;
		$revisions = $this->find('all', array(
			'conditions' => array(
				'Revision.revision' => $key
			),
			'fields' => array('field', 'value')
		));

		if (!$revisions) {
			throw new NotFoundException(__('Invalid Revision'));
		}

		foreach ($revisions as $revision) {
			$data[$revision['Revision']['field']] = $revision['Revision']['value'];
		}

		return $data;
	}
}