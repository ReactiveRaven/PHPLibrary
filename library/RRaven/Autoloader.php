<?php
namespace RRaven;

class Autoloader {
	
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
		
		$classname = ltrim(ltrim($classname, '\\'), "_");
		
		if (count($this->namespaces)) {
			foreach ($this->namespaces as $namespace) {
				if (
					strpos($classname, $namespace . "\\") === 0 
					|| strpos($classname, $namespace . "_")
				) {
					$fileName  = '';
					$namespace = '';
					if (($lastNsPos = strripos($classname, '\\'))) {
						$namespace = substr($classname, 0, $lastNsPos);
						$classname = substr($classname, $lastNsPos + 1);
						$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
					}
					$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
					$file = "/" . trim($this->path, "/") . "/" . $fileName;
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