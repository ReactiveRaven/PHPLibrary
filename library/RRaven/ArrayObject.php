<?php

namespace RRaven;

use RRaven\ArrayObject\Toolbox;

class ArrayObject extends \ArrayObject {
	
	public function __construct($array = array()) {
		parent::__construct($array);
	}

	public function __clone() {
		return new ArrayObject($this);
	}
	
	public function collect($keys) {
		return new ArrayObject(Toolbox::collect($this, $keys));
	}
	
	public static function manufacture($array) {
		return new ArrayObject($array);
	}
	
	public function remove_duplicates() {
		return new ArrayObject(Toolbox::remove_duplicates($this));
	}
	
	public function and_keys($array) {
		return 
			new ArrayObject(Toolbox::and_keys($this, $array));
	}
	
	public function and_values($array) {
		return 
			new ArrayObject(Toolbox::and_values($this, $array));
	}
	
	public function or_keys($array) {
		return
			new ArrayObject(Toolbox::or_keys($this, $array));
	}
	
	public function or_values($array) {
		return
			new ArrayObject(Toolbox::or_values($this, $array));
	}
	
	public function and_not_keys($array) {
		return
			new ArrayObject(Toolbox::and_not_keys($this, $array));
	}
	
	public function and_not_values($array) {
		return
			new ArrayObject(
				Toolbox::and_not_values($this, $array)
			);
	}
	
	public function xor_keys($array) {
		return
			new ArrayObject(Toolbox::xor_keys($this, $array));
	}
	
	public function xor_values($array) {
		return
			new ArrayObject(Toolbox::xor_values($this, $array));
	}
	
	public function rotate() {
		return new ArrayObject(Toolbox::rotateArray($this));
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