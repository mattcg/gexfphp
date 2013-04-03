<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class PullParser extends \XMLReader {

	public $object;
	private $inside;

	public function __construct($uri) {
		$this->inside = array();
		$this->open($uri);
		$this->setParserProperty(self::SUBST_ENTITIES, true);
	}

	public function read() {
		if (parent::read()) {
			switch ($this->nodeType) {
			case self::ELEMENT:
				array_push($this->inside, $this->name);
				$this->object = $this->readElement();
				return true;

			case self::END_ELEMENT:
				array_pop($this->inside);
				break;
			}
		}

		return false;
	}

	private function readGexfElement() {
		return new Gexf();
	}

	private function readGraphElement() {
		$graph = new Graph();
		while ($this->moveToNextAttribute()) {
			switch ($this->name) {
			case 'timeformat':
				$graph->setTimeFormat(new TimeFormat($this->value));
				break;
			case 'defaultedgetype':
				$graph->setDefaultEdgeType(new EdgeType($this->value));
				break;
			case 'idtype':
				$graph->setIdType(new IdType($this->value));
				break;
			case 'mode':
				$graph->setMode(new Mode($this->value));
				break;
			}
		}

		return $graph;
	}

	private function readElement() {
		switch ($this->name) {
		case 'gexf':
			return $this->readGexfElement();

		case 'graph':
			return $this->readGraphElement();

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
