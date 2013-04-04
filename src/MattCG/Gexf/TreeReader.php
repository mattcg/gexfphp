<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class TreeReader {

	private $gexf, $parser, $attrlist, $attr, $nodes, $node;

	public function __construct($uri) {
		$this->parser = new PullParser($uri);
		$this->gexf = new Gexf();
		$this->nodes = array();
	}

	public function read() {
		while ($this->readElement()) {
			continue;
		}
	}

	private function readElement() {
		$parser = $this->parser;

		if (!$parser->readElement()) {
			return false;
		}

		$parentname = end($parser->inside);
		switch ($parentname) {
		case 'gexf':
			$this->readGexfChild();
			break;

		case 'meta':
			$this->readMetaChild();
			break;

		case 'graph':

			// Reset references after moving back to graph.
			$this->attr = null;
			$this->attrlist = null;
			$this->node = null;
			$this->nodes = null;

			$this->readGraphChild();
			break;

		case 'attributes':
			$this->readAttribute();
			break;

		case 'attribute':
			$this->readAttributeChild();
			break;

		case 'nodes':
			$this->readNode();
			break;

		case 'attvalues':
			$this->readAttvalue();

		case 'edges':
			$this->readEdge();
		}

		return true;
	}

	private function readGexfChild() {
		$gexf = $this->gexf;
		$parser = $this->parser;

		switch ($parser->name) {
		case 'graph':
			$parser->readAttributesIntoGraph($gexf->getGraph());
			break;

		case 'meta':
			$parser->readAttributesIntoMetadata($gexf->getMetadata());
			break;
		}
	}

	private function readMetaChild() {
		$metadata = $this->gexf->getMetadata();
		$parser = $this->parser;

		switch ($parser->name) {
		case 'keywords':
			$metadata->setKeywords(explode(', ', $parser->value));
			break;

		case 'description':
			$metadata->setDescription($parser->value);
			break;

		case 'creator':
			$metadata->setCreator($parser->value);
			break;
		}
	}

	private function readGraphChild() {
		$graph = $this->gexf->getGraph();
		$parser = $this->parser;

		if ('attributes' === $parser->name) {
			$attrlist = $parser->readAttributesIntoAttributeList($graph);
			$this->attrlist = $attrlist;
		}
	}

	private function readAttribute() {
		$parser = $this->parser;

		$attr = $parser->readAttributesIntoAttribute($this->attrlist);
		$this->attr = $attr;
	}

	private function readAttributeChild() {
		$attr = $this->attr;
		$parser = $this->parser;

		switch ($parser->name) {
		case 'options':
			$attr->setOptions(AttributeType::parseListString($parser->value));
			break;
		case 'default':
			$attrtype = $attr->getAttributeType();
			$attr->setDefaultValue($attrtype->convertToType($parser->value));
			break;
		}
	}

	private function readNode() {
		$parser = $this->parser;

		$depth = $parser->depth;
		$parentdepth = $depth - 2;

		if (isset($this->nodes[$parentdepth])) {
			$parentnode = $this->nodes[$parentdepth];
		}

		$node = $parser->readAttributesIntoNode($parentnode);
		$this->nodes[$depth] = $node;
		$this->node = $node;
	}

	private function readAttvalue() {
		$parser = $this->parser;

		$node = $this->node;
		$attrvaluelist = $node->getAttributeValueList();
		$parser->readAttributesIntoAttributeValue($attrvaluelist);
	}

	private function readEdge() {

	}
}
