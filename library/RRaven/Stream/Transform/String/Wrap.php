<?php

class RRaven_Stream_Transform_String_Wrap 
	extends RRaven_Stream_Transform_String_Abstract 
{
	protected $prefix = null;
	protected $suffix = null;


	public function __construct(
		RRaven_Stream_Reader_Abstract $reader, 
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

?>
