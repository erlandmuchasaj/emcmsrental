<?php
class CurrencyConverterAppModel extends AppModel {
	public $name = 'CurrencyConverter';

	public $validate = array(
		'from' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'not empty field from'
			)
		),
		'to' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'not empty field to'
			)
		),
		'rates' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'not empty field rates'
			)
		)
	);
}
?>