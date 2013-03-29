<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class EdgeShape extends \SplEnum {
	const __default = self::SHAPE_SOLID;

	// Edge shapes are defined in the VIZ 1.2 draft XSD: http://www.gexf.net/1.2draft/viz/viz.xsd 
	const SHAPE_SOLID = 'solid';
	const SHAPE_DASHED = 'dashed';
	const SHAPE_DOTTED = 'dotted';
	const SHAPE_DOUBLE = 'double';
}
