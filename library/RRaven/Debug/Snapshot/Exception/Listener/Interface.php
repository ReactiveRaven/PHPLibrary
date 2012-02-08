<?php

interface RRaven_Debug_Snapshot_Exception_Listener_Interface
{
	public function handleSnapshotException(RRaven_Debug_Snapshot_Exception $e);
}