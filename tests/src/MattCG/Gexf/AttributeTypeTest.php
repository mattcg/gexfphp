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
}
