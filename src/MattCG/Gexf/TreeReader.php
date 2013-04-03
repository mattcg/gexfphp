<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class TreeReader {

	private $inside, $parser;

	public function __construct($uri) {
		$this->parser = new PullParser($uri);
		$this->inside = array();
	}

	public function read() {
		while ($this->parser->read()) {
			$this->readElement();
		}
	}

	private function readElement() {
		$parser = $this->parser;
		switch ($parser->nodeType) {
		case self::ELEMENT:
			$this->startEntity();
			break;

		case self::END_ELEMENT:
			$this->closeEntity();
			break;
		}
	}

	private function startEntity() {
		array_push($this->inside, $parser->name);
	}

	private function closeEntity() {
		$name = array_pop($this->inside);
	}
}
