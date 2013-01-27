<?php namespace Authorize\Presenter;

use Orchestra\Form,
	Orchestra\Model\Role;

class Extension {
	
	/**
	 * View form generator for Edit Authorize Extension.
	 *
	 * @static
	 * @access public 			
	 * @param  Orchestra\Form   $form
	 * @return void
	 */
	public static function form(Form $form)
	{
		$form->extend(function ($form)
		{
			$form->fieldset(__('authorize::label.roles.configuration'), function ($fieldset)
			{
				$fieldset->control('select', 'default_role', function($control)
				{
					$control->label(__('authorize::label.roles.default'));
					$control->options(Role::lists('name', 'id'));
				});
				$fieldset->control('select', 'member_role', function($control)
				{
					$control->label(__('authorize::label.roles.member'));
					$control->options(Role::lists('name', 'id'));
				});
			});
		});
	}
}