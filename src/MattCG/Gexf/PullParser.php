<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;
use \XMLReader;

class PullParser {

	public function __construct($uri) {
		$this->reader = new XMLReader();
		$this->reader->open($uri);
	}

	public function read() {
		$reader = $this->reader;

		while ($reader->read()) {
			if ($reader->nodeType == XMLReader::ELEMENT) {
				$this->switchElement();
			}
		}
	}

	private function switchElement() {
		$reader = $this->reader;

		switch ($reader->name) {
		case 'meta':
			break;
		case 'creator':
			break;
		case 'description':
			break;
		case 'keywords':
			break;

		case 'attribute':
			break;
		case 'default':
			break;
		case 'options':
			break;

		case 'nodes':
			break;
		case 'node':
			break;

		case 'attvalues':
			break;
		case 'attvalue':
			break;

		case 'edges':
			break;
		case 'edge':
			break;

		case 'viz:position':
			break;
		case 'viz:size':
			break;
		case 'viz:color':
			break;
		case 'viz:shape':
			break;
		}
	}
}
