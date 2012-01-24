<?php

abstract class RRaven_Stream_Transform_Abstract extends RRaven_Stream_Reader_Abstract {
	
	protected $reader = null;
	
	public function __construct(RRaven_Stream_Reader_Abstract $reader) {
		$this->reader = $reader;
	}
}