<?php

namespace RRaven\Stream\Transform\String;

use RRaven\Stream\Transform\String_Abstract;

class JSON 
	extends String_Abstract 
{
	public function current() {
		return json_decode($this->get_reader()->current(), true);
	}
	
	public function key() {
		return $this->get_reader()->key();
	}
	
	public function next() {
		$this->get_reader()->next();
	}
	
	public function rewind() {
		$this->get_reader()->rewind();
	}
	
	public function valid() {
		return $this->get_reader()->valid();
	}
}