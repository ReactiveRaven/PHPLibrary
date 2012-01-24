<?php

abstract class RRaven_Stream_Writer_Abstract {
	
	/**
	 * Takes a collection of rows to write
	 *
	 * @param array|traversable $multiple_rows 
	 */
	public function write_many($multiple_rows) {
		foreach ($multiple_rows as $row) {
			$this->write_one($row);
		}
	}
	
	/**
	 * Takes a single row to write.
	 * 
	 * @param mixed $row
	 * @throws Exception when writer is already closed
	 */
	abstract public function write_one($row);
	
	/**
	 * Cleans up the writer and closes resoures.
	 * May be called multiple times.
	 */
	abstract public function close();
	
	/**
	 * Called when the object is finished with (no longer kept in a variable, 
	 * or when the PHP script finishes). 
	 * Closes the writer.
	 */
	public function __destruct() {
		$this->close();
	}
	
}