<?php

class RRaven_Stream_Transform_String_Lowercase 
	extends RRaven_Stream_Transform_String_Abstract 
{
	public function current() {
		return strtolower(parent::current());
	}
}