<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Abstract
 *
 * @author godfred7
 */
abstract class RRaven_Transform_Abstract {
	
	abstract public function will_accept($input)
	{
		return false;
	}
	
	abstract public function transform($input);
	
}
?>
