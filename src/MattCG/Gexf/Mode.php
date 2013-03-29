<?php

namespace MattCG\Gexf;

class Mode extends \SplEnum {
	const __default = self::MODE_STATIC;

	const MODE_STATIC = 'static';
	const MODE_DYNAMIC = 'dynamic';
}
