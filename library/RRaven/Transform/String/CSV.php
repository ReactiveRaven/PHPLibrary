<?php

class RRaven_Transform_String_CSV extends RRaven_Transform_String_Abstract {
	public function transform($input, $delimiter = ",", $enclosure = "\"", $escape = "\\") {
		return str_getcsv($input, $delimiter, $enclosure, $escape);
	}
}