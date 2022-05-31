<?php
App::uses('AppModel', 'Model');
/**
 * HomeSlider Model
 *
 */
class HomeSlider extends AppModel {
/**
 * Model Name
 *
 * @var string
 */	
	public $name = 'HomeSlider';
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
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'blank' => array(
				'rule' => array('blank'),
				'message' => 'You can not directly modify this attribute',
				'on' => 'create',
			),
		),
		'slogan' => array(
			'maxLength' => array(
				'rule' => array('maxLength', 100),
				'message' => 'Slogan can be up to 100 characters long.',
				'allowEmpty' => true,
			),
		),
		'image_path' => array(
			'fileExtension' => array(
				'rule' => array('fileExtension', array('png','jpg','jpeg')),
				'message' => 'Please supply a valid image (PNG , JPEG, JPG only).',
				'allowEmpty' => false,
				'on' => 'create',
			),
			'fileMaxSize' => array(
				'rule' => array('fileMaxSize', '8388608'),
				'message' => 'Max file size is exeeded.',
				'allowEmpty' => false,
				'on' => 'create',
			),
			'processMediaUpload' => array(
				'rule' => 'processMediaUpload',
				'message' => 'Unable to process image upload.',
				'allowEmpty' => false,
				'on' => 'create',
			),
		),
	);

/**
 * ActsAs
 *
 * @var array
 */
	public $actsAs = array(
		'Upload.Upload' => array('fields' => array('image_path'=>''), 'use_thumbnails' => true)
	);

	/**
	 *	{
	 *		img: '1.jpg',
	 *		thumb: '1-thumb.jpg',
	 *		full: '1-full.jpg', // Separate image for the fullscreen mode.
	 *		video: 'http://youtu.be/C3lWwBslWqg', // Youtube, Vimeo or custom iframe URL
	 *		id: 'one', // Custom anchor is used with the hash:true option.
	 *		caption: 'The first caption',
	 *		html: $('selector'), // ...or '<div>123</div>'. Custom HTML inside the frame.
	 *		fit: 'cover', // Override the global fit option.
	 *		any: 'Any data relative to the frame you want to store'
	 *	}
	 * 
	 * getSlider grab all image to show on home
	 * slider
	 * @return array response to be used in fotorama
	 */
	public function getSlider() {
		$absolutePicPath = Router::url('/img/uploads/HomeSlider/', true);
		$directory = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'HomeSlider' . DS;
		$results = $this->find(
			'all', array(
				'conditions' => array('HomeSlider.status'=>1),
				'order' => array('HomeSlider.sort' => 'ASC')
			)
		);

		$slider = [];
	    foreach ($results as $key => $homeSlider) {
	    	$picPAth = '';
			if (!empty($homeSlider['HomeSlider']['image_path'])) {
				if ( file_exists($directory.$homeSlider['HomeSlider']['image_path']) && is_file($directory.$homeSlider['HomeSlider']['image_path'])) {  
					$picPAth = $absolutePicPath.$homeSlider['HomeSlider']['image_path'];
				}
			} 
	    	$slider[$key]['img'] = $picPAth;
	    	$slider[$key]['thumb'] = null;
	    	$slider[$key]['full'] = null;
	    	$slider[$key]['video'] = null;
	    	$slider[$key]['id'] = 'slider_'.$homeSlider['HomeSlider']['id'];
	    	$slider[$key]['caption'] = null;
	    	$slider[$key]['html'] = '<p class="homeslider-caption">'.h($homeSlider['HomeSlider']['slogan']).'</p>';
	    	$slider[$key]['fit'] = 'cover';
	    	$slider[$key]['any'] = null;
	    }
	    return $slider;
	}


}