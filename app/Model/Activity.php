<?php
App::uses('AppModel', 'Model');
class Activity extends AppModel 
{
    public $name = 'Activity';
    
    public $useTable = 'activities';
    
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'item_id',
            'conditions' => array(
                'Activity.model' => 'User',
            ),
        ),
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'item_id',
            'conditions' => array(
                'Activity.model' => 'Language',
            ),
        ),
        'Currency' => array(
            'className' => 'Currency',
            'foreignKey' => 'item_id',
            'conditions' => array(
                'Activity.model' => 'Currency',
            ),
        ),        
    );

}