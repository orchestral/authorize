<?php

class Authorize_Acls_Controller extends Authorize\Controller {
	
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