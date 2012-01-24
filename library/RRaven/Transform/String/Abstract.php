<?php

abstract class RRaven_Transform_String_Abstract 
	extends RRaven_Transform_Abstract {

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