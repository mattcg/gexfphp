<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

use Rhumsaa\Uuid\Uuid;

class Graph {

	private $edgetype, $attrlists, $idtype, $mode, $nodes, $timeformat;

	public function __construct() {
		$this->nodes = array();
		$this->attrlists = array();
	}

	public function getDefaultEdgeType() {
		return $this->edgetype;
	}

	public function setDefaultEdgeType(EdgeType $edgetype) {
		$this->edgetype = $edgetype;
	}

	public function clearDefaultEdgeType() {
		$this->edgetype = null;
	}

	public function hasDefaultEdgeType() {
		return !is_null($this->edgetype);
	}

	public function getIdType() {
		return $this->idtype;
	}

	public function setIdType(IdType $idtype) {
		$this->idtype = $idtype;
	}

	public function hasIdType() {
		return !is_null($this->idtype);
	}

	public function clearIdType() {
		$this->idtype = null;
	}

	public function getMode() {
		return $this->mode;
	}

	public function setMode(Mode $mode) {
		$this->mode = $mode;
	}

	public function hasMode() {
		return !is_null($this->mode);
	}

	public function clearMode() {
		$this->mode = null;
	}

	public function getTimeFormat() {
		return $this->timeformat;
	}

	public function setTimeFormat(TimeFormat $timeformat) {
		$this->timeformat = $timeformat;
	}

	public function hasTimeFormat() {
		return !is_null($this->timeformat);
	}

	public function clearTimeFormat() {
		$this->timeformat = null;
	}

	public function createNode($id = null) {
		if (is_null($id)) {
			$id = Uuid::uuid4()->toString();
		}

		$node = new Node($id);
		$this->nodes[$id] = $node;
		return $node;
	}

	public function getAllEdges() {
		$edges = array();
		foreach ($this->nodes as $node) {
			$edges = $edges + $node->getAllEdges();
		}

		return $edges;
	}

	public function getNodes() {
		return $this->nodes;
	}

	public function getNode($id) {
		if (isset($this->nodes[$id])) {
			return $this->nodes[$id];
		}
	}

	public function getAttributeList(AttributeClass $attrclass = null) {
		if (is_null($attrclass)) {
			$attrclass = new AttributeClass();
		}

		$attrclass_str = (string) $attrclass;
		if (isset($this->attrlists[$attrclass_str])) {
			return $this->attrlists[$attrclass_str];
		}

		$attrlist = new AttributeList($attrclass);
		$this->attrlists[$attrclass_str] = $attrlist;

		return $attrlist;
	}
}
