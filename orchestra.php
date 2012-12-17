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
});

Orchestra\Extension\Config::map('authorize', array(
	'default_role' => 'authorize::authorize.default_role',
));

