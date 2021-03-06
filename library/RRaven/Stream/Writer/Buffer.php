<?php

namespace RRaven\Stream\Writer;

use RRaven\Stream\Writer_Abstract;

class Buffer extends Writer_Abstract {
	
	protected $writer = null;
	protected $buffer = array();
	
	protected $closed = false;
	
	public function __construct(Writer_Abstract $writer) {
		$this->writer = $writer;
	}
	
	public function write_one($row) {
		$this->buffer[] = $row;
	}
	
	protected function flush() {
		if (count($this->buffer)) {
			if ($this->closed) {
				throw new \Exception(
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