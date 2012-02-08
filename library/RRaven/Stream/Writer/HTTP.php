<?php

class RRaven_Stream_Writer_HTTP 
	extends RRaven_Stream_Writer_Abstract
{
	protected $_method = null;
	protected $_handle = null;
	protected $_url    = null;
	
	protected $_last_request = null;
	
	public function __construct($url, $headers, $method = "POST")
	{
		$this->_url = $url;
		$this->_handle = curl_init($url);
		$method = 
			(
				in_array($method, array("GET", "POST", "PUT", "DELETE"))
					? $method
					: "POST"
			);
		curl_setopt($this->_handle, CURLOPT_RETURNTRANSFER);
		foreach ($headers as $header) {
			curl_setopt($this->_handle, CURLOPT_HEADER, $header);
		}
		
		curl_setopt($this->_handle, CURLINFO_HEADER_OUT);
		
		switch ($method) {
			case "PUT":
				curl_setopt($this->_handle, CURLOPT_PUT, true);
				break;
			case "POST":
				curl_setopt($this->_handle, CURLOPT_POST, true);
				break;
			case "DELETE":
				curl_setopt($this->_handle, CURLOPT_CUSTOMREQUEST, "DELETE");
				break;
		}
	}
	
	protected function params_to_string($params)
	{
		$string = array();
		foreach ($params as $key => $val) {
			$string[] = $key . "=" . $val;
		}
		return implode("&", $string);
	}
	
	public function write_one($row)
	{
		if ($this->_method == "GET")
		{
			curl_setopt(
				$this->_handle, 
				CURLOPT_URL, 
				$this->_url . "?" . $this->params_to_string($row)
			);
		}
		else 
		{
			curl_setopt($this->_handle, CURLOPT_POSTFIELDS, $row);
		}
		$this->_last_request = curl_exec($this->_handle);
	}
	
	/**
	 * Returns the response body from the last request
	 * @return type 
	 */
	public function get_last_request()
	{
		return 
			array_merge(
				array("body" => $this->_last_request),
				curl_getinfo($this->_handle)
			);
	}
}