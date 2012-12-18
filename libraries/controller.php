<?php namespace Authorize;

use \Controller as Base_Controller;

abstract class Controller extends Base_Controller {
	
	/**
	 * Use restful verb.
	 *
	 * @var boolean
	 */
	public $restful = true;
}
