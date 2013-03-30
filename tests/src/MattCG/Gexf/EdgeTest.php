<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Edge;
use MattCG\Gexf\Node;
use MattCG\Gexf\EdgeType;
use MattCG\Gexf\EdgeShape;

use Primal\Color\RGBColor;

class EdgeTest extends PHPUnit_Framework_TestCase {

	public function testEdgeIdMayBeInteger() {
		$id = 1;
		$edge = new Edge($id, new Node(1), new Node(2));
		$this->assertEquals($id, $edge->getId());
	}

	public function testEdgeIdMayBeString() {
		$id = 'someid';
		$edge = new Edge($id, new Node(1), new Node(2));
		$this->assertEquals($id, $edge->getId());
	}

	public function testEdgeIdIsTrimmed() {
		$edge = new Edge('a ', new Node(1), new Node(2));
		$this->assertEquals('a', $edge->getId());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEdgeIdMayNotBeEmptyString() {
		$edge = new Edge('  ', new Node(1), new Node(2));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEdgeIdMayNotBeFloat() {
		$edge = new Edge(1.1, new Node(1), new Node(2));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEdgeIdMayNotBeBoolean() {
		$edge = new Edge(true, new Node(1), new Node(2));
	}

	public function testSetLabel() {
		$label = 'somelabel';
		$edge = new Edge(1, new Node(1), new Node(2));
		$edge->setLabel($label);
		$this->assertEquals($label, $edge->getLabel());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetLabelRejectsNull() {
		$edge = new Edge(1, new Node(1), new Node(2));
		$edge->setLabel(null);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSetLabelRejectsNonString() {
		$edge = new Edge(1, new Node(1), new Node(2));
		$edge->setLabel(1);
	}

	public function testSetEdgeType() {
		$edge = new Edge(1, new Node(1), new Node(2));
		$edgetype = new EdgeType();
		$edge->setEdgeType($edgetype);
		$this->assertEquals($edgetype, $edge->getEdgeType());
	}

	public function testSetEdgeShape() {
		$edge = new Edge(1, new Node(1), new Node(2));
		$edgeshape = new EdgeShape();
		$edge->setShape($edgeshape);
		$this->assertEquals($edgeshape, $edge->getShape());
	}

	public function testSetTarget() {
		$edge = new Edge(1, new Node(1), new Node(2));
		$target = new Node(3);
		$edge->setTarget($target);
		$this->assertEquals($target, $edge->getTarget());
	}

	public function testSetColor() {
		$edge = new Edge(1, new Node(1), new Node(2));
		$color = new RGBColor(1, 2, 3);
		$edge->setColor($color);
		$this->assertEquals($color, $edge->getColor());
	}
}
