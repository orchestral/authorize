<?php

use Authorize\Presenter\Role as RolePresenter,
	Orchestra\Messages,
	Orchestra\Model\Role,
	Orchestra\View;

class Authorize_Roles_Controller extends Authorize\Controller {

	/**
	 * Append filter on each construct
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->filter('before', 'authorize::manage-roles');
	}

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
	 * Show edit a role
	 *
	 * GET (orchestra)/resources/authorize.roles/view/(:id)
	 *
	 * @access public
	 * @param  int      $id
	 * @return Response
	 */
	public function get_view($id = null)
	{
		$type = 'update';
		$page = Role::find($id);

		if (is_null($page))
		{
			$type = 'create';
			$page = new Role;
		}

		$form = RolePresenter::form($page);

		$data = array(
			'eloquent' => $page,
			'form'     => $form,
		);

		View::share('_title_', __("authorize::title.roles.{$type}"));

		return View::make('authorize::roles.edit', $data);
	}

	/**
	 * Update a role
	 *
	 * POST (orchestra)/resources/authorize.roles/view/(:id)
	 *
	 * @access public
	 * @param  int      $id
	 * @return Response
	 */
	public function post_view($id = null)
	{
		$input   = Input::all();
		$role_id = $id ?: "0";

		$rules = array(
			'name' => array(
				'required',
				"unique:roles,name,{$role_id}",
			),
		);

		$msg = new Messages;
		$val = Validator::make($input, $rules);

		if ($val->fails())
		{
			return Redirect::to(handles("orchestra::resources/authorize.roles/view/{$id}"))
					->with_input()
					->with_errors($val);
		}

		$type = 'update';
		$role = Role::find($id);

		if (is_null($role))
		{
			$type = 'create';
			$role = new Role;
		}

		$role->name = $input['name'];
		$role->save();

		$msg->add('success', __("authorize::response.roles.{$type}", array(
			'name' => $role->name,
		)));

		return Redirect::to(handles('orchestra::resources/authorize.roles'))
			->with('message', $msg->serialize());
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

		if ((int) $id === (int) Config::get('authorize::authorize.default_role'))
		{
			$msg->add('error', __('authorize::response.roles.delete-default-failed'));
			return Redirect::to(handles('orchestra::resources/authorize.roles'))
					->with('message', $msg->serialize());
		}

		$role = Role::find($id);

		if (is_null($role)) $m->add('error', __('orchestra::response.db-404'));

		try
		{
			DB::transaction(function () use ($role)
			{
				$role->delete();
			});

			$msg->add('success', __('authorize::response.roles.delete', array(
				'name' => $role->title,
			)));
		}
		catch (Exception $e)
		{
			$msg->add('error', __('orchestra::response.db-failed'));
		}

		return Redirect::to(handles('orchestra::resources/authorize.roles'))
				->with('message', $msg->serialize());
	}
}