<?php

class RRaven_Stream_Transform_Array_Collect 
	extends RRaven_Stream_Transform_Array_Abstract 
{
	protected $key = null;
	
	public function __construct(RRaven_Stream_Reader_Abstract $reader, $key = null) {
		parent::__construct($reader);
		
		if (!is_string($key . "")) {
			throw new Exception("Key to collect from stream is required");
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