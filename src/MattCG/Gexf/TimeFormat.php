<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

namespace MattCG\Gexf;

class TimeFormat extends \SplEnum {
	const __default = self::FORMAT_DOUBLE;

	const FORMAT_DOUBLE = 'double';
	const FORMAT_INTEGER = 'integer';
	const FORMAT_DATE = 'date';
	const FORMAT_XSDDATETIME = 'dateTime';
}
