<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\EdgeType;

class EdgeTypeTest extends PHPUnit_Framework_TestCase {

	public function testDefaultTypeIsUndirected() {
		$edgetype = new EdgeType();
		$this->assertTrue(EdgeType::TYPE_UNDIRECTED == $edgetype);
		$this->assertFalse(EdgeType::TYPE_UNDIRECTED === $edgetype);
		$this->assertEquals(EdgeType::TYPE_UNDIRECTED, (string) $edgetype);
	}
}
