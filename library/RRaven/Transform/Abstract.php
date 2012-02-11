<?php

namespace RRaven;

abstract class Transform_Abstract {
	
	public function will_accept($input);
	
	abstract public function transform($input);
	
}