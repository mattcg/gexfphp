<?php

namespace MattCG\Gexf;

class Attribute {

	private $id, $type, $title, $defaultvalue, $options;

	public function __construct($id, AttributeType $type, $title = null) {
		if (!is_string($id)) {
			throw new \InvalidArgumentException('Attribute ID may only be string. Input was: ' . $id . '.');
		}

		$id = trim($id);
		if (empty($id)) {
			throw new \InvalidArgumentException('Attribute ID may not be empty. Input was: ' . $id . '.');
		}

		$this->id = $id;
		$this->type = $type;
		$this->options = array();
		$this->title = $title;
	}

	public function createValue($value) {
		$attrval = new AttributeValue($this);
		$attrval->setValue($value);
		return $attrval;
	}

	public function hasOption($option) {
		return isset($this->options[$option]);
	}

	public function hasOptions() {
		return count($this->options) > 0;
	}

	public function setOptions(array $options) {
		if (empty($options)) {
			$this->clearOptions();
			return;
		}

		$options = array_fill_keys(array_values($options), true);
		if ($this->hasDefaultValue() and !isset($options[$this->defaultvalue])) {
			throw new \InvalidArgumentException('Attribute default value must exist in options list.');
		}

		$this->options = $options;
	}

	public function addOption($option) {
		$this->options[$option] = true;
	}

	public function clearOptions() {
		if ($this->hasDefaultValue()) {
			throw new \RuntimeException('Attribute default value must be cleared first.');
		}

		$this->options = array();
	}

	public function getOptions() {
		return array_keys($this->options);
	}

	public function getDefaultValue() {
		return $this->defaultvalue;
	}

	public function hasDefaultValue() {
		return !is_null($this->defaultvalue);
	}

	public function clearDefaultValue() {
		$this->defaultvalue = null;
	}

	public function setDefaultValue($defaultvalue) {
		if (is_null($defaultvalue)) {
			$this->clearDefaultValue();
			return;
		}

		if ($this->type == AttributeType::TYPE_LISTSTRING) {
			if (empty($defaultvalue)) {
				$this->clearDefaultValue();
				return;
			}

			if (!$this->canHaveListStringValues($defaultvalue)) {
				throw new \InvalidArgumentException();
			}

		} elseif (!$this->canHaveScalarValue($defaultvalue)) {
			throw new \InvalidArgumentException('Attribute default value must exist in options list if options are set. Input was: ' . $defaultvalue . '.');
		}

		$this->defaultvalue = $defaultvalue;
	}

	public function canHaveValue($value) {
		if ($this->type == AttributeType::TYPE_LISTSTRING) {
			return $this->canHaveListStringValues($value);
		}

		return $this->canHaveScalarValue($value);
	}

	private function canHaveScalarValue($value) {
		if ($this->type == AttributeType::TYPE_LISTSTRING) {
			throw new \LogicException();
		}

		// Not that null will fail the is_scalar check. This is intentional.
		if (!is_scalar($value)) {
			throw new \InvalidArgumentException('Attribute value must be supplied as scalar for non-liststring type attribute. Input was: ' . $value . '.');
		}

		return !$this->hasOptions() or $this->hasOption($value);
	}

	private function canHaveListStringValues($values) {
		if ($this->type != AttributeType::TYPE_LISTSTRING) {
			throw new \LogicException();
		}

		if (!is_array($values)) {
			throw new \InvalidArgumentException('Attribute values must be supplied as array for attribute of type listring. Input was: ' . $values . '.');
		}

		if (!$this->hasOptions()) {
			return true;
		}

		foreach ($values as $value) {
			if (!$this->hasOption($value)) {
				return false;
			}
		}

		return true;
	}

	public function getId() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getAttributeType() {
		return $this->type;
	}
}
