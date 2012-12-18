<?php

/*
|--------------------------------------------------------------------------
| Register Authorize
|--------------------------------------------------------------------------
|
| Register Authorize as Orchestra Resources.
|
*/

Event::listen('orchestra.started: backend', function ()
{
	$authorize = Orchestra\Resources::make('authorize', array(
		'name' => 'Authorize',
		'uses' => 'authorize::home',
	));

	$authorize->roles = 'authorize::roles';
	$authorize->acls  = 'authorize::acls';
});


/*
|--------------------------------------------------------------------------
| Hook Authorize Configuration
|--------------------------------------------------------------------------
|
| Allow Orchestra Extension Configuration page to configure Authorize 
| options.
|
*/

Orchestra\Extension\Config::map('authorize', array(
	'default_role' => 'authorize::authorize.default_role',
));


Event::listen('orchestra.form: extension.authorize', function ($config, $form)
{
	$form->extend(function ($form) use ($config)
	{
		$form->fieldset('', function ($fieldset) use ($config)
		{
			$fieldset->control('select', 'default_role', function($control) use ($config)
			{
				$control->label   = 'Default Role';
				$control->options = Orchestra\Model\Role::lists('name', 'id');
			});
		});
	});
});

Event::listen("orchestra.saved: extension.authorize", function($config) 
{
	$role = Orchestra\Model\Role::find($config->default_role);
	$acl  = Orchestra\Core::acl();
	
	$acl->allow($role->name, array(
		'Manage Users', 
		'Manage Orchestra',
		'Manage Roles',
		'Manage Acl',
	));
});