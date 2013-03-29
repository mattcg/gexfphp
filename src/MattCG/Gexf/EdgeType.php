<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class EdgeType extends \SplEnum {
	const __default = self::TYPE_UNDIRECTED;

	const TYPE_UNDIRECTED = 'undirected';
	const TYPE_DIRECTED = 'directed';
	const TYPE_MUTUAL = 'mutual';
}
