<?php

class RRaven_Color {
	
	protected $_hsl = null;
	protected $_rgb = null;
	protected $_hex = null;
	
	/**
	 * Protected to require using the 'from' methods
	**/
	protected function __construct()
	{
		// do nothing!
	}
	
	/**
	 * Returns a RRaven_Color object based on the given RGB array
	 *
	 * @param $rgb int[] red, green, blue values in range 0-255
	**/
	public static function fromRGB($rgb)
	{
		$color = new RRaven_Color();
		$color->_hsl = RRaven_Convert_Color::rgb_to_hsl($rgb);
		return $color;
	}
	
	/**
	 * Returns a RRaven_Color object based on the given Hex string
	 * 
	 * @param $hex string
	**/
	public static function fromHex($hex)
	{
		$color = new RRaven_Color();
		$color->_hsl = RRaven_Convert_Color::hex_to_hsl($hex);
		return $color;
	}
	
	/**
	 * Returns a RRaven_Color object based on the given HSL array
	 *
	 * @param $hsl float[] hue, saturation, luminence values in ranges 0-1
	**/
	public static function fromHSL($hsl)
	{
		$color = new RRaven_Color();
		$color->_hsl = $hsl;
		return $color;
	}
	
	/**
	 * Returns the RGB array of this color.
	 *
	 * @return int[] red, green, blue in range 0-255
	**/
	protected function getRGB()
	{
		if (is_array($this->_rgb)) {
			return $this->_rgb;
		}
		return $this->_rgb = RRaven_Convert_Color::hsl_to_rgb($this->_hsl);
	}
	
	/**
	 * Returns the HSL array of this color.
	 * 
	 * @return int[] red, green, blue in range 0-1
	 */
	public function getHSL()
	{
		return $this->_hsl;
	}
	
	/**
	 * Returns hue degree for this color
	 *
	 * @return int hue in range 0-1
	**/
	public function getHue()
	{
		return $this->_hsl[0];
	}
	
	/**
	 * Returns saturation for this color
	 * 
	 * @return float saturation in range 0-1
	**/
	public function getSaturation()
	{
		return $this->_hsl[1];
	}
	
	/**
	 * Returns lightness for this color
	 *
	 * @return float lightness in range 0-1
	**/
	public function getLightness()
	{
		return $this->_hsl[2];
	}
	
	/**
	 * Returns red value for this color
	 *
	 * @return int red in range 0-255
	**/
	public function getRed()
	{
		$rgb = $this->getRGB();
		return $rgb[0];
	}
	
	/**
	 * Returns green value for this color
	 *
	 * @return int green in range 0-255
	**/
	public function getGreen()
	{
		$rgb = $this->getRGB();
		return $rgb[1];
	}
	
	/**
	 * Returns blue value for this color
	 *
	 * @return int blue in range 0-255
	**/
	public function getBlue()
	{
		$rgb = $this->getRGB();
		return $rgb[2];
	}
	
	/**
	 * Returns hex string value for this color
	 *
	 * @return string
	**/
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
	
	/**
	 * 
	**/
	public function setHue($newHue)
	{
		if ($newHue > 1 || $newHue < 0) {
			throw new InvalidArgumentException("Hue must be a float between 0 and 1");
		}
		$this->_hsl[0] = $newHue;
		$this->_rgb = null;
		$this->_hex = null;
	}
	
	public function setSaturation($newSaturation)
	{
		if ($newSaturation > 1 || $newSaturation < 0) {
			throw new InvalidArgumentException("Saturation must be a float between 0 and 1");
		}
		$this->_hsl[1] = $newSaturation;
		$this->_rgb = null;
		$this->_hex = null;
	}
	
	public function setLightness($newLightness)
	{
		if ($newLightness > 1 || $newLightness < 0) {
			throw new InvalidArgumentException("Lightness must be a float between 0 and 1");
		}
		$this->_hsl[2] = $newLightness;
		$this->_rgb = null;
		$this->_hex = null;
	}
	
}