<?php

use Authorize\Str,
	Orchestra\Acl,
	Orchestra\Model\Role,
	Orchestra\Messages, 
	Orchestra\View;

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
		$lists    = array();
		$selected = Input::get('name', 'orchestra');
		$acls     = Acl::all();
		$active   = null;

		foreach ($acls as $name => $instance)
		{
			$lists[$name] = Str::title($name);

			if ($name === $selected) $active = $instance;
		}

		if (is_null($active)) return Response::error('404');

		$data     = array(
			'_title_'  => __('authorize::title.acls.list'),
			'eloquent' => $active,
			'lists'    => $lists,
			'selected' => $selected,
		);

		return View::make('authorize::acls.index', $data);
	}

	/**
	 * Update ACL metric
	 *
	 * @access public
	 * @return Response
	 */
	public function post_index()
	{
		$acls    = Acl::all();
		$active   = null;

		foreach ($acls as $name => $instance)
		{
			$lists[$name] = Str::title($name);

			if ($name === $selected) $active = $instance;
		}

		if (is_null($active)) return Response::error('404');
	}

	/**
	 * Get sync roles action.
	 *
	 * @access public
	 * @param  string   $name
	 * @return Response
	 */
	public function get_sync($name)
	{
		$msg   = new Messages;
		$roles = array();
		$acls  = Acl::all();

		if ( ! isset($acls[$name])) return Response::error('404');

		$current = $acls[$name];

		foreach (Role::all() as $role)
		{
			$roles[] = $role->name;
		}

		$current->add_roles($roles);
		$msg->add('success', __('authorize::response.acls.sync-roles', array(
			'name' => Str::humanize($name),
		)));

		return Redirect::to(handles("orchestra::resources/authorize.acls?name={$name}"))
				->with('message', $msg->serialize());
	}
}