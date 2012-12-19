<?php

/*
|--------------------------------------------------------------------------
| Authorize Library
|--------------------------------------------------------------------------
|
| Map Authorize Library using PSR-0 standard namespace.
*/

Autoloader::namespaces(array(
	'Authorize\Presenter' => Bundle::path('authorize').'presenters'.DS
	'Authorize'           => Bundle::path('authorize').'libraries'.DS,
));
