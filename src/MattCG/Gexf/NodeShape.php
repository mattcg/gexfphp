<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class NodeShape extends \SplEnum {
	const __default = self::SHAPE_DISC;

	// Node shapes are defined in the VIZ 1.2 draft XSD: http://www.gexf.net/1.2draft/viz/viz.xsd 
	const SHAPE_DIAMOND = 'diamond';
	const SHAPE_DISC = 'disc';
	const SHAPE_IMAGE = 'image';
	const SHAPE_SQUARE = 'square';
	const SHAPE_TRIANGLE = 'triangle';
}
