<?php

abstract class RRaven_Transform_Abstract {
	
	abstract public function will_accept($input)
	{
		return false;
	}
	
	abstract public function transform($input);
	
}