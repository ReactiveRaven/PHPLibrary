<?php

class RRaven_Autoloader {
	
	protected $namespaces = null;
	protected $path = null;
	
	public function __construct($prefix = "RRaven", $path = null) {
		
		if (is_string($prefix)) {
			$prefix = array($prefix);
		} else if ($prefix === null) {
			$prefix = array("RRaven");
		} else if (!is_array($prefix)) {
			throw new Exception("Cannot understand the prefix(es) passed in");
		}
		$this->namespaces = $prefix;
		
		if ($path === null) {
			$path = realpath(dirname(__FILE__) . "/../");
		}
		$this->path = $path;
		
		spl_autoload_register(array($this, "load"));
	}
	
	public function load($classname) {
		if (count($this->namespaces)) {
			foreach ($this->namespaces as $namespace) {
				if (strpos($classname, $namespace . "_") === 0) {
					$file = 
						"/" . trim($this->path, "/") . "/" 
						. trim(str_replace("_", "/", $classname), "/") . ".php";
					if (is_readable($file)) {
						try {
							include $file;
						} catch (Exception $e) {
							/* Do nothing */
						}
					}
				}
			}
		}
	}
	
}