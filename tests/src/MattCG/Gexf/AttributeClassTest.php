<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\AttributeClass;

class AttributeClassTest extends PHPUnit_Framework_TestCase {

	public function testDefaultClassIsNode() {
		$attrclass = new AttributeClass();
		$this->assertEquals(AttributeClass::CLASS_NODE, (string) $attrclass);
	}
}
