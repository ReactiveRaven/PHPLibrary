<?php

class RRaven_Stream_Writer_StdErr extends RRaven_Stream_Writer_Abstract
{
	protected $handle = null;
	protected $closed = false;
	
	public function __construct() {
		$this->handle = fopen("php://stderr", "a");
	}
	
	public function write_one($row) {
		fwrite($this->handle, $row);
	}
	
	public function close() {
		
		if (!$this->closed) {
			fclose($this->handle);
			$this->closed = true;
		}
		
	}
	
}