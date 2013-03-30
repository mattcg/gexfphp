<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\NodeShape;

class NodeShapeTest extends PHPUnit_Framework_TestCase {

	public function testDefaultShapeIsDisc() {
		$nodeshape = new NodeShape();
		$this->assertTrue(NodeShape::SHAPE_DISC == $nodeshape);
		$this->assertFalse(NodeShape::SHAPE_DISC === $nodeshape);
		$this->assertEquals(NodeShape::SHAPE_DISC, (string) $nodeshape);
	}
}
