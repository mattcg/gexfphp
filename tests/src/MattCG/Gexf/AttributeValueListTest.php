<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Attribute;
use MattCG\Gexf\AttributeList;
use MattCG\Gexf\AttributeValue;
use MattCG\Gexf\AttributeType;
use MattCG\Gexf\AttributeClass;
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

	public function testSetValue() {
		$id = 'someid';
		$attr = new Attribute($id, new AttributeType());
		$attrvaluelist = new AttributeValueList();
		$attrvalue = new AttributeValue($attr);
		$attrvaluelist[$id] = $attrvalue;
		$this->assertTrue(isset($attrvaluelist[$id]));
		$this->assertEquals($attrvalue, $attrvaluelist[$id]);
		unset($attrvaluelist[$id]);
		$this->assertFalse(isset($attrvaluelist[$id]));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetValueOnlyAcceptsAttributeValue() {
		$attrvaluelist = new AttributeValueList();
		$attrvaluelist['someid'] = 'somevalue';
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetValueValidatesId() {
		$attr = new Attribute('someid', new AttributeType());
		$attrvaluelist = new AttributeValueList();
		$attrvalue = new AttributeValue($attr);
		$attrvaluelist['someotherid'] = $attrvalue;
	}

	public function testIteration() {
		$ids = array('someid1', 'someid2', 'someid3');
		$attrtype = new AttributeType(AttributeType::TYPE_INTEGER);
		$attrlist = new AttributeList(new AttributeClass());
		$attrvaluelist = new AttributeValueList();
		foreach ($ids as $id) {
			$attrlist->addAttribute($id, $attrtype);
		}

		foreach ($attrlist as $id => $attr) {
			$attrvaluelist->addValue($attr);
			$this->assertTrue(isset($attrvaluelist[$id]));
			$attrvalue = $attrvaluelist[$id];
			$this->assertInstanceOf('MattCG\Gexf\AttributeValue', $attrvalue);
			$this->assertEquals($attr, $attrvalue->getAttribute());
		}

		$this->assertEquals(count($ids), count($attrvaluelist));

		$i = 0;
		foreach ($attrvaluelist as $id => $attrvalue) {
			$this->assertEquals($ids[$i], $id);
			$this->assertEquals($id, $attrvalue->getAttribute()->getId());
			$i++;
		}

		$this->assertEquals(count($ids), $i);
	}
}
