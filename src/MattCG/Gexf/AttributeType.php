<?php

namespace MattCG\Gexf;

class AttributeType extends \SplEnum {
	const __default = self::TYPE_STRING;

	const TYPE_ANYURI = 'anyURI';
	const TYPE_BOOLEAN = 'boolean';
	const TYPE_DOUBLE = 'double';
	const TYPE_FLOAT = 'float';
	const TYPE_INTEGER = 'integer';
	const TYPE_LISTSTRING = 'liststring';
	const TYPE_LONG = 'long';
	const TYPE_STRING = 'string';
}
