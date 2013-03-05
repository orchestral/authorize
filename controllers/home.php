<?php

use Orchestra\Site,
	Orchestra\View;

class Authorize_Home_Controller extends Authorize\Controller {

	/**
	 * Append filter on each construct
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Get default resources landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		Site::set('title', 'Authorize');

		return View::make('authorize::home');
	}
}