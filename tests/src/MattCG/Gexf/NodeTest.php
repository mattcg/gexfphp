<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Node;

use Primal\Color\RGBColor;
use Rhumsaa\Uuid\Uuid;

class NodeTest extends PHPUnit_Framework_TestCase {

	public function testNodeIdMayBeInteger() {
		$id = 1;
		$node = new Node($id);
		$this->assertEquals($id, $node->getId());
	}

	public function testNodeIdMayBeString() {
		$id = 'someid';
		$node = new Node($id);
		$this->assertEquals($id, $node->getId());
	}

	public function testNodeIdIsTrimmed() {
		$node = new Node('a ');
		$this->assertEquals('a', $node->getId());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNodeIdMayNotBeEmptyString() {
		$node = new Node('  ');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNodeIdMayNotBeFloat() {
		$node = new Node(1.1);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNodeIdMayNotBeBoolean() {
		$node = new Node(true);
	}

	public function testSetColor() {
		$node = new Node(1);
		$color = new RGBColor(1, 2, 3);
		$node->setColor($color);
		$this->assertEquals($color, $node->getColor());
	}

	public function testCreateNode() {
		$node = new Node(1);
		$id = 2;
		$node->createNode($id);
		$nodes = $node->getNodes();
		$this->assertTrue(isset($nodes[$id]));
		$this->assertEquals($id, $nodes[$id]->getId());

		$node = $node->createNode();
		try {
			$uuid = Uuid::fromString($node->getId());
		} catch (\InvalidArgumentException $e) {
			$this->fail('ID should be valid UUID.');
		}
	}

	public function testConnectTo() {
		$sourcenode = new Node(1);
		$targetnode = new Node(2);
		$edgeid = 1;
		$sourcenode->connectTo($targetnode, $edgeid);
		$edges = $sourcenode->getEdges();
		$this->assertTrue(isset($edges[$edgeid]));
		$edge = $edges[$edgeid];
		$this->assertEquals($sourcenode, $edge->getSource());
		$this->assertEquals($targetnode, $edge->getTarget());
	}

	public function testHasEdgeTo() {
		$sourcenode = new Node(1);
		$targetnode = new Node(2);
		$sourcenode->connectTo($targetnode);
		$this->assertTrue($sourcenode->hasEdgeTo($targetnode->getId()));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testHasEdgeToRejectsNode() {
		$sourcenode = new Node(1);
		$targetnode = new Node(2);
		$sourcenode->connectTo($targetnode);
		$sourcenode->hasEdgeTo($targetnode);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testHasEdgeToRejectsNull() {
		$sourcenode = new Node(1);
		$targetnode = new Node(2);
		$sourcenode->connectTo($targetnode);
		$sourcenode->hasEdgeTo(null);
	}
}
