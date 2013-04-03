<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class PullParser extends \XMLReader {

	public $entity;

	public function __construct($uri) {
		$this->open($uri);
		$this->setParserProperty(self::SUBST_ENTITIES, true);
	}

	public function read() {
		if (parent::read() and $this->nodeType == self::ELEMENT) {
			$this->entity = $this->readElement();
			return true;
		}

		return false;
	}

	private function readGexfElement() {
		
	}

	private function readElement() {
		switch ($this->name) {
		case 'gexf':
			return $this->readGexfElement();

		case 'graph':
			break;

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
