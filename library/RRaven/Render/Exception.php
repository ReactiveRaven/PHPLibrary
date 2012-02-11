<?php

namespace RRaven\Render;

class Exception {
	
	private static $defaultColours = 
		array(
			"#3366CC", // blue
			"#DC3912", // red
			"#FF9900", // orange
			"#109618", // green
			"#990099", // purple
			"#0099C6", // teal
			"#DD4477", // pink
			"#000000", // black
			"#505050", // grey
		);
	
	/* @var $exception \Exception */
	protected $exception = null;
	
	protected static $defaultOptions = array(
		"height" => 7
	);
	
	protected $options = null;
	protected $colours = null;
	protected $knownClasses = null;
	
	/**
	 * Construct a new Exception rendererer
	 * 
	 * @param \Exception $e
	 * @param array $options 
	 */
	public function __construct(\Exception $e, $options = array()) {
		$this->exception = $e;
		$this->options = array_merge(self::$defaultOptions, $options);
		$this->colours = self::$defaultColours;
		$this->knownClasses = array();
	}
	
	/**
	 * Render an exception out to string.
	 *
	 * @param \Exception $exception
	 * @return string 
	 */
	public static function renderException(\Exception $exception)
	{
		$returns = array();
		$returns[] = 
			"<h1>" . get_class($exception) . ": " .$exception->getMessage() 
			. "</h1>";
		$returns[] = 
			"<p title=\"" . implode(
				"\n", 
				self::pullSnippet(
					$exception->getFile(), 
					$exception->getLine()
				)
			) . "\">" . $exception->getFile() . "(" . $exception->getLine() 
			. ")</p>";
		$returns[] = "<ul>";
		foreach ($exception->getTrace() as $traceLine) {
			$returns[] = "<li>";
			foreach (self::renderTraceLine($traceLine) as $htmlLine) {
				$returns[] = $htmlLine;
			}
			$returns[] = "</li>";
		}
		$returns[] = "</ul>";
		
		return $returns;
	}
	
	/**
	 * Renders a single line from a trace.
	 *
	 * @param array $traceLine
	 * @return string
	 */
	private function renderTraceLine($traceLine) {
		$returns = array();
		
		$traceLine = array_merge(
			array(
				"class" => null,
				"type" => null,
				"function" => null,
				"line" => null,
				"file" => null,
				"args" => null
			),
			$traceLine
		);
		
		foreach (
			$this->renderCall(
				$traceLine["file"],
				$traceLine["line"],
				$traceLine["args"], 
				$traceLine["function"], 
				$traceLine["type"], 
				$traceLine["class"]
			) 
			as $callLine
		) {
			$returns[] = $callLine;
		}
		
		return $returns;
	}
	
	/**
	 * Renders a call to string.
	 * 
	 * @param string $file
	 * @param int $line
	 * @param array $args
	 * @param string $function
	 * @param string $type
	 * @param string $class
	 * @return string
	 */
	private function renderCall(
		$file, 
		$line, 
		$args, 
		$function, 
		$type = null, 
		$class = null
	) {
		$returns = array();
		$returns[] = "<dl>";
		$returns[] = 
			"<dt>" . ($class != null ? $this->renderClassName($class) : $class) 
			. $type . $function . "(" 
			. implode(", ", $this->renderArguments($args, $function, $class)) 
			. ")</dt>";
		$returns[] = 
			"<dd title=\"" . implode("\n", $this->pullSnippet($file, $line)) 
			. "\">" . $file . ":" . $line . "</dd>";
		$returns[] = "</dl>";
		return $returns;
	}
	
	/**
	 * Pulls a snippet of code for context around a specific line in a file.
	 * 
	 * @param string $file
	 * @param int $line
	 * @param int $height
	 * @return string 
	 */
	private function pullSnippet($file, $line, $height = null) {
		
		$height = 
			(
				$height !== null 
					? $height 
					: (
						!isset($this->options["height"])
							? 7 
							: $this->options["height"]
					)
			);
		
		$handle = fopen($file, "r");
		$minLine = $line < $height ? 0 : $line - $height;
		$maxLine = $line + $height;
		$returns = array();
		$i = 0;
		while (($string = fgets($handle)) !== false && $i++ < $maxLine) {
			if ($i > $minLine) {
				if ($i == $line) {
					$returns[] = "";
					$returns[] = "";
				}
				$returns[] = 
					$i . " " 
					. str_replace(
						array("\n", "\t"), 
						array("", "  "), 
						$this->htmlEscape($string)
					);
				if ($i == $line) {
					$returns[] = "";
					$returns[] = "";
				}
			}
		}
		return $returns;
	}
	
	/**
	 * Escape string in a standardised way
	 * 
	 * @param string $string
	 * @return string
	 */
	private function htmlEscape($string) {
		return htmlspecialchars($string, \ENT_QUOTES);
	}
	
	/**
	 * Converts a class name to a HTML string
	 * 
	 * @param string $class
	 * @return string
	 */
	private function renderClassName($class) {
		return 
			"<span style=\"background: " . $this->getClassColour($class) 
			. "; color: white; padding: 0.1em;\">" . $class . "</span>";
	}
	
	/**
	 * Renders all arguments as a HTML string, with argument names if available.
	 * 
	 * @param array $args
	 * @param string $function
	 * @param string $class
	 * @return array|\RRaven_Render_Parameter 
	 */
	private function renderArguments($args, $function, $class = null) {
		$returns = array();
		if ($args == null) {
			return $returns;
		}
		if ($class == null && !function_exists($function)) {
			foreach ($args as $val) {
				$returns[] = new Parameter($val);
			}
			return $returns;
		}
		
		$reflection = (
			$class == null 
				? new \ReflectionFunction($function) 
				: new \ReflectionMethod($class, $function)
		);
		/* @var $reflection ReflectionFunction */
		$params = $reflection->getParameters();
		
		if (count($params) == 0) {
			foreach ($args as $val) {
				$returns[] = new Parameter($val);
			}
			return $returns;
		}
		
		foreach ($args as $index => $val) {
			$returns[] = 
				new Parameter($val, $params[$index]->getName());
		}
		return $returns;
	}
	
	/**
	 * Returns a hex colour to associate with a class
	 * 
	 * @param string $className
	 * @return string
	 */
	private function getClassColour($className) {
		if (!in_array($className, $this->knownClasses)) {
			$this->knownClasses[] = $className;
		}
		return 
			(
				$this->colours[array_search($className, $this->knownClasses) 
				% count($this->colours)]
			);
	}

	/**
	 * Converts the object to a HTML string.
	 * 
	 * @return string
	 */
	public function __toString() {
		return implode("\n", $this->renderException($this->exception));
	}
	
}
