<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Mode;

class ModeTest extends PHPUnit_Framework_TestCase {

	public function testDefaultModeIsStatic() {
		$mode = new Mode();
		$this->assertEquals(Mode::MODE_STATIC, (string) $mode);
	}
}
