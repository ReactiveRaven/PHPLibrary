<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Environment
 *
 * @author david
 */
class RRaven_Debug_Snapshot_Environment
{
	protected $data = array();
	
	const VERSION = 1;
	
	public function __construct()
	{
		
		$this->data["_COOKIE"] = array();
		foreach ($_COOKIE as $key => $val) {
			$this->data["_COOKIE"][$key] = serialize($val);
		}
		
		$this->data["_ENV"] = array();
		foreach ($_ENV as $key => $val) {
			$this->data["_ENV"][$key] = serialize($val);
		}
		
		$this->data["_FILES"] = array();
		foreach ($_FILES as $key => $val) {
			$this->data["_FILES"][$key] = serialize($val);
		}
		
		$this->data["_GET"] = array();
		foreach ($_GET as $key => $val) {
			$this->data["_GET"][$key] = serialize($val);
		}
		
		$this->data["GLOBALS"] = array();
		foreach ($GLOBALS as $key => $val) {
			$this->data["GLOBALS"][$key] = serialize($val);
		}
		
		$this->data["_POST"] = array();
		foreach ($_POST as $key => $val) {
			$this->data["_POST"][$key] = serialize($val);
		}
		
		$this->data["_REQUEST"] = array();
		foreach ($_REQUEST as $key => $val) {
			$this->data["_REQUEST"][$key] = serialize($val);
		}
		
		$this->data["_SERVER"] = array();
		foreach ($_SERVER as $key => $val) {
			$this->data["_SERVER"][$key] = serialize($val);
		}
		
		$this->data["_SESSION"] = array();
		foreach ($_SESSION as $key => $val) {
			$this->data["_SESSION"][$key] = serialize($val);
		}
		
		$this->data["constants"] = get_defined_constants(true);
		
		$this->data["classes"] = get_declared_classes();
		
		$this->data["files"] = get_included_files();
		
		$this->data["path"] = get_include_path();
		
		$this->data["headers"] = headers_list();
		
		
	}
	
	public function toArray()
	{
		return array("environment" => $this->data);
	}
}

?>
