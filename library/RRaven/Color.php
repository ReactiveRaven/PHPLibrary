<?php

abstract class RRaven_Color {
	
	protected $_hsl = null;
	protected $_rgb = null;
	protected $_hex = null;
	
	protected function __construct();
	
	public static function fromRGB($rgb)
	{
		$color = new RRaven_Color();
		$color->_hsl = RRaven_Convert_Color::rgb_to_hsl($rgb);
		return $color;
	}
	
	public static function fromHex($hex)
	{
		$color = new RRaven_Color();
		$color->_hsl = RRaven_Convert_Color::hex_to_hsl($hex);
		return $color;
	}
	
	protected function getRGB()
	{
		if (is_array($this->_rgb)) {
			return $this->_rgb;
		}
		return $this->_rgb = RRaven_Convert_Color::hsl_to_rgb($this->_hsl);
	}
	
	public function getHue()
	{
		return $this->_hsl[0];
	}
	
	public function getSaturation()
	{
		return $this->_hsl[1];
	}
	
	public function getBrightness()
	{
		return $this->_hsl[2];
	}
	
	public function getRed()
	{
		$rgb = $this->getRGB();
		return $rgb[0];
	}
	
	public function getGreen()
	{
		$rgb = $this->getRGB();
		return $rgb[1];
	}
	
	public function getBlue()
	{
		$rgb = $this->getRGB();
		return $rgb[2];
	}
	
	public function getHex()
	{
		return 
			(
				$this->_hex !== null
					? $this->_hex
					: $this->_hex = 
						RRaven_Convert_Color::rgb_to_hex($this->getRGB())
			);
	}
	
}