<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Buffer
 *
 * @author godfred7
 */
class RRaven_Stream_Writer_Buffer extends RRaven_Stream_Writer_Abstract {
	
	protected $writer = null;
	protected $buffer = array();
	
	protected $closed = false;
	
	public function __construct(RRaven_Stream_Writer_Abstract $writer) {
		$this->writer = $writer;
	}
	
	public function write_one($row) {
		$this->buffer[] = $row;
	}
	
	protected function flush() {
		if (count($this->buffer)) {
			if ($this->closed) {
				throw new Exception(
					"Cannot flush buffer to stream_writer; already closed"
				);
			}
			var_dump($this->buffer);
			$this->writer->write_many($this->buffer);
		}
		$this->buffer = array();
	}
	
	public function close() {
		if (!$this->closed) {
			$this->flush();
			$this->closed = true;
			$this->writer->close();
		}
	}
}