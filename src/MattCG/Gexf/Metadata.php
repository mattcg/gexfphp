<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class Metadata {

	private $creator, $description, $keywords, $lastmodified;

	public function __construct() {
		$this->keywords = array();
	}

	public function getCreator() {
		return $this->creator;
	}

	public function hasCreator() {
		return !is_null($this->creator);
	}

	public function clearCreator() {
		$this->creator = null;
	}

	public function setCreator($creator) {
		if (!is_string($creator)) {
			throw new \InvalidArgumentException();
		}

		$this->creator = $creator;
	}

	public function getDescription() {
		return $this->description;
	}

	public function hasDescription() {
		return !is_null($this->description);
	}

	public function clearDescription() {
		$this->description = null;
	}

	public function setDescription($description) {
		if (!is_string($description)) {
			throw new \InvalidArgumentException();
		}

		$this->description = $description;
	}

	public function getLastModified() {
		return $this->lastmodified;
	}

	public function hasLastModified() {
		return !is_null($this->lastmodified);
	}

	public function clearLastModified() {
		$this->lastmodified = null;
	}

	public function setLastModified(\DateTime $date) {
		$this->lastmodified = $date;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function hasKeywords() {
		return count($this->keywords) > 0;
	}

	public function clearKeywords() {
		$this->keywords = array();
	}

	public function addKeyword($keyword) {
		if (!is_string($keyword)) {
			throw new \InvalidArgumentException();
		}

		$this->keywords[] = $keyword;
	}

	public function setKeywords(array $keywords) {
		foreach ($keywords as $keyword) {
			$this->addKeyword($keyword);
		}
	}

	public function clearMetadata() {
		$this->clearCreator();
		$this->clearDescription();
		$this->clearLastModified();
		$this->clearKeywords();
	}

	public function isEmpty() {
		return !$this->hasKeywords() and !$this->hasLastModified() and !$this->hasDescription() and !$this->hasCreator();
	}
}
