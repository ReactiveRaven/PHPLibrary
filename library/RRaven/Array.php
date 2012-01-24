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
class RRaven_Array extends ArrayObject {
	
	public function __construct($array = array()) {
		parent::__construct($array);
	}

	public function __clone() {
		return new RRaven_Array($this);
	}
	
	public function collect($keys) {
		return new RRaven_Array(RRaven_Array_Toolbox::collect($this, $keys));
	}
	
	public static function manufacture($array) {
		return new RRaven_Array($array);
	}
	
	public function remove_duplicates() {
		return new RRaven_Array(RRaven_Array_Toolbox::remove_duplicates($this));
	}
	
	public function and_keys($array) {
		return 
			new RRaven_Array(RRaven_Array_Toolbox::and_keys($this, $array));
	}
	
	public function and_values($array) {
		return 
			new RRaven_Array(RRaven_Array_Toolbox::and_values($this, $array));
	}
	
	public function or_keys($array) {
		return
			new RRaven_Array(RRaven_Array_Toolbox::or_keys($this, $array));
	}
	
	public function or_values($array) {
		return
			new RRaven_Array(RRaven_Array_Toolbox::or_values($this, $array));
	}
	
	public function and_not_keys($array) {
		return
			new RRaven_Array(RRaven_Array_Toolbox::and_not_keys($this, $array));
	}
	
	public function and_not_values($array) {
		return
			new RRaven_Array(
				RRaven_Array_Toolbox::and_not_values($this, $array)
			);
	}
	
	public function xor_keys($array) {
		return
			new RRaven_Array(RRaven_Array_Toolbox::xor_keys($this, $array));
	}
	
	public function xor_values($array) {
		return
			new RRaven_Array(RRaven_Array_Toolbox::xor_values($this, $array));
	}
	
	public function rotate() {
		return new RRaven_Array(RRaven_Array_Toolbox::rotateArray($this));
	}
	
	public function sort_values() {
		$this->asort();
		return $this;
	}
	
	public function sort_keys() {
		$this->ksort();
		return $this;
	}
	
	public function toArray() {
		return $this->getArrayCopy();
	}
}
?>
