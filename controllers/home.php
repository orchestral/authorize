<?php

class Authorize_Home_Controller extends Authorize\Controller {

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