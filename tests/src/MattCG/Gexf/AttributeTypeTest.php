<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\AttributeType;

class AttributeTypeTest extends PHPUnit_Framework_TestCase {

	public function testDefaultTypeIsString() {
		$attrtype = new AttributeType();
		$this->assertTrue(AttributeType::TYPE_STRING == $attrtype);
		$this->assertFalse(AttributeType::TYPE_STRING === $attrtype);
		$this->assertEquals(AttributeType::TYPE_STRING, (string) $attrtype);
	}

	public function testCanHaveValue() {
		$attrtype = new AttributeType(AttributeType::TYPE_ANYURI);
		$this->assertFalse($attrtype->canHaveValue(1));
		$this->assertTrue($attrtype->canHaveValue('somevalue'));

		$attrtype = new AttributeType(AttributeType::TYPE_STRING);
		$this->assertFalse($attrtype->canHaveValue(1));
		$this->assertTrue($attrtype->canHaveValue('somevalue'));

		$attrtype = new AttributeType(AttributeType::TYPE_BOOLEAN);
		$this->assertFalse($attrtype->canHaveValue(1));
		$this->assertFalse($attrtype->canHaveValue(0));
		$this->assertTrue($attrtype->canHaveValue(true));
		$this->assertTrue($attrtype->canHaveValue(false));

		$attrtype = new AttributeType(AttributeType::TYPE_DOUBLE);
		$this->assertFalse($attrtype->canHaveValue(1));
		$this->assertFalse($attrtype->canHaveValue('1.1'));
		$this->assertTrue($attrtype->canHaveValue(1.1));

		$attrtype = new AttributeType(AttributeType::TYPE_FLOAT);
		$this->assertFalse($attrtype->canHaveValue(1));
		$this->assertFalse($attrtype->canHaveValue('1.1'));
		$this->assertTrue($attrtype->canHaveValue(1.1));

		$attrtype = new AttributeType(AttributeType::TYPE_LONG);
		$this->assertFalse($attrtype->canHaveValue(1.1));
		$this->assertFalse($attrtype->canHaveValue('1'));
		$this->assertTrue($attrtype->canHaveValue(1));

		$attrtype = new AttributeType(AttributeType::TYPE_INTEGER);
		$this->assertFalse($attrtype->canHaveValue(1.1));
		$this->assertFalse($attrtype->canHaveValue('1'));
		$this->assertTrue($attrtype->canHaveValue(1));

		$attrtype = new AttributeType(AttributeType::TYPE_LISTSTRING);
		$this->assertFalse($attrtype->canHaveValue(1));
		$this->assertFalse($attrtype->canHaveValue('somevalue1|somevalue2'));
		$this->assertFalse($attrtype->canHaveValue('somevalue1;somevalue2'));
		$this->assertFalse($attrtype->canHaveValue('somevalue1,somevalue2'));
		$this->assertTrue($attrtype->canHaveValue('somevalue1'));
	}
}
