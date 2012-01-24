<?php

class RRaven_Stream_Reader_CSV extends RRaven_Stream_Reader_File {
	
	protected $delimiter = ",";
	protected $enclosure = "\"";
	protected $keys = null;
	
	public function __construct($filename, $delimiter = ",", $enclosure = "\"") {
		parent::__construct($filename);
		$this->delimiter = $delimiter;
		$this->enclosure = $enclosure;
	}
	
	private function getKeys() {
		if ($this->keys === null) {
			$keys = 
				fgetcsv($this->handle, null, $this->delimiter, $this->enclosure);
			if ($keys === array(null) || $keys === false || $keys === null) {
				throw new Exception("Cannot get keys for CSV");
			}
			$this->keys = $keys;
		}
		return $this->keys;
	}
	
	public function current() {
		$keys = $this->getKeys();
		$vals = str_getcsv(parent::current, $this->delimiter, $this->enclosure);
		if (count($keys) != count($vals)) {
			throw new Exception("Wrong number of values for keys found");
		}
		return array_combine($keys, $vals);
	}
	
	public function rewind() {
		parent::rewind();
		$this->keys = null;
	}
	
}