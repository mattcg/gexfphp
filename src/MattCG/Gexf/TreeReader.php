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

	private function readObject() {
		$parser = $this->parser;

		switch ($parser->name) {
		case 'gexf':
			return $this->gexf = $parser->object;

		case 'graph':
			return $this->readGraph();

		case 'meta':
			return $this->readMetadata();
			break;

		case 'attributes':
			return $this->readAttributes();

		case 'nodes':

			// Will return the first node
			return $this->readNodes();
		case 'node':
			return $this->readNode();
		}
	}
}
