<?php

class RRaven_Stream_Transform_String_CSV 
	extends RRaven_Stream_Transform_String_Abstract 
{
	protected $transformer = null;
	
	protected $keys = null;
	protected $index = 0;
	
	public function __construct(RRaven_Stream_Reader_Abstract $reader) {
		parent::__construct($reader);
	}
	
	/**
	 *
	 * @return RRaven_Transform_String_Abstract
	 */
	protected function get_transformer() {
		return (
			$this->transformer === null 
				? $this->transformer = new RRaven_Transform_String_CSV() 
				: $this->transformer
		);
	}
	
	protected function get_keys() {
		if ($this->keys === null) {
			if (!$this->getReader()->valid()) {
				throw new Exception("Cannot read keys from stream");
			}
			$this->keys = 
					$this->get_transformer()
						 ->transform($this->getReader()->current());
			$this->getReader()->next();
		}
		return ($this->keys);
	}
	
	/**
	 * @return RRaven_Stream_Reader_Abstract
	 */
	protected function getReader() {
		return $this->reader;
	}
	
	public function current() {
		return 
			array_combine(
				$this->get_keys(), 
				$this->get_transformer()->transform($this->current())
			);
	}
	
	public function key() {
		return $this->index;
	}
	
	public function next() {
		$this->index += 1;
		$this->getReader()->next();
	}
	
	public function valid() {
		return $this->getReader()->valid();
	}
	
	public function rewind() {
		$this->getReader()->rewind();
		$this->index = 0;
	}
	
}