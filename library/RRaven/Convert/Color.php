<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Color
 *
 * @author godfred7
 */
class RRaven_Convert_Color {
	
	static function rgb_to_hsl($rgb)
	{
		foreach (array_keys($rgb) as $key) {
			$rgb[$key] /= 255;
		}
		$max = max($rgb);
		$min = min($rgb);
		$r = $rgb[0];
		$g = $rgb[1];
		$b = $rgb[2];
		
		$h = $s = $l = ($max + $min) / 2;
	

		if ($max == $min) {
			$h = $s = 0; // achromatic
		} else {
			$d = $max - $min;
			$s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
			if ($max == $rgb[0]) {
				$h = ($g - $b) / $d + ($g < $b ? 6 : 0);
			} else if ($max == $rgb[1]) {
				$h = ($b - $r) / $d + 2;
			} else {
				$h = ($r - $g) / $d + 4;
			}
			$h /= 6;
		}

		return array($h, $s, $l);
	}
	
	private static function hue_to_rgb($p, $q, $t)
	{
		if($t < 0) $t += 1;
		if($t > 1) $t -= 1;
		if($t < 1/6) return $p + ($q - $p) * 6 * $t;
		if($t < 1/2) return $q;
		if($t < 2/3) return $p + ($q - $p) * (2/3 - $t) * 6;
		return $p;
	}
	
	static function hsl_to_rgb($hsl) {
		$h = $hsl[0];
		$s = $hsl[1];
		$l = $hsl[2];
		
		$r = $g = $b = null;

		if($s == 0){
			$r = $g = $b = $l; // achromatic
		} else {
			

			$q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
			$p = 2 * $l - $q;
			$r = self::hue_to_rgb($p, $q, $h + 1/3);
			$g = self::hue_to_rgb($p, $q, $h);
			$b = self::hue_to_rgb($p, $q, $h - 1/3);
		}

		return array($r * 255, $g * 255, $b * 255);
	}
	
	static function hsl_to_hex($hsl) {
		return self::rgb_to_hex(self::hsl_to_rgb($hsl));
	}
	
	static function rgb_to_hex($rgb) {
		return "#" . dechex($rgb[0]) . dechex($rgb[1]) . dechex($rgb[2]);
	}
	
	static function hex_to_rgb($hex)
	{
		self::check_hex($hex);
		$hex = trim($hex, "#");
		$return = str_split($hex, 2);
		foreach ($return as $key => $val) {
			$return[$key] = hexdec($val);
		}
		return $return;
	}
	
	static function is_valid_hex($hex) 
	{
		return preg_match("/^[#]?[0-9abcdef]{6}$/i", $hex);
	}
	
	static function is_valid_rgb($rgb) 
	{
		foreach ($rgb as $val) {
			if (!is_int($val) || $val < 0 || $val > 255) {
				return false;
			}
		}
		
		return true;
	}
	
	static protected function check_hex($hex) 
	{
		if (!self::is_valid_hex($hex)) {
			throw new InvalidArgumentException("Not a valid hex color value");
		}
	}
	
	static protected function check_rgb($rgb) {
		if (!self::is_valid_rgb($rgb)) {
			throw new InvalidArgumentException("Not a valid rgb color value");
		}
	}
	
	static function hex_to_hsl($hex) 
	{
		self::check_hex($hex);
		return self::rgb_to_hsl(self::hex_to_rgb($hex));
	}
}

?>
