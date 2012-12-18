<?php

use Authorize\Presenter\Role as RolePresenter,
	Orchestra\Messages,
	Orchestra\Model\Role;

class Authorize_Roles_Controller extends Authorize\Controller {

	/**
	 * Get default resources landing page.
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		$roles = Role::paginate(30);
		$table = RolePresenter::table($roles);
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
		$msg  = new Messages;

		if ((int) $id === Config::get('authorize::authorize.default_role'))
		{
			$msg->add('error', __('authorize::response.roles.delete-default-failed'));
			return Redirect::to(handles('orchestra::resources/authorize.roles'))
					->with('message', $msg->serialize());
		}

		$role = Orchestra\Model\Role::find($id);

		if (is_null($role)) $m->add('error', __('orchestra::response.db-404'));

		try
		{
			DB::transaction(function () use ($role)
			{
				$role->delete();
			});
		}
		catch (Exception $e)
		{
			$msg->add('error', __('orchestra::response.db-failed'));
		}

		return Redirect::to(handles('orchestra::resources/authorize.roles'))
				->with('message', $msg->serialize());
	}
}