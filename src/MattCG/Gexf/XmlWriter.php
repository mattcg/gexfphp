<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class XmlWriter {

	private $writer;

	public function __construct(Gexf $gexf) {
		$this->writer = new XMLWriter();
		$this->gexf = $gexf;
	}

	public function write() {
		$writer = $this->writer;
		$gexf = $this->gexf;

		$writer->startDocument('1.0', 'UTF-8');
		$writer->startElement('gexf');
		$writer->writeAttribute('xmlns', 'http://www.gexf.net/1.2draft');
		$writer->writeAttributeNS('xmlns', 'xsi', 'http://www.w3.org/2001/XMLSchema−instance', 'http://www.w3.org/2001/XMLSchema−instance');
		$writer->writeAttributeNS('xsi', 'schemaLocation', 'http://www.gexf.net/1.2draft http://www.gexf.net/1.2draft/gexf.xsd');
		$writer->writeAttribute('version', $gexf->getVersion());

		if ($gexf->hasVisualization()) {
			$writer->writeAttributeNS('xmlns', 'viz', 'http://www.gexf.net/1.2draft', 'http:///www.gexf.net/1.1draft/viz');
		}

		if ($gexf->hasMetadata()) {
			$this->writeMetadata($gexf->getMetadata());
		}
	}

	private function writeMetadata(Metadata $metadata) {
		$writer = $this->writer;

		$writer->startElement('meta');
		if ($metadata->hasLastModified()) {
			$writer->writeAttribute('lastmodifieddate', '');
		}

		if ($metadata->hasCreator()) {
			$writer->writeElement('creator', $gexf->getCreator());
		}

		if ($metadata->hasDescription()) {
			$writer->writeElement('description', $gexf->getDescription());
		}

		if ($metadata->hasKeywords()) {
			$writer->writeElement('keywords', implode(', ', $gexf->getKeywords()));
		}
	}
}
