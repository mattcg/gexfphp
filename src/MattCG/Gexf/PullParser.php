<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class PullParser extends \XMLReader {

	public $inside;

	public function __construct($uri) {
		$this->inside = array();
		$this->open($uri);
		$this->setParserProperty(self::SUBST_ENTITIES, true);
	}

	public function readElement() {

		// Exit early if there's nothing to read.
		if (!$this->read()) {
			return false;
		}

		do {
			$handled = $this->switchElement();
			if ($handled) {
				return true;
			}

		// Skip to the next element unless the end of the document has been reached.
		} while ($this->next());

		// Return false if there's nothing to read.
		return false;
	}

	private function switchElement() {
		$parent = end($this->inside);
		$child = $this->name;

		switch ($this->nodeType) {
		case self::ELEMENT:
			if (!$this->isHandled($parent, $child)) {
				return false;
			}

			if (!$this->isEmptyElement) {
				array_push($this->inside, $child);
			}

			return true;

		case self::END_ELEMENT:
			assert($parent === $child);
			array_pop($this->inside);
			return false;
		}
	}

	private function isHandled($parent, $child) {
		switch ($parent) {
		case 'gexf':
			switch ($child) {
			case 'graph':
			case 'meta':
				return !$this->isEmptyElement;
			}

			return false;

		case 'graph':
			switch ($child) {
			case 'nodes':
			case 'edges':
			case 'attributes':
				return !$this->isEmptyElement;
			}

			return false;

		case 'meta':
			switch ($child) {
			case 'content':
			case 'description':
			case 'keywords':
				return !$this->isEmptyElement;
			}

			return false;

		case 'attributes':
			switch ($child) {
			case 'attribute':
				return true;
			}

			return false;

		case 'attribute':
			switch ($child) {
			case 'options':
			case 'default':
				return !$this->isEmptyElement;
			}

			return false;

		case 'nodes':
			return 'node' === $child;

		case 'node':
			switch ($child) {
			case 'nodes':
			case 'attvalues':
				return !$this->isEmptyElement;
			case 'viz:color':
			case 'viz:position':
			case 'viz:size':
			case 'viz:shape':
				return true;
			}

			return false;

		case 'attvalues':
			return 'attvalue' === $child;

		case 'edges':
			return 'edge' === $child;

		case 'edge':
			switch ($child) {
			case 'viz:color':
			case 'viz:thickness':
			case 'viz:shape':
				return true;
			}

			return false;

		default:
			return false;
		}
	}

	public function readAttributesIntoGraph(Graph $graph) {
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
	}

	public function readAttributesIntoMetadata(Metadata $metadata) {

		// Read the last modified date attribute.
		$lastmodifieddate = $this->getAttribute('lastmodifieddate');
		if ($lastmodifieddate !== null) {
			$lastmodifiedtime = strtotime($this->value);
			if (false === $lastmodifiedtime or -1 === $lastmodifiedtime) {
				trigger_error('Unable to parse last modified date ("' . $this->value . '").', E_USER_NOTICE);
			} else {
				$metadata->setLastModified(new \DateTime($lastmodifiedtime));
			}
		}
	}

	public function readAttributesIntoAttributeList(Graph $graph) {
		$attrclass = new AttributeClass($this->getAttribute('class'));

		$attrlist = $graph->createAttributeList($attrclass);

		$mode = $this->getAttribute('mode');
		if ($mode) {
			$attrlist->setMode(new Mode($mode));
		}

		return $attrlist;
	}

	public function readAttributesIntoAttribute(AttributeList $attrlist) {
		$id = $attrtype = $title = null;

		while ($this->moveToNextAttribute()) {
			switch ($this->name) {
			case 'id':
				$id = $this->value;
				break;
			case 'type':
				$attrtype = new AttributeType($this->value);
				break;
			case 'title':
				$title = $this->value;
				break;
			}
		}

		if (is_null($id)) {
			trigger_error('Attribute requires ID.', E_USER_NOTICE);
			return;
		}

		if (is_null($attrtype)) {

			// Use default attribute type.
			$attrtype = new AttributeType();
		}

		$attrlist->addAttribute($id, $attrtype, $title);
		return $attrlist[$id];
	}

	public function readAttributesIntoNode(Node $parentnode = null) {
		$id = $this->getAttribute('id');
		if ($parentnode) {
			$node = $parentnode->createNode($id);
		} else {
			$node = new Node($id);
		}

		$label = $this->getAttribute('label');
		if ($label) {
			$node->setLabel($label);
		}

		return $node;
	}

	public function readAttributesIntoAttributeValue(AttributeList $attrlist, AttributeValueList $attrvaluelist) {
		$id = $this->getAttribute('for');
		if (!isset($attrlist[$id])) {
			trigger_error('Unknown attribute ID.', E_USER_NOTICE);
			$this->next();
			return;
		}

		$attr = $attrlist[$id];
		$attrvaluelist->createValue($attr, $this->getAttribute('value'));
	}

	public function readAttributesIntoEdge() {

	}
}
