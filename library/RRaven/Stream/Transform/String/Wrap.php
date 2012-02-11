<?php

namespace RRaven\Stream\Transform\String;

use RRaven\Stream\Transform\String_Abstract;
use RRaven\Stream\Reader_Abstract;

class Wrap 
	extends String_Abstract 
{
	protected $prefix = null;
	protected $suffix = null;


	public function __construct(
		Reader_Abstract $reader, 
		$prefix = null, 
		$suffix = null
	) {
		parent::__construct($reader);
		
		$this->suffix = $suffix;
		$this->prefix = $prefix;
	}
	
	public function current() {
		return $this->prefix . $this->get_reader()->current() . $this->suffix;
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