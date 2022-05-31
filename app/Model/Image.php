<?php
App::uses('AppModel', 'Model');
class Image extends AppModel
{

    /**
     * Model Name
     *
     * @var string
     */ 
    public $name = 'Image';

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
    public $displayField = 'src';

    /**
     * Table name
     *
     * @var string
     */
    public $useTable = 'images';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'blank' => array(
                'rule' => array('blank'),
                'message' => 'You can not access this attribute directly!',
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );


    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'Image.model' => 'User',
            ),
        ),
        'Article' => array(
            'className' => 'Article',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'Image.model' => 'Article',
            ),
        ),
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'Image.model' => 'City',
            ),
        ),
        'Experience' => array(
            'className' => 'Experience',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'Image.model' => 'Experience',
            ),
        ),
        'Service' => array(
            'className' => 'Service',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'Image.model' => 'Service',
            ),
        ),
    );


    private $beforeDeleteVar;
    public function beforeDelete($cascade = true) {
        if (isset($this->id) && !empty($this->id)) {
            $this->beforeDeleteVar = $this->find('first', array('conditions' => array($this->alias.'.id' => $this->id)));
        }
        return parent::beforeDelete($cascade);
    }

    public function afterDelete() {
        parent::afterDelete();
        
        if (isset($this->beforeDeleteVar) && !empty($this->beforeDeleteVar)) {
            $model = $this->beforeDeleteVar[$this->alias]['model'];
            $model_id = $this->beforeDeleteVar[$this->alias]['model_id'];

            $directories[] = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $model . DS . $model_id . DS; // original img
            $directories[] = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $model . DS . $model_id . DS . 'thumb'  . DS;
            $directories[] = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $model . DS . $model_id . DS . 'xsmall' . DS;
            $directories[] = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $model . DS . $model_id . DS . 'small'  . DS;
            $directories[] = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $model . DS . $model_id . DS . 'medium' . DS;
            $directories[] = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $model . DS . $model_id . DS . 'large'  . DS;
            $directories[] = Configure::read('App.www_root') . 'img' . DS . 'uploads' . DS . $model . DS . $model_id . DS . 'xlarge' . DS;

            foreach ($directories as $directory) {
                $file_to_delete = $directory.$this->beforeDeleteVar[$this->alias]['src'];
                if (file_exists($file_to_delete) && is_file($file_to_delete)) { 
                    @unlink($file_to_delete);
                }
            }
        }
        return true;
    }

}
