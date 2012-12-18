<?php namespace Authorize;

use \Controller as Base_Controller;

abstract class Controller extends Base_Controller {
	
	/**
	 * Use restful verb.
	 *
	 * @var boolean
	 */
	public $restful = true;

	/**
	 * Append filter on each construct
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'orchestra::manage');
	}
}
