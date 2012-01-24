<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Array
 *
 * @author godfred7
 */
class RRaven_Stream_Reader_Array extends RRaven_Stream_Reader_Abstract {
	
	protected $values = null;
	protected $keys = null;
	protected $index = 0;
	
	public function __construct($array) {
		if (!is_array($array) && !$array instanceof Traversable)
		{
			throw new Exception("Cannot loop over given variable");
		}
		
		if ($array instanceof Traversable) {
			$arr = array();
			foreach ($array as $key => $val) {
				$arr[$key] = $val;
			}
			$array = $arr;
		}
		
		$this->values = array_values($array);
		$this->keys = array_keys($array);
		
	}
	
	public function current() {
		return $this->values[$this->index];
	}
	
	public function key() {
		return $this->keys[$this->index];
	}
	
	public function next() {
		$this->index += 1;
	}
	
	public function rewind() {
		$this->index = 0;
	}
	
	public function valid() {
		return 
			isset($this->keys[$this->index]) 
			&& isset($this->values[$this->index]);
	}
}
?>
