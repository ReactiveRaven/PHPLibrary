<?php

class RRaven_Stream_Transform_Array_First 
	extends RRaven_Stream_Transform_Array_Abstract 
{
	
	public function __construct(RRaven_Stream_Reader_Abstract $reader) {
		$reader->rewind();
		parent::__construct(new RRaven_Stream_Reader_Array($reader->current()));
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