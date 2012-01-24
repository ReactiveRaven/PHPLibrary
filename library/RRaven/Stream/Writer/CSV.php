<?php

class RRaven_Stream_Writer_CSV extends RRaven_Stream_Writer_File {
	
	protected $strict_key_matching = null;
	
	protected $delimiter = ",";
	protected $enclosure = "\"";
	
	protected $keys = null;
	
	public function __construct(
		$filename, 
		$delimiter = ",", 
		$enclosure = "\"", 
		$strict_key_matching = true
	) {
		parent::__construct($filename);
		$this->handle = fopen($filename, "w");
		$this->strict_key_matching = $strict_key_matching;
		$this->delimiter = $delimiter;
		$this->enclosure = $enclosure;
	}
	
	public function write_one($row) {
		if (!$this->check_keys(array_keys($row))) {
			throw new Exception("Keys given do not match header");
		}
		if ($this->closed) {
			throw new Exception("Cannot write to CSV as already closed");
		}
		fputcsv($this->handle, $row, $this->delimiter, $this->enclosure);
	}
	
	protected function check_keys($keys) {
		if ($this->keys === null) {
			$this->keys = $keys;
		}
		return 
			(
				$this->strict_key_matching 
					? $this->keys == $keys 
					: count($this->keys) == $keys
			);
	}
	
}