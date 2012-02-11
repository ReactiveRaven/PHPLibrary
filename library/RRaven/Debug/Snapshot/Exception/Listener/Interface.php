<?php

namespace RRaven\Debug\Snapshot\Exception;

use RRaven\Debug\Snapshot\Exception as SnapshotException;

interface Listener_Interface
{
	public function handleSnapshotException(SnapshotException $e);
}