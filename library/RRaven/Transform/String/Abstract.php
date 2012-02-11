<?php

namespace RRaven\Transform;

use RRaven\Transform_Abstract;

abstract class String_Abstract 
	extends Transform_Abstract {

	public function will_accept($input) {
		return (
			is_string($input) 
			|| (
				is_object($input) 
				&& method_exists($input, "__toString")
			)
		);
	}
}