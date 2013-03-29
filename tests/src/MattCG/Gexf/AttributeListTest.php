<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Attribute;
use MattCG\Gexf\AttributeList;
use MattCG\Gexf\AttributeClass;
use MattCG\Gexf\AttributeType;
use MattCG\Gexf\Mode;

use Rhumsaa\Uuid\Uuid;

class AttributeListTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAttributeClassIsRequired() {
		$attrlist = new AttributeList();
	}

	public function testGetAttributeClass() {
		$attrclass = new AttributeClass();
		$attrlist = new AttributeList($attrclass);
		$this->assertEquals($attrclass, $attrlist->getAttributeClass());
	}

	public function testModeIsInitiallyNull() {
		$attrlist = new AttributeList(new AttributeClass());
		$this->assertNull($attrlist->getMode());
	}

	public function testSetMode() {
		$attrlist = new AttributeList(new AttributeClass());
		$mode = new Mode();
		$attrlist->setMode($mode);
		$this->assertEquals($mode, $attrlist->getMode());
	}

	public function testSetAttribute() {
		$id = 'someid';
		$attrlist = new AttributeList(new AttributeClass());
		$attr = new Attribute($id, new AttributeType());
		$this->assertEquals(0, count($attrlist));
		$this->assertFalse(isset($attrlist[$id]));
		$attrlist[$id] = $attr;
		$this->assertEquals(1, count($attrlist));
		$this->assertTrue(isset($attrlist[$id]));
		$this->assertEquals($attr, $attrlist[$id]);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetAttributeOnlyAcceptsAttributeAsValue() {
		$attrlist = new AttributeList(new AttributeClass());
		$attrlist[0] = 0;
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetAttributeOffsetMustBeEqualToId() {
		$attrlist = new AttributeList(new AttributeClass());
		$attr = new Attribute('someid', new AttributeType());
		$attrlist['someotherid'] = $attr;
	}

	public function testAddAttribute() {
		$id = 'someid';
		$title = 'Title';
		$attrtype = new AttributeType(AttributeType::TYPE_INTEGER);
		$attrlist = new AttributeList(new AttributeClass());
		$this->assertFalse(isset($attrlist[$id]));
		$attrlist->addAttribute($id, $attrtype, $title);
		$this->assertTrue(isset($attrlist[$id]));
		$this->assertInstanceOf('MattCG\Gexf\Attribute', $attrlist[$id]);
		$this->assertEquals($id, $attrlist[$id]->getId());
		$this->assertEquals($title, $attrlist[$id]->getTitle());
		$this->assertEquals($attrtype, $attrlist[$id]->getAttributeType());
	}

	public function testCreateAttribute() {
		$attrtype = new AttributeType(AttributeType::TYPE_INTEGER);
		$attrlist = new AttributeList(new AttributeClass());
		$attrlist->createAttribute($attrtype);
		$attr = $attrlist->current();
		$this->assertInstanceOf('MattCG\Gexf\Attribute', $attr);
		$this->assertEquals($attr, $attrlist[$attr->getId()]);

		try {
			$uuid = Uuid::fromString($attr->getId());
		} catch (\InvalidArgumentException $e) {
			$this->fail('ID should be valid UUID.');
		}
	}

	public function testCreateAttributeReturnsAttribute() {
		$attrtype = new AttributeType(AttributeType::TYPE_INTEGER);
		$attrlist = new AttributeList(new AttributeClass());
		$attr = $attrlist->createAttribute($attrtype);
		$this->assertInstanceOf('MattCG\Gexf\Attribute', $attr);
	}
}
