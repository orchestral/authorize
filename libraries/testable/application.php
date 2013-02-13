<?php namespace Authorize\Testable;

use Orchestra\Extension,
	Orchestra\Testable\Application as A;

class Application extends A {
	
	/**
	 * Construct a new application
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		Extension::detect();
		Extension::activate('authorize');
	}

	/**
	 * Shutdown application.
	 *
	 * @access public
	 * @return void
	 */
	public function shutdown()
	{
		Extension::deactivate('authorize');

		parent::shutdown();
	}
}