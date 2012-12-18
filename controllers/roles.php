<?php

class Authorize_Roles_Controller extends Authorize\Controller {

	/**
	 * Get default resources landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		$roles = Orchestra\Model\Role::paginate(30);
		$table = Authorize\Presenter\Role::table($roles);
		$data  = array(
			'eloquent' => $roles,
			'table'    => $table,
		);

		View::share('_title_', __('authorize::title.roles.list'));

		return View::make('authorize::roles.index', $data);
	}

	/**
	 * Delete a role
	 *
	 * @access public
	 * @param  int      $id
	 * @return Response
	 */
	public function get_delete($id)
	{
		
	}
}