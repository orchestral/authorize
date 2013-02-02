<?php

use Authorize\Str,
	Orchestra\Acl,
	Orchestra\Extension,
	Orchestra\Model\Role,
	Orchestra\Messages, 
	Orchestra\View;

class Authorize_Acls_Controller extends Authorize\Controller {
	
	/**
	 * Append filter on each construct.
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
		$memory   = Orchestra::memory();

		foreach ($acls as $name => $instance)
		{
			$extension    = $memory->get("extensions.available.{$name}.name", null);
			
			$lists[$name] = (is_null($extension) ? Str::title($name) : $extension);

			if ($name === $selected) $active = $instance;
		}

		if (is_null($active)) return Response::error('404');

		$data     = array(
			'eloquent' => $active,
			'lists'    => $lists,
			'selected' => $selected,
		);

		View::share('_title_', __('authorize::title.acls.list'));

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
		$msg       = new Messages;
		$metric    = Input::get('metric');
		$instances = Acl::all();
		         
		if (is_null($metric) or ! isset($instances[$metric]))
		{
			return Response::error('404');
		}

		$acl = $instances[$metric];

		foreach ($acl->roles()->get() as $role_key => $role_name)
		{
			foreach($acl->actions()->get() as $action_key => $action_name)
			{
				$input = ('yes' === Input::get("acl-{$role_key}-{$action_key}", 'no'));

				$acl->allow($role_name, $action_name, $input);
			}
		}

		Authorize\Core::sync();

		$msg->add('success', __('authorize::response.acls.update'));

		return Redirect::to(handles("orchestra::resources/authorize.acls?name={$metric}"))
				->with('message', $msg->serialize());

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