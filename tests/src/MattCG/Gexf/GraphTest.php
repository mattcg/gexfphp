<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Graph;
use MattCG\Gexf\EdgeType;
use MattCG\Gexf\IdType;
use MattCG\Gexf\Mode;
use MattCG\Gexf\Node;
use MattCG\Gexf\TimeFormat;
use MattCG\Gexf\AttributeClass;

use Rhumsaa\Uuid\Uuid;

class GraphTest extends PHPUnit_Framework_TestCase {

	public function testSetDefaultEdgeType() {
		$graph = new Graph();
		$this->assertNull($graph->getDefaultEdgeType());
		$this->assertFalse($graph->hasDefaultEdgeType());
		$edgetype = new EdgeType();
		$graph->setDefaultEdgeType($edgetype);
		$this->assertTrue($graph->hasDefaultEdgeType());
		$this->assertEquals($edgetype, $graph->getDefaultEdgeType());
		$graph->clearDefaultEdgeType();
		$this->assertNull($graph->getDefaultEdgeType());
		$this->assertFalse($graph->hasDefaultEdgeType());
	}

	public function testSetIdType() {
		$graph = new Graph();
		$this->assertNull($graph->getIdType());
		$this->assertFalse($graph->hasIdType());
		$idtype = new IdType();
		$graph->setIdType($idtype);
		$this->assertTrue($graph->hasIdType());
		$this->assertEquals($idtype, $graph->getIdType());
		$graph->clearIdType();
		$this->assertNull($graph->getIdType());
		$this->assertFalse($graph->hasIdType());
	}

	public function testSetMode() {
		$graph = new Graph();
		$this->assertNull($graph->getMode());
		$this->assertFalse($graph->hasMode());
		$mode = new Mode();
		$graph->setMode($mode);
		$this->assertTrue($graph->hasMode());
		$this->assertEquals($mode, $graph->getMode());
		$graph->clearMode();
		$this->assertNull($graph->getMode());
		$this->assertFalse($graph->hasMode());
	}

	public function testSetTimeFormat() {
		$graph = new Graph();
		$this->assertNull($graph->getTimeFormat());
		$this->assertFalse($graph->hasTimeFormat());
		$timeformat = new TimeFormat();
		$graph->setTimeFormat($timeformat);
		$this->assertTrue($graph->hasTimeFormat());
		$this->assertEquals($timeformat, $graph->getTimeFormat());
		$graph->clearTimeFormat();
		$this->assertNull($graph->getTimeFormat());
		$this->assertFalse($graph->hasTimeFormat());
	}

	public function testCreateNode() {
		$id = 1;
		$graph = new Graph();
		$this->assertNull($graph->getNode($id));
		$this->assertEmpty($graph->getNodes());
		$node = $graph->createNode($id);
		$this->assertEquals($id, $node->getId());
		$this->assertEquals($node, $graph->getNode($id));
		$nodes = $graph->getNodes();
		$this->assertEquals($node, $nodes[$id]);
		$node = $graph->createNode();
		try {
			$uuid = Uuid::fromString($node->getId());
		} catch (\InvalidArgumentException $e) {
			$this->fail('ID should be valid UUID.');
		}
	}

	public function testGetAttributeList() {
		$graph = new Graph();
		$attrclass = new AttributeClass(AttributeClass::CLASS_EDGE);
		$attrlist = $graph->getAttributeList($attrclass);
		$this->assertEquals($attrclass, $attrlist->getAttributeClass());
		$this->assertEquals($attrlist, $graph->getAttributeList($attrclass));
		$attrlist = $graph->getAttributeList();
		$this->assertEquals(AttributeClass::CLASS_NODE, (string) $attrlist->getAttributeClass());
		$attrclass = new AttributeClass(AttributeClass::CLASS_NODE);
		$this->assertEquals($attrlist, $graph->getAttributeList($attrclass));
	}

	public function testGetAllEdges() {
		$graph = new Graph();
		$id1 = 1;
		$id2 = 2;
		$edgeid = 1;
		$node1 = $graph->createNode($id1);
		$node1->connectTo(new Node($id2), $edgeid);
		$edges = $graph->getAllEdges();
		$this->assertEquals(1, count($edges));
		$this->assertTrue(isset($edges[$edgeid]));
		$this->assertEquals($edgeid, $edges[$edgeid]->getId());
	}
}
