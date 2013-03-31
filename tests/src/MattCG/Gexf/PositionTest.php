<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Position;

class PositionTest extends PHPUnit_Framework_TestCase {

	public function testDefaultCoordinatesAreZero() {
		$position = new Position();
		$this->assertEquals(0.0, $position->getX());
		$this->assertEquals(0.0, $position->getY());
		$this->assertEquals(0.0, $position->getZ());
	}

	public function testInitialization() {
		$x = 1.1;
		$y = 1.2;
		$z = 1.3;
		$position = new Position($x, $y, $z);
		$this->assertEquals($x, $position->getX());
		$this->assertEquals($y, $position->getY());
		$this->assertEquals($z, $position->getZ());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNonFloatIsRejectedForX() {
		$x = 1;
		$y = 1.2;
		$z = 1.3;
		$position = new Position($x, $y, $z);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNonFloatIsRejectedForY() {
		$x = 1.1;
		$y = 1;
		$z = 1.3;
		$position = new Position($x, $y, $z);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNonFloatIsRejectedForZ() {
		$x = 1.1;
		$y = 1.2;
		$z = 1;
		$position = new Position($x, $y, $z);
	}
}
