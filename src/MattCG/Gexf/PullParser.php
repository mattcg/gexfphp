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
			return $this->readElement();
		}

		return false;
	}

	private function readElement() {
		do {
			$handled = $this->switchElement();
			if ($handled) {
				return true;
			}

		// Skip to the next element unless the end of the document has been reached.
		} while ($this->next());
	}

	private function switchElement() {
		switch ($this->name) {
		case 'gexf':
		case 'graph':
		case 'meta':
		case 'content':
		case 'description':
		case 'keywords':
		case 'attributes':
		case 'attribute':
		case 'nodes':
		case 'node':
		case 'edges':
		case 'edge':
			true;
		}
	}

	private function readGexf() {
		return new Gexf();
	}

	private function readGraph() {
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

	private function readMetadata() {
		$metadata = new Metadata();

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

		// Nothing else to do for empty <meta />.
		if ($this->isEmptyElement) {
			return $metadata;
		}

		$metadepth = $this->depth;
		$skipped = false;
		while ($skipped or parent::read()) {
			if ($skipped) {
				$skipped = false;
			}

			if (self::END_ELEMENT === $this->nodeType) {

				// Return the object when <meta> should be closed.
				if ('meta' === $this->name) {
					return $metadata;
				}

				continue;
			}

			if (self::ELEMENT !== $this->nodeType) {

				// Non-elements below <meta> are unimporant.
				continue;
			}

			// Sanity check - should stay below <meta> element depth.
			assert($this->depth < $metadepth);

			if ($this->isEmptyElement) {

				// Empty elements below <meta> are unimporant.
				continue;
			}

			switch ($this->name) {
			default:

				// Default case: for an unhandled element below <meta>, jump to the next element, skipping the subtree of the current element.
				$skipped = true;
				$this->next();
				break;

			case 'creator':
				$metadata->setCreator($this->value);
				break;

			case 'keywords':
				$metadata->setKeywords(explode(', ', $this->value));
				break;

			case 'description':
				$metadata->setDescription($this->value);
				break;
			}
		}
	}

	private function readAttributes() {
		$class = $this->getAttribute('class');
		$attrlist = new AttributeList(new AttributeClass($class));

		$mode = $this->getAttribute('mode');
		if ($mode) {
			$attrlist->setMode(new Mode($mode));
		}

		// Nothing else to do for empty <attributes />.
		if ($this->isEmptyElement) {
			return $attrlist;
		}

		$attributesdepth = $this->depth;
		$skipped = false;
		while ($skipped or parent::read()) {
			if ($skipped) {
				$skipped = false;
			}

			if (self::END_ELEMENT === $this->nodeType) {

				// Return the object when <attributes> should be closed.
				if ('attributes' === $this->name) {
					return $attrlist;
				}

				continue;
			}

			if (self::ELEMENT !== $this->nodeType) {

				// Non-elements below <attributes> are unimporant.
				continue;
			}

			// Sanity check - should stay below <attributes> element depth.
			assert($this->depth < $attributesdepth);
	
			if ('attribute' === $this->name) {
				$this->readAttribute($attrlist);
			} else {

				// For an unhandled element below <attributes>, jump to the next element, skipping the subtree of the current element.
				$skipped = true;
				$this->next();
			}
		}
	}

	private function readAttribute(AttributeList $attrlist) {
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

		// Nothing else to do for empty <attribute />.
		if ($this->isEmptyElement) {
			return;
		}

		$attr = $attrlist[$id];

		$attrdepth = $this->depth;
		$skipped = false;
		while ($skipped or parent::read()) {
			if ($skipped) {
				$skipped = false;
			}

			if (self::END_ELEMENT === $this->nodeType) {

				// Return when <attribute> should be closed.
				if ('attribute' === $this->name) {
					return;
				}

				continue;
			}

			if (self::ELEMENT !== $this->nodeType) {

				// Non-elements below <attribute> are unimporant.
				continue;
			}

			// Sanity check - should stay below <attribute> element depth.
			assert($this->depth < $attrdepth);

			if ($this->isEmptyElement) {

				// Empty elements below <attribute> are unimporant.
				continue;
			}

			switch ($this->name) {
			default:

				// Default case: for an unhandled element below <attribute>, jump to the next element, skipping the subtree of the current element.
				$skipped = true;
				$this->next();
				break;

			case 'default':
				$attr->setDefaultValue($attrtype->convertToType($this->value));
				break;

			case 'options':
				$attr->setOptions(AttributeType::parseListString($this->value));
				break;
			}
		}
	}

	private function readNodes(Node $node = null) {
		$count = $this->gettAttribute('count');
		if ($count !== null) {
			$count = (int) $count;
		}

		// Nothing else to do for empty <nodes />.
		if ($count === 0 or $this->isEmptyElement) {
			return;
		}

		$nodesdepth = $this->depth;
		$skipped = false;
		parent::read();
		do {
			if ($skipped) {
				$skipped = false;
			}

			if (self::ELEMENT !== $this->nodeType) {

				// Return when <nodes> should be closed.
				if (self::END_ELEMENT === $this->nodeType and 'nodes' === $this->name) {
					return;
				}

				// Non-elements below <nodes> are unimporant.
				$skipped = true;
				$this->next();
				continue;
			}

			// Sanity check - should stay below <nodes> element depth.
			assert($this->depth < $nodesdepth);

			if ('node' !== $this->name) {

				// Default case: for an unhandled element below <attribute>, jump to the next element, skipping the subtree of the current element.
				$skipped = true;
				$this->next();
			} else {
				return $this->readNode();
			}
		} while ($skipped);
	}

	private function readNode() {
		$id = $this->getAttribute('id');
		$node = new Node($id);

		$label = $this->getAttribute('label');
		if ($label) {
			$node->setLabel($label);
		}

		$pid = end($this->nodeLevels);
		if ($pid) {
			$node->setPid($pid);
		}

		// Dive into the node.
		array_push($this->nodeLevels, $id);

		return $node;
	}
}
