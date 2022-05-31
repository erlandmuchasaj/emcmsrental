<?php
App::uses('AppModel', 'Model');
/**
 * PropertyPicture Model
 *
 * @property Property $Property
 */
class PropertyPicture extends AppModel {


/**
 * Model Name
 *
 * @var string
 */	
	public $name = 'PropertyPicture';
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
	public $displayField = 'image_path';


/**
 * ActsAs
 *
 * @var array
 */
	// public $actsAs = array(
	// 	'Upload.Upload' => array('fields' => array('image_path'=>''),'use_thumbnails'=>true)
	// );

	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => "You can not access this attribute directly!",
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Property' => array(
			'className' => 'Property',
			'foreignKey' => 'property_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);



	/* Update property thumbnail for easy access. */
	public function updateThumbnail($property_id = null, $validate = false) {
		$getThumbnail = $this->find('first', [
			'conditions' => array('PropertyPicture.property_id'=>$property_id),
			'order' => array('PropertyPicture.sort'=>'ASC'), 
			'recursive' => -1,
			'callbacks' => false,
		]);

		if ($getThumbnail) {
			$this->Property->id = $property_id;
			$this->Property->saveField('thumbnail', $getThumbnail['PropertyPicture']['image_path'], $validate);
		}
	}


/*****************************************************
* 		BEFORE DELETE
******************************************************/
	private  $beforeDeleteVar;
	public function beforeDelete($cascade = true) {
		if (isset($this->id) && !empty($this->id)) {
			$this->beforeDeleteVar = $this->find('first', [
				'conditions' => array($this->alias.'.id' => $this->id),
				'recursive' => -1,
				'callbacks' => false,
			]);
		}

		return parent::beforeDelete($cascade);
	}

	public function afterDelete() {
		parent::afterDelete();
		if (isset($this->beforeDeleteVar) && !empty($this->beforeDeleteVar)) {
			$property_id = $this->beforeDeleteVar[$this->alias]['property_id'];
			$directories[] = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'.DS;
			$directories[] = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'.DS.'thumb'.DS;
			$directories[] = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'.DS.'xsmall'.DS;
			$directories[] = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'.DS.'small'.DS;
			$directories[] = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'.DS.'medium'.DS;
			$directories[] = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'.DS.'large'.DS;
			$directories[] = Configure::read('App.www_root').'img'.DS.'uploads'.DS.'Property'.DS.$property_id.DS.'PropertyPicture'.DS.'xlarge'.DS;

			foreach ($directories as $directory) {
				$file_to_delete = $directory.$this->beforeDeleteVar[$this->alias]['image_path'];
				if (file_exists($file_to_delete) && is_file($file_to_delete)) {	
					@unlink($file_to_delete);
				}
			}
		}
		return true;
	}

}
