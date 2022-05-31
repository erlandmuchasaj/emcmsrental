<?php
App::uses('AppModel', 'Model');
class PayoutPreference extends AppModel
{
    public $name = 'PayoutPreference';
    
    public $useTable = 'payout_preferences';

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        // 'Payment' => array(
        //     'className' => 'Payment',
        //     'foreignKey' => 'payout_method',
        //     'conditions' => array(
        //         'PayoutPreference.model' => 'Payment'
        //     )
        // ),
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
            'id' => array(
                'blank' => array(
                    'rule' => array('blank'),
                    'message' => 'You can not directly access ID.',
                    //'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'address1' => array(
                'notBlank' => array(
                    'rule' => array('notBlank'),
                    'message' => 'Please enter primary address',
                    'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'country' => array(
                'notBlank' => array(
                    'rule' => array('notBlank'),
                    'message' => 'Country name can not be empty.',
                    'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'city' => array(
                'notBlank' => array(
                    'rule' => array('notBlank'),
                    'message' => 'City name can not be empty',
                    'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'postal_code' => array(
                'notBlank' => array(
                    'rule' => array('notBlank'),
                    'message' => 'Postal code can not be empty name can not be empty',
                    'allowEmpty' => false,
                    //'required' => false,
                    //'last' => false, // Stop validation after this rule
                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                ),
            ),
            'currency' => array(
                'maxLength' => array(
                    'rule' => array('maxLength', 3),
                    'message' => 'Max length of code is 3.',
                ),
                'notBlank' => array(
                    'rule' => array('notBlank'),
                    'message' => 'Should Not be empty.',
                ),
            ),
            'payout_method' => array(
                'notBlank' => array(
                    'rule' => array('notBlank'),
                    'message' => 'Should Not be empty.',
                    'allowEmpty' => false,
                    'required' => true,
                ),
            ),
    );


}