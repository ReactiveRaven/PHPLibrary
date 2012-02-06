<?php

class RRaven_Debug_Snapshot_Exception
{
	protected $exception = null;
	protected $environment = null;
	
	const VERSION = 1;
	
	public function __construct(Exception $exception)
	{
		$this->exception = $exception;
		$this->environment = new RRaven_Debug_Snapshot_Environment();
	}
	
	public function toArray()
	{
		return 
			array_merge(
				array(
					"exception" => array(
						"object" => $this->exception,
						"code" => $this->exception->getCode(),
						"file" => $this->exception->getFile(),
						"line" => $this->exception->getLine(),
						"message" => $this->exception->getMessage(),
						"previous" => $this->exception->getPrevious(),
						"trace" => $this->exception->getTrace()
					)
				),
				$this->environment->toArray()
			);
	}
}