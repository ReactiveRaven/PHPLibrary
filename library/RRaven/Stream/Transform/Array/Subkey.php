<?php

namespace RRaven\Stream\Transform;

use RRaven\Stream\Reader_Abstract;
use RRaven\Transform_Abstract;

class Array_Subkey 
	extends Array_Abstract 
{
	protected $transform = null;
	protected $key = null;
	
	public function __construct(
		Reader_Abstract $reader, 
		$key = null, 
		Transform_Abstract $transform = null
	) {
		parent::__construct($reader);
		if ($key === null || $transform === null) {
			throw new \Exception(
				"Must supply both a key to change and a transform to apply"
			);
		}
	}
	
	/**
	 *
	 * @return Transform_Abstract
	 */
	protected function get_transform()
	{
		return $this->transform;
	}


	public function current() {
		$row = $this->get_reader()->current();
		if (
			(
				is_array($row) 
				|| $row instanceof \ArrayAccess
			) 
			&& isset($row[$this->key])
			&& $this->get_transform()->will_accept($row[$this->key])
		) {
			$row[$this->key] = $this->get_transform()->transform($row[$this->key]);
		}
		return $row;
	}
	
	public function key() {
		return $this->get_reader()->key();
	}
	
	public function next() {
		$this->get_reader()->next();
		return $this;
	}
	
	public function rewind() {
		$this->get_reader()->rewind();
		return $this;
	}
	
	public function valid() {
		return $this->get_reader()->valid();
	}
	
}