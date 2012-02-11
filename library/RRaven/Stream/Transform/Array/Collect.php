<?php

namespace RRaven\Stream\Transform;

use RRaven\Stream\Reader_Abstract;

class Array_Collect 
	extends Array_Abstract 
{
	protected $key = null;
	
	public function __construct(Reader_Abstract $reader, $key = null) {
		parent::__construct($reader);
		
		if (!is_string($key . "")) {
			throw new \Exception("Key to collect from stream is required");
		}
		
		$this->key = $key;
	}
	
	public function current() {
		$row = $this->get_reader()->current();
		return $row[$this->key];
	}
	
	public function key() {
		$this->get_reader()->key();
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