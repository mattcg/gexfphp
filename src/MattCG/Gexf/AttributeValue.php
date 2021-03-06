<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class AttributeValue {

	private $attr, $value;

	public function __construct(Attribute $attr) {
		$this->attr = $attr;
	}

	public function getAttribute() {
		return $this->attr;
	}

	public function getValue() {
		return $this->value;
	}

	public function setValue($value) {
		if (!$this->attr->getAttributeType()->canHaveValue($value)) {
			throw new \InvalidArgumentException('Cannot have value.');
		}

		$this->value = $value;
	}
}
