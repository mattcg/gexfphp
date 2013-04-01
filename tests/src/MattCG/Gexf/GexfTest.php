<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Gexf;

class GexfTest extends PHPUnit_Framework_TestCase {

	public function testGraphIsInitialized() {
		$gexf = new Gexf();
		$this->assertInstanceOf('MattCG\Gexf\Graph', $gexf->getGraph());
	}

	public function hasMetadata() {
		$gexf = new Gexf();
		$this->assertFalse($gexf->hasMetadata());
	}

	public function testGetVersion() {
		$gexf = new Gexf();
		$this->assertEquals('1.2', $gexf->getVersion());
	}

	public function testSetVisualization() {
		$gexf = new Gexf();
		$this->assertFalse($gexf->hasVisualization());
		$this->assertFalse($gexf->getVisualization());
		$gexf->setVisualization(true);
		$this->assertTrue($gexf->hasVisualization());
		$this->assertTrue($gexf->getVisualization());
	}
}
