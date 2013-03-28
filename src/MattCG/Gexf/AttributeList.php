<?php

namespace MattCG\Gexf;

use Rhumsaa\Uuid\Uuid;

class AttributeList {

	private $mode, $attrclass, $attrs;

	public function __construct(AttributeClass $attrclass) {
		$this->attrclass = $attrclass;
		$this->attrs = array();
	}

	public function addAttribute($id, AttributeType $type, $title) {
		$this->attrs[$id] = new Attribute((string) $id, $type, $title);
	}

	public function createAttribute(AttributeType $type, $title) {
		$this->addAttribute(Uuid::uuid4(), $type, $title);
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
