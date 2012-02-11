<?php

namespace RRaven\Transform\String;

use RRaven\Transform\String_Abstract;

class CSV extends String_Abstract {
	public function transform($input, $delimiter = ",", $enclosure = "\"", $escape = "\\") {
		return str_getcsv($input, $delimiter, $enclosure, $escape);
	}
}