<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class Gexf {

	private $metadata, $graph, $viz;
	protected $version = "1.2";

	public function __construct() {
		$this->viz = false;
	}

	public function getMetadata() {
		if (is_null($this->metadata)) {
			$this->metadata = new Metadata();
		}

		return $this->metadata;
	}

	public function hasMetadata() {
		return !is_null($this->metadata) and !$this->metadata->isEmpty();
	}

	public function getVersion() {
		return $this->version;
	}

	public function getGraph() {
		if (is_null($this->graph)) {
			$this->graph = new Graph();
		}

		return $this->graph;
	}

	public function setVisualization($viz) {
		if (!is_bool($viz)) {
			throw new \InvalidArgumentException();
		}

		$this->viz = $viz;
	}

	public function hasVisualization() {
		return $this->viz;
	}
}
