<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class Mode extends \SplEnum {
	const __default = self::MODE_STATIC;

	const MODE_STATIC = 'static';
	const MODE_DYNAMIC = 'dynamic';
}
