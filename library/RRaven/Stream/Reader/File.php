<?php

namespace RRaven\Stream\Reader;

use RRaven\Stream\Reader_Abstract;

class File extends Reader_Abstract {
	
	protected $handle = null;
	protected $current = null;
	protected $index = 0;
	
	public function __construct($filename) {
		if (!is_readable($filename)) {
			throw new \Exception("Cannot read file");
		}
		$this->handle = fopen($filename, "r");
	}
	
	public function next() {
		$this->index += 1;
		$this->current = null;
	}
	
	public function current() {
		if ($this->current === null) {
			$this->current = fgets($this->handle);
		}
		return $this->current;
	}
	
	public function valid() {
		return $this->current() !== false;
	}
	
	public function key() {
		return $this->index;
	}
	
	public function rewind() {
		$this->index = 0;
		rewind($this->handle);
		$this->current = null;
	}
}