<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\IdType;

class IdTypeTest extends PHPUnit_Framework_TestCase {

	public function testDefaultTypeIsString() {
		$idtype = new IdType();
		$this->assertTrue(IdType::TYPE_STRING == $idtype);
		$this->assertFalse(IdType::TYPE_STRING === $idtype);
		$this->assertEquals(IdType::TYPE_STRING, (string) $idtype);
	}
}
