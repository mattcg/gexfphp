<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

use MattCG\Gexf\Attribute;
use MattCG\Gexf\AttributeClass;
use MattCG\Gexf\AttributeType;

use Rhumsaa\Uuid\Uuid;

class AttributeList implements \Iterator, \ArrayAccess, \SeekableIterator, \Countable {

	private $mode, $attrclass, $attrs;

	/* Countable interface */

	function count() {
		return count($this->attrs);
	}

	/* Iterator interface */

	function current() {
		return current($this->attrs);
	}

	function key() {
		return key($this->attrs);
	}

	function next() {
		next($this->attrs);
	}

	function rewind() {
		rewind($this->attrs);
	}

	function valid() {
		return current($this->attrs) !== false;
	}

	/* ArrayAccess interface */

	function offsetSet($offset, $value) {
		if (!($value instanceof Attribute)) {
			throw new \InvalidArgumentException();
		}

		if ($offset !== $value->getId()) {
			throw new \InvalidArgumentException();
		}

		$this->attrs[$offset] = $value;
	}

	function offsetUnset($offset) {
		unset($this->attrs[$offset]);
	}

	function offsetExists($offset) {
		return isset($this->attrs[$offset]);
	}

	function offsetGet($offset) {
		if ($this->offsetExists($offset)) {
			return $this->attrs[$offset];
		}
	}

	/* SeekableIterator interface */

	function seek($position) {
		if (!$this->offsetExists($position)) {
			throw new \OutOfBoundsException();
		}

		while (key($this->attrs) !== $position) next($this->attrs);
	}

	public function __construct(AttributeClass $attrclass) {
		$this->attrclass = $attrclass;
		$this->attrs = array();
	}

	public function addAttribute($id, AttributeType $type, $title = null) {
		$this->attrs[$id] = new Attribute($id, $type, $title);
	}

	public function createAttribute(AttributeType $type, $title = null) {
		$id = Uuid::uuid4()->toString();
		$this->addAttribute($id, $type, $title);
		return $this->attrs[$id];
	}

	public function getAttributeClass() {
		return $this->attrclass;
	}

	public function setMode(Mode $mode) {
		$this->mode = $mode;
	}

	public function getMode() {
		return $this->mode;
	}
}
