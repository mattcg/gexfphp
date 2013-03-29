<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\EdgeShape;

class EdgeShapeTest extends PHPUnit_Framework_TestCase {

	public function testDefaultShapeIsSolid() {
		$edgeshape = new EdgeShape();
		$this->assertTrue(EdgeShape::SHAPE_SOLID == $edgeshape);
		$this->assertFalse(EdgeShape::SHAPE_SOLID === $edgeshape);
		$this->assertEquals(EdgeShape::SHAPE_SOLID, (string) $edgeshape);
	}
}
