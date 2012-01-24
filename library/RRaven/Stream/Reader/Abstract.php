<?php

abstract class RRaven_Stream_Reader_Abstract implements Iterator {
	abstract public function current();
	
	abstract public function key();
	
	abstract public function next();
	
	abstract public function rewind();
	
	abstract public function valid();
	
	public function toArray() {
		$array = array();
		foreach ($this as $key => $val) {
			$array[$key] = $val;
		}
		return $array;
	}
}