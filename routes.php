<?php

/*
|--------------------------------------------------------------------------
| Route Filtering
|--------------------------------------------------------------------------
*/

Route::filter('authorize::manage-roles', function ()
{
	if ( ! Orchestra::acl()->can('manage-roles')) 
	{
		if (Auth::guest())
		{
			Session::flash('orchestra.redirect', Input::get('redirect'));
			return Redirect::to(handles('orchestra::login'));
		}

		return Redirect::to(handles('orchestra'));
	}
});

Route::filter('authorize::manage-acl', function ()
{
	if ( ! Orchestra::acl()->can('manage-acl')) 
	{
		if (Auth::guest())
		{
			Session::flash('orchestra.redirect', Input::get('redirect'));
			return Redirect::to(handles('orchestra::login'));
		}
		
		return Redirect::to(handles('orchestra'));
	}
});