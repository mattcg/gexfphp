<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Node;
use MattCG\Gexf\Position;
use MattCG\Gexf\NodeShape;

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
		$this->assertFalse($node->hasColor());
		$this->assertNull($node->getColor());
		$node->setColor($color);
		$this->assertTrue($node->hasColor());
		$this->assertEquals($color, $node->getColor());
		$node->clearColor();
		$this->assertFalse($node->hasColor());
		$this->assertNull($node->getColor());
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

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConnectToThrowsExceptionIfEdgeAlreadyExists() {
		$sourcenode = new Node(1);
		$targetnode = new Node(2);
		$edgeid = 1;
		$sourcenode->connectTo($targetnode, $edgeid);
		$sourcenode->connectTo($targetnode, $edgeid);
	}

	public function testGetAllEdges() {
		$node1 = new Node(1);
		$node1->createNode(2);
		$node4 = new Node(4);
		$node1->connectTo($node4, 1);

		$node2 = $node1->getNode(2);
		$node2->createNode(3);
		$node5 = new Node(5);
		$node2->connectTo($node5, 2);

		$node3 = $node2->getNode(3);
		$node6 = new Node(6);
		$node3->connectTo($node6, 3);

		$i = 1;
		$edges = $node1->getAllEdges();
		foreach ($edges as $id => $edge) {
			$this->assertEquals($id, $edge->getId());
			$this->assertEquals($i, $id);
			$i++;
		}

		$this->assertEquals(3, count($edges));
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

	public function testGetNode() {
		$id1 = 1;
		$id2 = 2;
		$node1 = new Node($id1);
		$node1->createNode($id2);
		$node2 = $node1->getNode($id2);
		$this->assertNotNull($node2);
		$this->assertInstanceOf('MattCG\Gexf\Node', $node2);
		$this->assertEquals($id2, $node2->getId());
	}

	public function testGetNodeReturnsNullForNonexistentNode() {
		$id1 = 1;
		$id2 = 2;
		$node1 = new Node($id1);
		$node1->createNode($id2);
		$this->assertNull($node1->getNode(3));
	}

	public function testSetSize() {
		$node = new Node(1);
		$size = 1.1;
		$this->assertFalse($node->hasSize());
		$this->assertNull($node->getSize());
		$node->setSize($size);
		$this->assertTrue($node->hasSize());
		$this->assertEquals($size, $node->getSize());
		$node->clearSize();
		$this->assertFalse($node->hasSize());
		$this->assertNull($node->getSize());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetSizeRejectsNonFloat() {
		$node = new Node(1);
		$node->setSize(1);
	}

	public function testSetLabel() {
		$node = new Node(1);
		$label = 'Some label.';
		$this->assertFalse($node->hasLabel());
		$this->assertNull($node->getLabel());
		$node->setLabel($label);
		$this->assertTrue($node->hasLabel());
		$this->assertEquals($label, $node->getLabel());
		$node->clearLabel();
		$this->assertFalse($node->hasLabel());
		$this->assertNull($node->getLabel());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetLabelRejectsNonString() {
		$node = new Node(1);
		$node->setLabel(1);
	}

	public function testSetPid() {
		$node = new Node(2);
		$pid = 1;
		$this->assertFalse($node->hasPid());
		$this->assertNull($node->getPid());
		$node->setPid($pid);
		$this->assertTrue($node->hasPid());
		$this->assertEquals($pid, $node->getPid());
		$node->clearPid();
		$this->assertFalse($node->hasPid());
		$this->assertNull($node->getPid());
	}

	public function testSetPosition() {
		$node = new Node(2);
		$position = new Position();
		$this->assertFalse($node->hasPosition());
		$this->assertNull($node->getPosition());
		$node->setPosition($position);
		$this->assertTrue($node->hasPosition());
		$this->assertEquals($position, $node->getPosition());
		$node->clearPosition();
		$this->assertFalse($node->hasPosition());
		$this->assertNull($node->getPosition());
	}

	public function testSetShape() {
		$node = new Node(2);
		$shape = new NodeShape();
		$this->assertFalse($node->hasShape());
		$this->assertNull($node->getShape());
		$node->setShape($shape);
		$this->assertTrue($node->hasShape());
		$this->assertEquals($shape, $node->getShape());
		$node->clearShape();
		$this->assertFalse($node->hasShape());
		$this->assertNull($node->getShape());
	}
}
