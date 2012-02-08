<?php

class RRaven_Debug_Snapshot_Exception_Listener_Forwarder
	implements RRaven_Debug_Snapshot_Exception_Listener_Interface
{
	protected $url = null;
	
	public function __construct(
		$url = "http://api.dmgodfrey.co.uk/snapshot/exception"
	)
	{
		$this->url = $url;
	}
	
	public function handleSnapshotException(RRaven_Debug_Snapshot_Exception $e)
	{
		$json = json_encode($e->toArray());
		try
		{
			$envelope = 
				array(
					"header" => 
						array(
							"action" => "snapshot/exception", 
							"version" => 1, 
							"format" => "json"
						), 
					"body" => array("json" => $json)
				);
			$stream = new RRaven_Stream_Writer_HTTP($this->url, array(), "PUT");
			$stream->write_one($envelope);
		}
		catch (Exception $e) {
			/* Ignore transport exceptions, to prevent infinite loops */
		}
	}
}