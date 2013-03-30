<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class IdType extends \SplEnum {
	const __default = self::TYPE_STRING;

	const TYPE_INTEGER = 'integer';
	const TYPE_STRING = 'string';
}
