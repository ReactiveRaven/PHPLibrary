<?php

class RRaven_Stream_Transform_String_Uppercase
	extends RRaven_Stream_Transform_String_Abstract 
{
	public function current() {
		return strtoupper(parent::current());
	}
}