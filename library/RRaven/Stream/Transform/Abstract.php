<?php

namespace RRaven\Stream;

use RRaven\Stream\Reader_Abstract;

abstract class Transform_Abstract extends Reader_Abstract {
	
	protected $reader = null;
	
	public function __construct(Reader_Abstract $reader) {
		$this->reader = $reader;
	}
	
	/**
	 * @return RRaven_Stream_Reader_Abstract
	 */
	protected function get_reader() {
		return $this->reader;
	}
}