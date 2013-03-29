<?php

namespace MattCG\Gexf;

class Attribute {

	private $id, $type, $title, $defaultvalue, $options;

	public function __construct($id, AttributeType $type, $title = null) {
		if (!is_string($id) or !is_int($id)) {
			throw new \InvalidArgumentException('Attribute ID may only be string or integer.');
		}

		if (is_string($id)) {
			$id = trim($id);
			if (empty($id)) {
				throw new \InvalidArgumentException('Attribute ID may not be empty.');
			}
		}

		$this->id = $id;
		$this->type = $type;
		$this->title = $title;
		$this->options = array();
	}

	public function createValue($value) {
		$attrval = new AttributeValue($this);
		$attrval->setValue($value);
		return $attrval;
	}

	public function hasOption($option) {
		return in_array($option, $this->options, true);
	}

	public function hasOptions() {
		return count($this->options) > 0;
	}

	public function setOptions(array $options) {
		if (empty($options)) {
			$this->clearOptions();
			return;
		}

		if ($this->type == AttributeType::TYPE_BOOLEAN) {
			throw new \LogicException('Attribute of type boolean cannot have options.');
		}

		if ($this->hasDefaultValue() and !in_array($this->defaultvalue, $options, true)) {
			throw new \InvalidArgumentException('Attribute default value must exist in options list.');
		}

		foreach ($options as $option) {
			$this->addOption($option);
		}
	}

	public function addOption($option) {
		if ($this->type == AttributeType::TYPE_BOOLEAN) {
			throw new \LogicException('Attribute of type boolean cannot have options.');
		}

		if (!$this->type->canHaveValue($option)) {
			throw new \InvalidArgumentException('Attribute of type ' . $this->type . ' cannot have option of type.');
		}

		if (!$this->hasOption($option)) {
			$this->options[] = $option;
		}
	}

	public function clearOptions() {
		if (!$this->hasOptions()) {
			return;
		}

		if ($this->hasDefaultValue()) {
			throw new \LogicException('Attribute default value must be cleared first.');
		}

		$this->options = array();
	}

	public function getOptions() {
		return $this->options;
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
			if (!is_array($defaultvalue)) {
				throw new \InvalidArgumentException('Attribute values must be supplied as array for attribute of type listring.');
			}

			if (empty($defaultvalue)) {
				$this->clearDefaultValue();
				return;
			}

			foreach ($defaultvalue as $defaultvaluepart) {
				if ($this->hasOptions() and !$this->hasOption($defaultvaluepart)) {
					throw new \InvalidArgumentException('Attribute default value must exist in options list if options are set.');
				}

				if (!$this->type->canHaveValue($defaultvaluepart)) {
					throw new \InvalidArgumentException('Attribute of type ' . $this->type . ' cannot have default value of type ' . gettype($defaultvaluepart) . '.');
				}
			}

		} else {
			if ($this->hasOptions() and !$this->hasOption($defaultvalue)) {
				throw new \InvalidArgumentException('Attribute default value must exist in options list if options are set.');
			}

			if (!$this->type->canHaveValue($defaultvalue)) {
				throw new \InvalidArgumentException('Attribute of type ' . $this->type . ' cannot have default value of type ' . gettype($defaultvalue) . '.');
			}
		}

		$this->defaultvalue = $defaultvalue;
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
