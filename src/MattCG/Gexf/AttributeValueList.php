<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

use MattCG\Gexf\AttributeValue;

class AttributeValueList implements \Iterator, \ArrayAccess, \SeekableIterator, \Countable {

	private $attrvalues;

	/* Countable interface */

	function count() {
		return count($this->attrvalues);
	}

	/* Iterator interface */

	function current() {
		return current($this->attrvalues);
	}

	function key() {
		return key($this->attrvalues);
	}

	function next() {
		next($this->attrvalues);
	}

	function rewind() {
		reset($this->attrvalues);
	}

	function valid() {
		return current($this->attrvalues) !== false;
	}

	/* ArrayAccess interface */

	function offsetSet($offset, $value) {
		if (!($value instanceof AttributeValue)) {
			throw new \InvalidArgumentException();
		}

		if ($offset !== $value->getAttribute()->getId()) {
			throw new \InvalidArgumentException();
		}

		$this->attrvalues[$offset] = $value;
	}

	function offsetUnset($offset) {
		unset($this->attrvalues[$offset]);
	}

	function offsetExists($offset) {
		return isset($this->attrvalues[$offset]);
	}

	function offsetGet($offset) {
		if ($this->offsetExists($offset)) {
			return $this->attrvalues[$offset];
		}
	}

	/* SeekableIterator interface */

	function seek($position) {
		if (!$this->offsetExists($position)) {
			throw new \OutOfBoundsException();
		}

		while (key($this->attrvalues) !== $position) next($this->attrvalues);
	}

	public function __construct() {
		$this->attrvalues = array();
	}

	public function addValue(Attribute $attr, $value = null) {
		$this->createValue($attr, $value);
	}

	public function createValue(Attribute $attr, $value = null) {
		$attrvalue = new AttributeValue($attr);
		$this->attrvalues[$attr->getId()] = $attrvalue;

		if (!is_null($value)) {
			$attrvalue->setValue($value);
		}

		return $attrvalue;
	}
}
