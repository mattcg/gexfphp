<?php
/**
 * @author Matthew Caruana Galizia <m@m.cg>
 * @copyright Copyright (c) 2013, Matthew Caruana Galizia
 */

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

	public function canHaveValue($value) {
		switch ((string) $this) {
		case self::TYPE_DOUBLE:
			return is_double($value);

		case self::TYPE_FLOAT:
			return is_float($value);

		case self::TYPE_INTEGER:
			return is_int($value);

		case self::TYPE_LONG:
			return is_long($value);

		case self::TYPE_STRING:
		case self::TYPE_ANYURI:
			return is_string($value);

		case self::TYPE_LISTSTRING:
			if (!is_string($value)) {
				return false;
			}

			// Liststring values may be separated by a pipe, a semicolon or a comma, so these characters are unsafe in invidual values.
			if (preg_match('/\||;|,/', $value)) {
				return false;
			}

			return true;

		case self::TYPE_BOOLEAN:
			return is_bool($value);

		default:
			throw new \LogicException('Unhandled type: ' . $this . '.');
		}
	}

	public static function parseListString($liststring) {
		if (empty($liststring)) {
			return array();
		}

		preg_match('/(\||,|;)/', $liststring, $matches);
		if ($matches and isset($matches[1])) {
			return explode($liststring, $matches[1]);
		}

		return array($liststring);
	}

	public function convertToType($value) {
		switch ((string) $this) {
		case self::TYPE_DOUBLE:
			return (double) $value;

		case self::TYPE_FLOAT:
			return (float) $value;

		case self::TYPE_INTEGER:
		case self::TYPE_LONG:
			return (int) $value;

		case self::TYPE_STRING:
		case self::TYPE_ANYURI:
			return (string) $value;

		case self::TYPE_LISTSTRING:
			return self::parseListString($value);

		case self::TYPE_BOOLEAN:
			if (is_string($value)) {
				return $value === 'true';
			}

			return (bool) $value;

		default:
			throw new \LogicException('Unhandled type: ' . $this . '.');
		}
	}
}
