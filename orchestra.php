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

Orchestra\Extension\Config::map('authorize', array(
	'default_role' => 'authorize::authorize.default_role',
));

