<?php

namespace RRaven\Stream\Transform\String;

use RRaven\Stream\Transform\String_Abstract;

class Lowercase 
	extends String_Abstract 
{
	public function current() {
		return strtolower(parent::current());
	}
}