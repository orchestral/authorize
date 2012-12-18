<?php

class Authorize_Acls_Controller extends Authorize\Controller {
	
	/**
	 * Append filter on each construct
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'authorize::manage-acl');
	}
	
	/**
	 * Get default resources landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		return View::make('authorize::home');
	}
}