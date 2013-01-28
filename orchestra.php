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

			if ($acl->can('manage acl') or $acl->can('manage roles')) return true;

			return false;
		}
	));

	$authorize->roles = 'authorize::roles';
	$authorize->acls  = 'authorize::acls';
});

/*
|--------------------------------------------------------------------------
| Map Authorize Configuration
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
	Authorize\Presenter\Extension::form($form);
});

Event::listen("orchestra.saved: extension.authorize", function($config) 
{
	Config::set('orchestra::orchestra.default_role', (int) $config->default_role);
	Config::set('orchestra::orchestra.member_role', (int) $config->member_role);
	Authorize\Core::sync();
});