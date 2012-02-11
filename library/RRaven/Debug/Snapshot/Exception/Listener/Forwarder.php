<?php

namespace RRaven\Debug\Snapshot\Exception\Listener;

use RRaven\Debug\Snapshot\Exception as SnapshotException;
use RRaven\Debug\Snapshot\Exception\Listener_Interface as SnapshotListenerInterface;

class Forwarder
	implements SnapshotListenerInterface
{
	protected $url = null;
	
	public function __construct(
		$url = "http://api.dmgodfrey.co.uk/snapshot/exception"
	)
	{
		$this->url = $url;
	}
	
	public function handleSnapshotException(SnapshotException $e)
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