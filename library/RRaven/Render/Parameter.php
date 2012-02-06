<?php

class RRaven_Render_Parameter
{
	private $variable = null;
	private $label = null;
	
	/**
	 * Creates a new Parameter object for rendering.
	 * Simply convert to a string to get the output (eg: (string)$param)
	 *
	 * @param mixed $variable
	 * @param string $label 
	 */
	public function __construct($variable, $label = null)
	{
		$this->variable = $variable;
		$this->label = $label;
	}
	
	/**
	 * Output the parameter as a string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return 
			(
				$this->label !== null 
					? "<span style=\"color: grey;\">" . $this->label 
						. " </span>" 
					: ""
			) . $this->stringify($this->variable);

	}
	
	/**
	 * Converts a variable to a string for outputting in debugging information.
	 *
	 * @param mixed $variable
	 * @return string 
	 */
	private function stringify($variable) 
	{
		if (is_null($variable)) 
		{
			return "NULL";
		} 
		else if ($variable === false) 
		{
			return "FALSE";
		} 
		else if ($variable === true) 
		{
			return "TRUE";
		} 
		else if (is_array($variable)) 
		{
			$array = array();
			foreach ($variable as $val) 
			{
				$array[] = $this->stringify($val);
			}
			return "[" . implode(", ", $array) . "]";
		} 
		else if (empty($variable)) 
		{
			return "\"\"";
		} 
		else if (is_object($variable)) 
		{
			return 
				"<span title=\"" 
				. htmlentities(serialize($variable), ENT_QUOTES) . "\">" 
				. get_class($variable) . "</span>";
		} 
		else
		{
			return "\"" . $this->htmlEscape($variable, ENT_QUOTES) . "\"";
		}
	}
}