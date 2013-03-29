<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Attribute;
use MattCG\Gexf\AttributeValue;
use MattCG\Gexf\AttributeType;
use MattCG\Gexf\AttributeValueList;

class AttributeValueListTest extends PHPUnit_Framework_TestCase {

	public function testAddValue() {
		$id = 'someid';
		$value = 'somevalue';
		$attr = new Attribute($id, new AttributeType());
		$attrvaluelist = new AttributeValueList();
		$this->assertEquals(0, count($attrvaluelist));
		$this->assertFalse(isset($attrvaluelist[$id]));
		$attrvaluelist->addValue($attr, $value);
		$this->assertEquals(1, count($attrvaluelist));
		$this->assertTrue(isset($attrvaluelist[$id]));
		$attrvalue = $attrvaluelist[$id];
		$this->assertInstanceOf('MattCG\Gexf\AttributeValue', $attrvalue);
		$this->assertEquals($value, $attrvalue->getValue());
	}

	public function testValueIsOptional() {
		$attr = new Attribute('someid', new AttributeType());
		$attrvaluelist = new AttributeValueList();
		$attrvaluelist->addValue($attr);
		$attrvalue = $attrvaluelist->current();
		$this->assertNull($attrvalue->getValue());
	}

	public function testCreateValueReturnsValue() {
		$attr = new Attribute('someid', new AttributeType());
		$attrvaluelist = new AttributeValueList();
		$attrvalue = $attrvaluelist->createValue($attr);
		$this->assertInstanceOf('MattCG\Gexf\AttributeValue', $attrvalue);
		$this->assertEquals($attrvaluelist->current(), $attrvalue);
		$this->assertNull($attrvalue->getValue());
	}
}
