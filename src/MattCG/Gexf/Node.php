<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

use Rhumsaa\Uuid\Uuid;
use Primal\Color\Color;

class Node {

	private $id, $label, $color, $pid, $position, $shape, $size, $nodes, $edges;

	public function __construct($id) {
		if (!is_string($id) and !is_int($id)) {
			throw new \InvalidArgumentException('Node ID may only be string or integer.');
		}

		if (is_string($id)) {
			$id = trim($id);
			if (empty($id)) {
				throw new \InvalidArgumentException('Node ID may not be empty.');
			}
		}

		$this->id = $id;
		$this->edges = array();
		$this->nodes = array();
	}

	public function clearColor() {
		$this->color = null;
	}

	public function clearLabel() {
		$this->label = null;
	}

	public function clearPid() {
		$this->pid = null;
	}

	public function clearPosition() {
		$this->position = null;
	}

	public function clearShape() {
		$this->shape = null;
	}

	public function clearSize() {
		$this->size = null;
	}

	public function connectTo(Node $target, $id = null) {
		if (is_null($id)) {
			$id = Uuid::uuid4()->toString();
		}

		if ($this->hasEdgeTo($target->getId())) {
			throw new \InvalidArgumentException('Edge already exists.');
		}

		$edge = new Edge($id, $this, $target);
		$this->edges[$id] = $edge;
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
		$edges = $this->getEdges();
		$nodes = $this->getNodes();
		foreach ($nodes as $node) {
			$this->getEdgesRecursive($edges, $node);
		}

		return $edges;
	}

	private function getEdgesRecursive(array &$sofar, Node $node) {
		$edges = $node->getEdges();
		foreach ($edges as $edge) {
			$sofar[$edge->getId()] = $edge;
		}

		$nodes = $node->getNodes();
		foreach ($nodes as $node) {
			$this->getEdgesRecursive($sofar, $node);
		}
	}

	public function getEdges() {
		return $this->edges;
	}

	public function getColor() {
		return $this->color;
	}

	public function getId() {
		return $this->id;
	}

	public function getLabel() {
		return $this->label;
	}

	public function getNodes() {
		return $this->nodes;
	}

	public function getNode($id) {
		if (isset($this->nodes[$id])) {
			return $this->nodes[$id];
		}
	}

	public function getPid() {
		return $this->pid;
	}

	public function getPosition() {
		return $this->position;
	}

	public function getShape() {
		return $this->shape;
	}

	public function getSize() {
		return $this->size;
	}

	public function hasColor() {
		return !is_null($this->color);
	}

	public function hasLabel() {
		return !is_null($this->label);
	}

	public function hasPid() {
		return !is_null($this->pid);
	}

	public function hasPosition() {
		return !is_null($this->position);
	}

	public function hasShape() {
		return !is_null($this->shape);
	}

	public function hasSize() {
		return !is_null($this->size);
	}

	public function hasEdgeTo($id) {
		if (is_null($id)) {
			throw new \InvalidArgumentException('ID cannot be null.');
		}

		if (!is_string($id) and !is_int($id)) {
			throw new \InvalidArgumentException('ID must be string or integer.');
		}

		$edges = $this->edges;
		foreach ($edges as $edge) {
			if ($edge->getTarget()->getId() == $id) {
				return true;
			}
		}

		return false;
	}

	public function setColor(Color $color) {
		$this->color = $color;
	}

	public function setLabel($label) {
		if (!is_string($label)) {
			throw new \InvalidArgumentException();
		}

		$this->label = $label;
	}

	public function setPid($pid) {
		$this->pid = $pid;
	}

	public function setPosition(Position $position) {
		$this->position = $position;
	}

	public function setShape(NodeShape $shape) {
		$this->shape = $shape;
	}

	public function setSize($size) {
		if (!is_float($size)) {
			throw new \InvalidArgumentException();
		}

		$this->size = $size;
	}
}
