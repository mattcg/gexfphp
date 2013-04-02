<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class XmlWriter {

	const NS_VIZ = 'http:///www.gexf.net/1.2draft/viz';

	private $writer, $gexf;

	public function __construct(Gexf $gexf) {
		$this->writer = new XMLWriter();
		$this->gexf = $gexf;
	}

	public function write($uri = null) {
		$writer = $this->writer;
		$gexf = $this->gexf;

		if ($uri) {
			$writer->openMemory();
		} else {
			$writer->openURI($uri);
		}

		$writer->setIndent(false);
		$writer->startDocument('1.0', 'UTF-8');

		$this->startGexf();
		if ($gexf->hasMetadata()) {
			$this->writeMetadata();
		}

		$this->startGraph();
		$this->writeAttributes();
		$this->writeNodes();
		$this->writeEdges();
		$this->endGraph();
		$this->endGexf();

		$writer->endDocument();

		if ($uri) {
			return $write->outputMemory(true);
		}
	}

	private function startGexf() {
		$writer = $this->writer;
		$gexf = $this->gexf;

		$writer->startElement('gexf');
		$writer->writeAttribute('xmlns', 'http://www.gexf.net/1.2draft');
		$writer->writeAttributeNS('xmlns', 'xsi', 'http://www.w3.org/2001/XMLSchema−instance', 'http://www.w3.org/2001/XMLSchema−instance');
		$writer->writeAttributeNS('xsi', 'schemaLocation', 'http://www.gexf.net/1.2draft http://www.gexf.net/1.2draft/gexf.xsd');
		$writer->writeAttribute('version', $gexf->getVersion());

		if ($gexf->hasVisualization()) {
			$writer->writeAttributeNS('xmlns', 'viz', 'http://www.w3.org/2001/XMLSchema−instance', self::NS_VIZ);
		}
	}

	private function endGexf() {
		$this->writer->endElement();
	}

	private function writeMetadata() {
		$writer = $this->writer;
		$metadata = $this->gexf->getMetadata();

		$writer->startElement('meta');
		if ($metadata->hasLastModified()) {
			$writer->writeAttribute('lastmodifieddate', '');
		}

		if ($metadata->hasCreator()) {
			$writer->writeElement('creator', $metadata->getCreator());
		}

		if ($metadata->hasDescription()) {
			$writer->writeElement('description', $metadata->getDescription());
		}

		if ($metadata->hasKeywords()) {
			$writer->writeElement('keywords', implode(', ', $metadata->getKeywords()));
		}
	}

	private function startGraph() {
		$writer = $this->writer;
		$graph = $this->gexf->getGraph();

		$writer->startElement('graph');
		if ($graph->hasDefaultEdgeType()) {
			$writer->writeAttribute('defaultedgetype', (string) $graph->getDefaultEdgeType());
		}

		if ($graph->hasIdType()) {
			$writer->writeAttribute('idtype', (string) $graph->getIdType());
		}

		if ($graph->hasMode()) {
			$writer->writeAttribute('mode', (string) $graph->getMode());
		}

		if ($graph->hasTimeFormat()) {
			$writer->writeAttribute('timeformat', (string) $graph->getTimeFormat());
		}
	}

	private function endGraph() {
		$this->writer->endElement();
	}

	private function writeAttributes() {
		$writer = $this->writer;
		$graph = $this->gexf->getGraph();
		if (!$graph->hasAttributes()) {
			return;
		}

		$attrlists = $graph->getAttributeLists();

		foreach ($attrlists as $attrlist) {
			$writer->startElement('attributes');
			$writer->writeAttribute('class', (string) $attrlist->getAttributeClass());
			if ($attrlist->hasMode()) {
				$writer->writeAttribute($attrlist->getMode());
			}

			foreach ($attrlist as $attr) {
				$this->writeAttribute($attr);
			}

			$writer->endElement();
		}
	}

	private function writeAttribute(Attribute $attr) {
		$writer = $this->writer;

		$writer->startElement('attribute');
		$writer->writeAttribute('id', $attr->getId());
		$writer->writeAttribute('type', $attr->getAttributeType());
		if ($attr->hasTitle()) {
			$writer->writeAttribute('title', $attr->getTitle());
		}

		if ($attr->hasDefaultValue()) {
			$defaultvalue = $attr->getDefaultValue();
			if ($attr->getAttributeType() == AttributeType::TYPE_BOOLEAN) {
				$defaultvalue = $defaultvalue ? 'true' : 'false';
			}

			$writer->writeElement('default', $defaultvalue);
		}

		if ($attr->hasOptions()) {
			$writer->writeElement('options', implode('|', $attr->getOptions()));
		}

		$writer->endElement();
	}

	private function writeNodes() {
		$writer = $this->writer;
		$nodes = $this->gexf->getGraph()->getNodes();

		$writer->startElement('nodes');

		// Note that count only refers to direct children, not the whole sub-graph.
		$writer->writeAttribute('count', count($nodes));
		foreach ($nodes as $node) {
			$this->writeNode($node);
		}

		$this->endElement();
	}

	private function writeNode(Node $node) {
		$writer = $this->writer;

		$writer->startElement('node');
		$writer->writeAttribute('id', $node->getId());

		if ($node->hasLabel()) {
			$writer->writeAttribute('label', $node->getLabel());
		}

		if ($node->hasPid()) {
			$writer->writeAttribute('pid', $node->getPid());
		}

		if ($node->hasAttributeValues()) {
			$this->writeAttributeValues($this->getAttributeValueList());
		}

		if ($node->hasPosition()) {
			$position = $node->getPosition();
			$writer->startElementNS('viz', 'position', self::NS_VIZ);
			$writer->writeAttribute('x', $position->getX());
			$writer->writeAttribute('y', $position->getY());
			$writer->writeAttribute('z', $position->getZ());
			$writer->endElement();
		}

		if ($node->hasShape()) {
			$writer->startElementNS('viz', 'shape', self::NS_VIZ);
			$writer->writeAttribute('value', (string) $node->getShape());
		}

		if ($node->hasSize()) {
			$writer->startElementNS('viz', 'size', self::NS_VIZ);
			$writer->writeAttribute('value', $node->getSize());
		}

		if ($node->hasColor()) {
			$writer->startElementNS('viz', 'color', self::NS_VIZ);
			$color = $node->getColor()->toRGB();
			$writer->writeAttribute('r', $color->red);
			$writer->writeAttribute('g', $color->green);
			$writer->writeAttribute('b', $color->blue);
			$writer->writeAttribute('a', $color->alpha);
		}

		$nodes = $node->getNodes();
		foreach ($nodes as $node) {
			$this->startElement('nodes');
			$this->writeNode($node);
			$this->endElement();
		}

		$writer->endElement();
	}

	private function writeAttributeValues(AttributeValueList $attrvaluelist) {
		$writer = $this->writer;

		$writer->startElement('attvalues');
		foreach ($attrvaluelist as $attrvalue) {
			$writer->startElement('attvalue');
			$attr = $attrvalue->getAttribute();
			$writer->writeAttribute('for', $attr->getId());

			$value = $attrvalue->getValue();
			if ($attr->getAttributeType() == AttributeType::TYPE_BOOLEAN) {
				$value = $value ? 'true' : 'false';
			}

			$writer->writeAttribute('value', $value);
			$writer->endElement();
		}

		$writer->endElement();
	}

	private function writeEdges() {
		$writer = $this->writer;
		$edges = $this->gexf->getGraph()->getAllEdges();

		$writer->startElement('edges');
		$writer->writeAttribute('count', count($edges));
		foreach ($edges as $edge) {
			$writer->startElement('edge');
			$writer->writeAttribute('id', $edge->getId());
			$writer->writeAttribute('source', $edge->getSource()->getId());
			$writer->writeAttribute('target', $edge->getTarget()->getId());

			if ($edge->hasEdgeType()) {
				$writer->writeAttribute('edgetype', (string) $edge->getEdgeType());
			}

			if ($edge->hasLabel()) {
				$writer->writeAttribute('label', $edge->getLabel());
			}

			if ($edge->hasWeight()) {
				$writer->writeAttribute('weight', $edge->getWeight());
			}

			if ($edge->hasShape()) {
				$writer->startElementNS('viz', 'shape', self::NS_VIZ);
				$writer->writeAttribute('value', (string) $edge->getShape());
			}

			if ($edge->hasThickness()) {
				$writer->startElementNS('viz', 'thickness', self::NS_VIZ);
				$writer->writeAttribute('value', (string) $edge->getThickness());
			}

			if ($edge->hasColor()) {
				$writer->startElementNS('viz', 'color', self::NS_VIZ);
				$color = $edge->getColor()->toRGB();
				$writer->writeAttribute('r', $color->red);
				$writer->writeAttribute('g', $color->green);
				$writer->writeAttribute('b', $color->blue);
				$writer->writeAttribute('a', $color->alpha);
			}

			$writer->endElement();
		}

		$writer->endElement();
	}
}
