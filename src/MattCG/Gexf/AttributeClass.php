<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class AttributeClass extends \SplEnum {
	const __default = self::CLASS_NODE;

	const CLASS_EDGE = 'edge';
	const CLASS_NODE = 'node';
}
