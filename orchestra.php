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
	'member_role'  => 'orchestra::orchestra.member_role',
));


Event::listen('orchestra.form: extension.authorize', function ($config, $form)
{
	$form->extend(function ($form) use ($config)
	{
		$form->fieldset(__('authorize::label.roles.configuration'), function ($fieldset) use ($config)
		{
			$fieldset->control('select', 'default_role', function($control) use ($config)
			{
				$control->label   = __('authorize::label.roles.default');
				$control->options = Orchestra\Model\Role::lists('name', 'id');
			});
			$fieldset->control('select', 'member_role', function($control) use ($config)
			{
				$control->label   = __('authorize::label.roles.member');
				$control->options = Orchestra\Model\Role::lists('name', 'id');
			});
		});
	});
});

Event::listen("orchestra.saved: extension.authorize", function($config) 
{
	Config::set('orchestra::orchestra.default_role', (int) $config->default_role);
	Config::set('orchestra::orchestra.member_role', (int) $config->member_role);
	Authorize\Core::sync();
});