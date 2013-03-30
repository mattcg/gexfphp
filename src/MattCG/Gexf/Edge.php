<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

use Primal\Color\Color;

class Edge {

	private $color, $label, $thickness, $weight, $edgetype, $id, $source, $target;

	public function __construct($id, Node $source, Node $target) {
		if (!is_string($id) and !is_int($id)) {
			throw new \InvalidArgumentException('Edge ID may only be string or integer.');
		}

		if (is_string($id)) {
			$id = trim($id);
			if (empty($id)) {
				throw new \InvalidArgumentException('Edge ID may not be empty.');
			}
		}

		$this->id = $id;
		$this->source = $source;
		$this->target = $target;
	}

	public function clearColor() {
		$this->color = null;
	}

	public function clearLabel() {
		$this->label = null;
	}

	public function clearThickness() {
		$this->thickness = null;
	}

	public function clearWeight() {
		$this->weight = null;
	}

	public function getColor() {
		return $this->color;
	}

	public function getEdgeType() {
		return $this->edgetype;
	}

	public function getId() {
		return $this->id;
	}

	public function getLabel() {
		return $this->label;
	}

	public function getShape() {
		return $this->shape;
	}

	public function getSource() {
		return $this->source;
	}

	public function getTarget() {
		return $this->target;
	}

	public function getThickness() {
		return $this->thickness;
	}

	public function getWeight() {
		return $this->weight;
	}

	public function hasColor() {
		return !is_null($this->color);
	}

	public function hasLabel() {
		return !is_null($this->label);
	}

	public function hasThickness() {
		return !is_null($this->thickness);
	}

	public function hasWeight() {
		return !is_null($this->weight);
	}

	public function setColor(Color $color) {
		$this->color = $color;
	}

	public function setEdgeType(EdgeType $edgetype) {
		$this->edgetype = $edgetype;
	}

	public function setLabel($label) {
		if (!is_string($label)) {
			throw new \InvalidArgumentException();
		}

		$this->label = $label;
	}

	public function setShape(EdgeShape $shape) {
		$this->shape = $shape;
	}

	public function setTarget(Node $target) {
		$this->target = $target;
	}

	public function setThickness($thickness) {
		if (!is_float($thickness)) {
			throw new \InvalidArgumentException();
		}
	}

	public function setWeight($weight) {
		if (!is_float($weight)) {
			throw new \InvalidArgumentException();
		}
	}
}
