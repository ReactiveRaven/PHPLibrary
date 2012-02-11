<?php

namespace RRaven\Stream;

abstract class Reader_Abstract implements \Iterator {

	
	public function toArray() {
		$array = array();
		foreach ($this as $key => $val) {
			$array[$key] = $val;
		}
		return $array;
	}
}