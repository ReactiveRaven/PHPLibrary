<?php

namespace RRaven;

use \RRaven\Convert\Color as Converter;

class Color {
	
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
		$color = new Color();
		$color->_hsl = Converter::rgb_to_hsl($rgb);
		return $color;
	}
	
	/**
	 * Returns a RRaven_Color object based on the given Hex string
	 * 
	 * @param $hex string
	**/
	public static function fromHex($hex)
	{
		$color = new Color();
		$color->_hsl = Converter::hex_to_hsl($hex);
		return $color;
	}
	
	/**
	 * Returns a RRaven_Color object based on the given HSL array
	 *
	 * @param $hsl float[] hue, saturation, luminence values in ranges 0-1
	**/
	public static function fromHSL($hsl)
	{
		$color = new Color();
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
		return $this->_rgb = Converter::hsl_to_rgb($this->_hsl);
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
						Converter::rgb_to_hex($this->getRGB())
			);
	}
	
	/**
	 * Sets the hue of the colour.
	 * The hue is expected as a float between 0 and 1.
	 *
	 * @param $newHue float
	 * @return RRaven_Color $this
	**/
	public function setHue($newHue)
	{
		if ($newHue > 1 || $newHue < 0) {
			throw new \InvalidArgumentException("Hue must be a float between 0 and 1");
		}
		$this->_hsl[0] = $newHue;
		$this->_rgb = null;
		$this->_hex = null;
		
		return $this;
	}
	
	/**
	 * Sets the saturation of the colour.
	 * The saturation is expected as a float between 0 and 1.
	 *
	 * @param $newSaturation
	 * @return RRaven_Color $this
	**/
	public function setSaturation($newSaturation)
	{
		if ($newSaturation > 1 || $newSaturation < 0) {
			throw new \InvalidArgumentException("Saturation must be a float between 0 and 1");
		}
		$this->_hsl[1] = $newSaturation;
		$this->_rgb = null;
		$this->_hex = null;
		
		return $this;
	}
	
	/**
	 * Sets the lightness/brightness of the colour.
	 * The lightness is expected as a float between 0 and 1.
	 *
	 * @param $newLightness
	 * @return RRaven_Color $this
	**/
	public function setLightness($newLightness)
	{
		if ($newLightness > 1 || $newLightness < 0) {
			throw new \InvalidArgumentException("Lightness must be a float between 0 and 1");
		}
		$this->_hsl[2] = $newLightness;
		$this->_rgb = null;
		$this->_hex = null;
		
		return $this;
	}
	
	/**
	 * Sets the red component of the colour.
	 * Expected as an integer between 0 and 255
	 *
	 * @param $red
	 * @return RRaven_Color $this
	**/
	public function setRed($red) {
		
		if (!is_int($red) || $red < 0 || $red > 255)
		{
			throw new \InvalidArgumentException("Red component must be an integer between 0 and 255");
		}
		
		$rgb = $this->getRGB();
		$rgb[0] = $red;
		
		$this->_hsl = Converter::rgb_to_hsl($rgb);
		$this->_rgb =$rgb;
		$this->_hex = null;
		
		return $this;
	}
	
	/**
	 * Sets the green component of the colour.
	 * Expected as an integer between 0 and 255
	 *
	 * @param $green
	 * @return RRaven_Color $this
	**/
	public function setGreen($green) {
		if (!is_int($green) || $green < 0 || $green > 255)
		{
			throw new \InvalidArgumentException("Green component must be an integer between 0 and 255");
		}
		
		$rgb = $this->getRGB();
		$rgb[1] = $green;
		
		$this->_hsl = Converter::rgb_to_hsl($rgb);
		$this->_rgb = $rgb;
		$this->_hex = null;
		
		return $this;
	}
	
	/**
	 * Sets the blue component of the colour.
	 * Expected as an integer between 0 and 255
	 *
	 * @param $blue
	 * @return RRaven_Color $this
	**/
	public function setBlue($blue) {
		if (!is_int($blue) || $blue < 0 || $blue > 255)
		{
			throw new \InvalidArgumentException("Blue component must be an integer between 0 and 255");
		}
		
		$rgb = $this->getRGB();
		$rgb[2] = $blue;
		
		$this->_hsl = Converter::rgb_to_hsl($rgb);
		$this->_rgb = $rgb;
		$this->_hex = null;
		
		return $this;
	}
}