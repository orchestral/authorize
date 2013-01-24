<?php namespace Authorize\Presenter;

use \Config,
	Orchestra\Form,
	Orchestra\HTML,
	Orchestra\Table;

class Role {
	
	/**
	 * View table generator for Orchestra\Model\Role.
	 *
	 * @static
	 * @access public
	 * @param  Orchestra\Model\Role $model
	 * @return Orchestra\Form
	 */
	public static function table($model)
	{
		return Table::of('authorize.roles', function($table) use ($model)
		{
			$table->empty_message = __('orchestra::label.no-data');

			// Add HTML attributes option for the table.
			$table->attr('class', 'table table-bordered table-striped');

			// attach Model and set pagination option to true
			$table->with($model, true);

			// Add columns
			$table->column('name');

			$table->column('action', function ($column)
			{
				$column->label_attr = array('class' => 'th-action');
				$column->value      = function ($row)
				{
					// @todo need to use language string for this.
					$html = array(
						HTML::link(
							handles("orchestra::resources/authorize.roles/view/{$row->id}"),
							__('orchestra::label.edit'),
							array('class' => 'btn btn-mini btn-warning')
						)
					);

					$roles = array(
						(int) Config::get('orchestra::orchestra.default_role'),
						(int) Config::get('orchestra::orchestra.member_role'),
					);

					if ( ! in_array((int) $row->id, $roles))
					{
						$html[] = HTML::link(
							handles("orchestra::resources/authorize.roles/delete/{$row->id}"),
							__('orchestra::label.delete'),
							array('class' => 'btn btn-mini btn-danger')
						);
					}

					return HTML::create('div', HTML::raw(implode('', $html)), array('class' => 'btn-group'));
				};
			});
		});
	}

	/**
	 * View form generator for Orchestra\Model\Role
	 * 
	 * @static
	 * @access public
	 * @param  Orchestra\Model\Role $model
	 * @return Orchestra\Form
	 */
	public static function form($model)
	{
		return Form::of('authorize.roles', function ($form) use ($model)
		{
			$form->row($model);
			$form->attr(array(
				'action' => handles('orchestra::resources/authorize.roles/view/'.$model->id),
				'method' => 'POST',
			));

			$form->fieldset(function ($fieldset)
			{
				$fieldset->control('input:text', 'name', function ($control)
				{
					$control->label = __('authorize::label.name');
				});
			});
		});
	}
}