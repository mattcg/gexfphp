<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Attribute;
use MattCG\Gexf\AttributeValue;
use MattCG\Gexf\AttributeType;

class AttributeValueTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAttributeIsRequired() {
		$attrvalue = new AttributeValue();
	}

	public function testGetAttribute() {
		$attr = new Attribute(1, new AttributeType());
		$attrvalue = new AttributeValue($attr);
		$this->assertEquals($attr, $attrvalue->getAttribute());
	}

	public function testValueIsNullByDefault() {
		$attr = new Attribute(1, new AttributeType());
		$attrvalue = new AttributeValue($attr);
		$this->assertNull($attrvalue->getValue());
	}

	public function testSetValue() {
		$attr = new Attribute(1, new AttributeType());
		$attrvalue = new AttributeValue($attr);
		$value = 'somevalue';
		$attrvalue->setValue($value);
		$this->assertEquals($value, $attrvalue->getValue());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetValueValidatesType() {
		$attr = new Attribute(1, new AttributeType(AttributeType::TYPE_INTEGER));
		$attrvalue = new AttributeValue($attr);
		$attrvalue->setValue('somestringvalue');
	}
}
