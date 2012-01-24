<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author godfred7
 */
class RRaven_Stream_Writer_File extends RRaven_Stream_Writer_Abstract {
	
	protected $handle = null;
	protected $closed = false;
	
	public function __construct($filename) {
		if (
			(
				file_exists($filename) 
				&& !is_writable($filename) 
			)
			|| !is_writable(dirname($filename))
		) {
			throw new Exception("File or folder is not writable");
		}
		$this->handle = fopen($filename, "w");
	}
	
	public function write_one($string) {
		if ($this->closed) {
			throw new Exception("Cannot write to file as already closed");
		}
		fwrite($this->handle, $string);
	}
	
	public function close() {
		$this->closed = true;
		fclose($this->handle);
	}
}