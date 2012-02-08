<?php

class RRaven_Debug_Snapshot_Exception_Handler
{
	protected $previousHandler = null;
	protected $listeners = array();
	
	public function __construct()
	{
		$this->previousHandler = 
			set_exception_handler(array($this, "exception"));
	}
	
	public function addSnapshotListener(
		RRaven_Debug_Snapshot_Exception_Listener_Interface $listener
	)
	{
		$this->listeners[] = $listener;
	}
	
	public function removeSnapshotListener(
		RRaven_Debug_Snapshot_Exception_Listener_Interface $listener
	)
	{
		while (($key = array_search($listener, $this->listeners)) !== false)
		{
			unset($this->listeners[$key]);
		}
	}
	
	public function exception(Exception $exception) {
		$snapshot = new RRaven_Debug_Snapshot_Exception($exception);
		foreach (
			$this->listeners 
			as /* @var $listener RRaven_Debug_Snapshot_Exception_Listener_Interface */ $listener
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