<?php

Event::listen('orchestra.started: backend', function ()
{
	$authorize = Orchestra\Resources::make('authorize', array(
		'name' => 'Authorize',
		'uses' => 'authorize::home',
	));
});