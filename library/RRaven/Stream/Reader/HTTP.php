<?php
class RRaven_Stream_Reader_HTTP 
	extends RRaven_Stream_Reader_Abstract 
{
	
	private $url = null;
	private $body = null;
	private $index = 0;
	
	public function __construct($url) {
		$this->url = $url;
	}
	
	private function getBody() {
		return (
			$this->body === null 
				? $this->body = $this->fetchBody() 
				: $this->body
		);
	}
	
	private function fetchBody() {
		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return explode("\n", curl_exec($ch));
	}
	
	public function current() {
		$body = $this->getBody();
		return $body[$this->index];
	}
	
	public function key() {
		return $this->index;
	}
	
	public function next() {
		$this->index += 1;
	}
	
	public function rewind() {
		$this->index = 0;
	}
	
	public function valid() {
		$body = $this->getBody();
		return isset($body[$this->index]);
	}
	
}