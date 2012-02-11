<?php

namespace RRaven\Stream\Transform\String;

use RRaven\Stream\Transform\String_Abstract;

class Uppercase
	extends String_Abstract 
{
	public function current() {
		return strtoupper(parent::current());
	}
}