<?php

namespace RRaven\Debug\Snapshot\Exception;

use RRaven\Debug\Snapshot\Exception\Listener_Interface as SnapshotListenerInterface;
use RRaven\Debug\Snapshot\Exception as SnapshotException;

class Handler
{
	protected $previousHandler = null;
	protected $listeners = array();
	
	public function __construct()
	{
		$this->previousHandler = 
			set_exception_handler(array($this, "exception"));
	}
	
	public function addSnapshotListener(
		SnapshotListenerInterface $listener
	)
	{
		$this->listeners[] = $listener;
	}
	
	public function removeSnapshotListener(
		SnapshotListenerInterface $listener
	)
	{
		while (($key = array_search($listener, $this->listeners)) !== false)
		{
			unset($this->listeners[$key]);
		}
	}
	
	public function exception(Exception $exception) {
		$snapshot = new SnapshotException($exception);
		foreach (
			$this->listeners 
			as /* @var $listener SnapshotListenerInterface */ $listener
		)
		{
			$listener->handleSnapshotException($snapshot);
		}
		
		if ($this->previousHandler !== null)
		{
			call_user_func($this->previousHandler, $exception);
		}
	}
	
	
}