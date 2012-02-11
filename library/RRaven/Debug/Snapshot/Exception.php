<?php

namespace RRaven\Debug\Snapshot;

class Exception
{
	protected $exception = null;
	protected $environment = null;
	
	const VERSION = 1;
	
	public function __construct(
		\Exception $exception, 
		Environment $environment = null
	)
	{
		$this->exception = $exception;
		$this->environment = 
			(
				$environment !== null 
					? $environment 
					: new Environment()
			);
	}
	
	public function getException()
	{
		return $this->exception;
	}
	
	public function getEnvironment()
	{
		return $this->environment;
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
						"trace" => $this->exception->getTrace()
					)
				),
				$this->environment->toArray()
			);
	}
}