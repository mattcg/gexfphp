<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

use MattCG\Gexf\Metadata;

class MetadataTest extends PHPUnit_Framework_TestCase {

	public function testSetCreator() {
		$creator = 'x';
		$metadata= new Metadata();
		$this->assertNull($metadata->getCreator());
		$this->assertFalse($metadata->hasCreator());
		$metadata->setCreator($creator);
		$this->assertEquals($creator, $metadata->getCreator());
		$this->assertTrue($metadata->hasCreator());
		$metadata->clearCreator();
		$this->assertNull($metadata->getCreator());
		$this->assertFalse($metadata->hasCreator());
	}

	public function testSetDescription() {
		$description = 'x';
		$metadata= new Metadata();
		$this->assertNull($metadata->getDescription());
		$this->assertFalse($metadata->hasDescription());
		$metadata->setDescription($description);
		$this->assertEquals($description, $metadata->getDescription());
		$this->assertTrue($metadata->hasDescription());
		$metadata->clearDescription();
		$this->assertNull($metadata->getDescription());
		$this->assertFalse($metadata->hasDescription());
	}

	public function testSetLastModified() {
		$lastmod = new DateTime();
		$metadata= new Metadata();
		$this->assertNull($metadata->getLastModified());
		$this->assertFalse($metadata->hasLastModified());
		$metadata->setLastModified($lastmod);
		$this->assertEquals($lastmod, $metadata->getLastModified());
		$this->assertTrue($metadata->hasLastModified());
		$metadata->clearLastModified();
		$this->assertNull($metadata->getLastModified());
		$this->assertFalse($metadata->hasLastModified());
	}

	public function testSetKeywords() {
		$keywords = array('hi', 'bye');
		$metadata= new Metadata();
		$this->assertEmpty($metadata->getKeywords());
		$this->assertFalse($metadata->hasKeywords());
		$metadata->setKeywords($keywords);
		$this->assertEquals($keywords, $metadata->getKeywords());
		$this->assertTrue($metadata->hasKeywords());
		$metadata->clearKeywords();
		$this->assertEmpty($metadata->getKeywords());
		$this->assertFalse($metadata->hasKeywords());
	}

	public function testIsEmpty() {
		$metadata = new Metadata();
		$this->assertTrue($metadata->isEmpty());
		$metadata->setCreator('x');
		$this->assertFalse($metadata->isEmpty());
	}
}
