<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class Position {

	private $x, $y, $z;

	public function __construct($x = 0.0, $y = 0.0, $z = 0.0) {
		$this->setX($x);
		$this->setY($y);
		$this->setZ($z);
	}

	public function getX() {
		return $this->x;
	}

	public function getY() {
		return $this->y;
	}

	public function getZ() {
		return $this->z;
	}

	public function setX($x) {
		if (!is_float($x)) {
			throw new \InvalidArgumentException();
		}

		$this->x = $x;
	}

	public function setY($y) {
		if (!is_float($y)) {
			throw new \InvalidArgumentException();
		}

		$this->y = $y;
	}

	public function setZ($z) {
		if (!is_float($z)) {
			throw new \InvalidArgumentException();
		}

		$this->z = $z;
	}
}
