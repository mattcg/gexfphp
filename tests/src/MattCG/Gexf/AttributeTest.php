<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Attribute;
use MattCG\Gexf\AttributeType;

class AttributeTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testAttributeIdMayNotBeInteger() {
		new Attribute(1, new AttributeType(), 'Title');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testAttributeIdMayNotBeEmptyString() {
		new Attribute('  ', new AttributeType(), 'Title');
	}

	public function testAttributeIdMayBeString() {
		$id = 'someid';
		$attr = new Attribute($id, new AttributeType(), 'Title');
		$this->assertEquals($id, $attr->getId());
	}

	public function testAttributeIdIsTrimmed() {
		$attr = new Attribute('a ', new AttributeType(), 'Title');
		$this->assertEquals('a', $attr->getId());
	}

	public function testGetAttributeType() {
		$attrtype = new AttributeType();
		$attr = new Attribute('someid', $attrtype, 'Title');
		$this->assertEquals($attrtype, $attr->getAttributeType());
	}

	public function testDefaultAttributeTypeIsString() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$this->assertEquals(AttributeType::TYPE_STRING, (string) $attr->getAttributeType());
	}

	public function testGetTitle() {
		$title = 'Title';
		$attr = new Attribute('someid', new AttributeType(), $title);
		$this->assertEquals($title, $attr->getTitle());
	}

	public function testSetTitle() {
		$attr = new Attribute('someid', new AttributeType(), 'Some other title');
		$title = 'Title';
		$attr->setTitle($title);
		$this->assertEquals($title, $attr->getTitle());
	}

	public function testAttributeTitleDefaultsToNull() {
		$attr = new Attribute('someid', new AttributeType());
		$this->assertNull($attr->getTitle());
	}

	public function testAttributeTitleMayBeNull() {
		$attr = new Attribute('someid', new AttributeType(), null);
		$this->assertNull($attr->getTitle());
		$attr = new Attribute('someid', new AttributeType());
		$attr->setTitle(null);
		$this->assertNull($attr->getTitle());
	}

	public function testCreateValue() {
		$value = 'somevalue';
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attrvalue = $attr->createValue($value);
		$this->assertEquals($attr, $attrvalue->getAttribute());
		$this->assertEquals($value, $attrvalue->getValue());
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testCannotPassNonArrayToSetOptions() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions('someoption1');
	}

	public function testGetOptions() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions($options);
		$this->assertTrue(is_array($attr->getOptions()));
		$this->assertNotEmpty($attr->getOptions());
		$this->assertEquals($options, $attr->getOptions());
	}

	public function testSetOptionsForStringAttribute() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions($options);
		$this->assertEquals($options, $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetNonStringOptionsForStringAttribute() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions(array(1, 2, 3));
	}

	public function testAddOptionForStringAttribute() {
		$option = 'someoption1';
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->addOption($option);
		$this->assertEquals(array($option), $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotAddNonStringOptionForStringAttribute() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->addOption(1);
	}

	public function testSetOptionsForIntegerAttribute() {
		$options = array(1, 2, 3);
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->setOptions($options);
		$this->assertEquals($options, $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetNonIntegerOptionsForIntegerAttribute() {
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->setOptions(array(1.1, 1.2, 1.3));
	}

	public function testAddOptionForIntegerAttribute() {
		$option = 1;
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->addOption($option);
		$this->assertEquals(array($option), $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotAddNonIntegerOptionForIntegerAttribute() {
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->addOption(1.1);
	}

	public function testSetOptionsForFloatAttribute() {
		$options = array(1.1, 1.2, 1.3);
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$attr->setOptions($options);
		$this->assertEquals($options, $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetNonFloatOptionsForFloatAttribute() {
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$attr->setOptions(array(1, 1, 1));
	}

	public function testAddOptionForFloatAttribute() {
		$option = 1.1;
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$attr->addOption($option);
		$this->assertEquals(array($option), $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotAddNonFloatOptionForFloatAttribute() {
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$attr->addOption(1);
	}

	public function testSetOptionsForListstringAttribute() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setOptions($options);
		$this->assertEquals($options, $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetNonStringOptionsForListstringAttribute() {
		$options = array('someoption1', 2, 'someoption3');
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setOptions($options);
	}

	public function testAddOptionForListstringAttribute() {
		$option = 'someoption1';
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->addOption($option);
		$this->assertEquals(array($option), $attr->getOptions());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotAddNonStringOptionForListstringAttribute() {
		$option = 1;
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->addOption($option);
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testCannotSetOptionsForBooleanAttribute() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions(array(true, false));
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testCannotAddOptionForBooleanAttribute() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions(true);
	}

	public function testPassingEmptyArrayToSetOptionsClearsThem() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions($options);
		$attr->setOptions(array());
		$this->assertEquals(array(), $attr->getOptions());
	}

	public function testClearOptions() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions(array('someoption1', 'someoption2', 'someoption3'));
		$this->assertTrue($attr->hasOptions());
		$attr->clearOptions();
		$this->assertFalse($attr->hasOptions());
	}

	public function testHasOptions() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$this->assertFalse($attr->hasOptions());
		$attr->setOptions(array('someoption1', 'someoption2', 'someoption3'));
		$this->assertTrue($attr->hasOptions());
		$attr->setOptions(array());
		$this->assertFalse($attr->hasOptions());
	}

	public function testHasOption() {

		// Test with strings
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$this->assertFalse($attr->hasOption('nonexistent'));
		$attr->setOptions($options);
		$this->assertFalse($attr->hasOption('nonexistent'));
		foreach ($options as $option) {
			$this->assertTrue($attr->hasOption($option));
		}

		// Test with integers
		$options = array(1, 2, 3);
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$this->assertFalse($attr->hasOption(1));
		$attr->setOptions($options);
		$this->assertFalse($attr->hasOption(4));
		foreach ($options as $option) {
			$this->assertTrue($attr->hasOption($option));
		}

		// Test with floats
		$options = array(1.1, 1.2, 1.3);
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$this->assertFalse($attr->hasOption(1.1));
		$attr->setOptions($options);
		$this->assertFalse($attr->hasOption(1.4));
		foreach ($options as $option) {
			$this->assertTrue($attr->hasOption($option));
		}

		// Test with liststring
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$this->assertFalse($attr->hasOption('someoption1'));
		$attr->setOptions($options);
		$this->assertFalse($attr->hasOption('someoption4'));
		foreach ($options as $option) {
			$this->assertTrue($attr->hasOption($option));
		}
	}

	public function testSetDefaultValueToString() {
		$defaultvalue = 'somevalue';
		$this->assertTrue(is_string($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_STRING), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testStringAttributeCannotHaveNonStringDefaultValue() {
		$defaultvalue = 1;
		$this->assertFalse(is_string($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_STRING), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSetDefaultValueToAnyUri() {
		$defaultvalue = '/someuri';
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_ANYURI), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testAnyUriAttributeCannotHaveNonAnyUriDefaultValue() {
		$defaultvalue = 1;
		$this->assertFalse(is_string($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_ANYURI), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSetDefaultValueToBoolean() {
		$defaultvalue = false;
		$this->assertTrue(is_bool($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_BOOLEAN), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testBooleanAttributeCannotHaveNonBooleanDefaultValue() {
		$defaultvalue = 'nonboolean';
		$this->assertFalse(is_bool($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_BOOLEAN), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSetDefaultValueToDouble() {
		$defaultvalue = 1.2e3;
		$this->assertTrue(is_double($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_DOUBLE), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testDoubleAttributeCannotHaveNonDoubleDefaultValue() {
		$defaultvalue = 1;
		$this->assertFalse(is_double($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_DOUBLE), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSetDefaultValueToFloat() {

		// A float and a double are the same thing in PHP
		$defaultvalue = 1.2e3;
		$this->assertTrue(is_float($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFloatAttributeCannotHaveNonFloatDefaultValue() {
		$defaultvalue = 1;
		$this->assertFalse(is_float($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSetDefaultValueToInteger() {
		$defaultvalue = 1;
		$this->assertTrue(is_int($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIntegerAttributeCannotHaveNonIntegerDefaultValue() {
		$defaultvalue = '1';
		$this->assertFalse(is_int($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSetDefaultValueToLong() {

		// A long and an int are the same thing in PHP
		$defaultvalue = 1;
		$this->assertTrue(is_long($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testLongAttributeCannotHaveNonLongDefaultValue() {
		$defaultvalue = 1.2e3;
		$this->assertFalse(is_long($defaultvalue));
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSetDefaultValueToListstring() {
		$defaultvalue = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetDefaultValueOnlyAcceptsArrayForListstring() {
		$defaultvalue = 'someoption1';
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetDefaultValueChecksAllOptionsForListString() {
		$defaultvalue = array('someoption1', 1, 'someoption3');
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setDefaultValue($defaultvalue);
	}

	public function testSettingDefaultValueToEmptyArrayClearsItForListstring() {
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setDefaultValue(array());
		$this->assertNull($attr->getDefaultValue());
	}

	public function testSettingDefaultValueToNullClearsIt() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setDefaultValue(null);
		$this->assertNull($attr->getDefaultValue());
	}

	public function testInitialDefaultValueIsNull() {
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$this->assertNull($attr->getDefaultValue());
	}

	public function testClearDefaultValue() {
		$defaultvalue = 'somevalue';
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setDefaultValue($defaultvalue);
		$attr->clearDefaultValue();
		$this->assertNull($attr->getDefaultValue());
	}

	public function testHasDefaultValue() {
		$defaultvalue = 'somevalue';
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$this->assertFalse($attr->hasDefaultValue());
		$attr->setDefaultValue($defaultvalue);
		$this->assertTrue($attr->hasDefaultValue());
	}

	public function testSetDefaultValueToAvailableOption() {
		$options = array(1.1, 1.2, 1.3);
		$defaultvalue = 1.1;
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_FLOAT), 'Title');
		$attr->setOptions($options);
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	public function testSetDefaultValueToAvailableOptionForListstring() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$defaultvalue = array($options[2], $options[1]);
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setOptions($options);
		$attr->setDefaultValue($defaultvalue);
		$this->assertEquals($defaultvalue, $attr->getDefaultValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetDefaultValueToUnavailableOption() {
		$options = array(1, 2, 3);
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_INTEGER), 'Title');
		$attr->setOptions($options);
		$attr->setDefaultValue(4);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetDefaultValueToUnavailableOptionsForListString() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setOptions($options);
		$attr->setDefaultValue(array('someoption4'));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetOptionsNotContainingCurrentDefaultValue() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(), 'Title');
		$attr->setDefaultValue('someoption4');
		$attr->setOptions($options);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotSetOptionsNotContainingCurrentDefaultValueForListring() {
		$options = array('someoption1', 'someoption2', 'someoption3');
		$attr = new Attribute('someid', new AttributeType(AttributeType::TYPE_LISTSTRING), 'Title');
		$attr->setDefaultValue(array('someoption4'));
		$attr->setOptions($options);
	}
}
