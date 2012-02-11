<?php

namespace RRaven\Stream\Transform;

use RRaven\Stream\Reader_Abstract;
use RRaven\Stream\Reader_Array;

class Array_First 
	extends Array_Abstract 
{
	
	public function __construct(Reader_Abstract $reader) {
		$reader->rewind();
		parent::__construct(new Reader_Array($reader->current()));
	}
	
	public function current() {
		return $this->get_reader()->current();
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