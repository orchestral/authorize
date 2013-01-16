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
		'name'    => 'Authorize',
		'uses'    => 'authorize::home',
		'visible' => function ()
		{
			$acl = Orchestra::acl();

			if ($acl->can('manage acl') or $acl->can('manage roles'))
			{
				return true;
			}

			return false;
		}
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
	'default_role' => 'orchestra::orchestra.default_role',
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
	Config::set('orchestra::orchestra.default_role', (int) $config->default_role);
	Authorize\Core::sync();
});