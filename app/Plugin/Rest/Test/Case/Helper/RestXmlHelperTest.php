<?php
App::import('Helper', 'Rest.RestXml');

class Author {
	var $name = 'Rodrigo Moyle';
}

class RestXmlHelperTest extends CakeTestCase {
	function setUp() {
		$this->RestXml = new RestXmlHelper();
	}

	function testSerializeInt() {
		$result = $this->RestXml->serialize(1);
		$this->assertEqual($result, '<var type="integer">1</var>');
	}

	function testSerializeString() {
		$result = $this->RestXml->serialize('This is a string');
		$this->assertEqual($result, '<var>This is a string</var>');
	}

	function testSerializeWithName() {
		$result = $this->RestXml->serialize('Another String', 'name');
		$this->assertEqual($result, '<name>Another String</name>');
	}

	function testSerializeBoolean() {
		$result = $this->RestXml->serialize(true);
		$this->assertEqual($result, '<var type="boolean">true</var>');
	}

	function testSerializeBooleanFalse() {
		$result = $this->RestXml->serialize(false);
		$this->assertEqual($result, '<var type="boolean">false</var>');
	}

	function testSerializeDatetime() {
		$result = $this->RestXml->serialize('2009-04-07T01:48:04Z');
		$this->assertEqual($result, '<var type="datetime">2009-04-07T01:48:04Z</var>');
		$result = $this->RestXml->serialize('2009-04-07');
		$this->assertEqual($result, '<var type="datetime">2009-04-07T00:00:00Z</var>');
	}

	function testSerializeStdClass() {
		$data = new stdClass();
		$data->name = 'Rodrigo Moyle';
		$data->description = 'Lorem ipsum dolor sit amet.';
		$result = $this->RestXml->serialize($data, 'user');
		$this->assertTags($result, array(
			'<user',
			'<name',
			'Rodrigo Moyle',
			'/name',
			'<description',
			'Lorem ipsum dolor sit amet.',
			'/description',
			'/user'
		), true);
	}

	function testSerializeAssocArray() {
		$data = array(
			'name' => 'Rodrigo Moyle',
			'description' => 'Lorem ipsum dolor sit amet.',
		);
		$result = $this->RestXml->serialize($data, 'user');
		$this->assertTags($result, array(
			'<user',
			'<name',
			'Rodrigo Moyle',
			'/name',
			'<description',
			'Lorem ipsum dolor sit amet.',
			'/description',
			'/user'
		), true);
	}

	function testSerializeNumericArray() {
		$data = array(
			1,
			'string'
		);
		$result = $this->RestXml->serialize($data, 'users');
		$this->assertTags($result, array(
			'users' => array('type' => 'array'),
			'user' => array('type' => 'integer'),
			'1',
			'/user',
			'<user',
			'string',
			'/user',
			'/users'
		), true);
	}

	function testSerializeFindFirstResult() {
		$data = array(
			'User' => array(
				'name' => 'Rodrigo Moyle'
			)
		);
		$result = $this->RestXml->serialize($data);
		$this->assertTags($result, array(
			'<user',
			'<name',
			'Rodrigo Moyle',
			'/name',
			'/user'
		), true);
	}

	function testSerializeFindAllResult() {
		$data = array(
			array(
				'User' => array(
					'name' => 'Rodrigo Moyle'
				)
			),
			array(
				'User' => array(
					'name' => 'Another User'
				)
			)
		);
		$expected = array(
			'users' => array('type' => 'array'),
				'<user',
					'<name',
						'Rodrigo Moyle',
					'/name',
				'/user',
				'<user',
					'<name',
						'Another User',
					'/name',
				'/user',
			'/users'
		);
		$result = $this->RestXml->serialize($data, 'users');
		$this->assertTags($result, $expected, true);
		$result = $this->RestXml->serialize($data);
		$this->assertTags($result, $expected, true);
	}

	function testSerializeCamelCaseName() {
		$result = $this->RestXml->serialize('Rodrigo Moyle', 'UserName');
		$this->assertEqual($result, '<user-name>Rodrigo Moyle</user-name>');
	}

	function testSerializeUnderscoredName() {
		$result = $this->RestXml->serialize('Rodrigo Moyle', 'user_name');
		$this->assertEqual($result, '<user-name>Rodrigo Moyle</user-name>');
	}

	function testSerializeCamelCaseNameInArray() {
		$data = array('UserName' => 'Rodrigo Moyle');
		$result = $this->RestXml->serialize($data);
		$this->assertTags($result, array(
			'<var',
			'<user-name',
			'Rodrigo Moyle',
			'/user-name',
			'/var'
		), true);
	}

	function testSerializeObject() {
		$author = new Author();
		$result = $this->RestXml->serialize($author);
		$this->assertTags($result, array(
			'<author',
			'<name',
			'Rodrigo Moyle',
			'/name',
			'/author'
		), true);
	}

	function testGetTypeWithBasicTypes() {
		$values = array(1, 0.5, '1', '0.5', 'String', true, false, array(1, 2));
		$types  = array('integer', 'double', 'integer', 'double', 'string', 'boolean', 'boolean', 'array');
		for ($i = 0; $i < count($values); $i++) {
			$value = $values[$i];
			$type  = $types[$i];
			$this->assertEqual($this->RestXml->_getType($value), $type);
		}
	}

	function testGetTypeWithDatetime() {
		$datetime = '2009-04-07T01:48:04Z';
		$result = $this->RestXml->_getType($datetime);
		$this->assertEqual($result, 'datetime');
		$datetime = '2009-04-07 01:48:04';
		$result = $this->RestXml->_getType($datetime);
		$this->assertEqual($result, 'datetime');
	}

	function testGetTypeWithDate() {
		$date = '2009-04-07';
		$result = $this->RestXml->_getType($date);
		$this->assertEqual($result, 'datetime');
	}

	function testGetTypeWithTime() {
		$time = '01:48:04';
		$result = $this->RestXml->_getType($time);
		// Should datetime or time?
		$this->assertEqual($result, 'string');
		$time = '01:48';
		$result = $this->RestXml->_getType($time);
		// Should datetime or time?
		$this->assertEqual($result, 'string');
	}
}
