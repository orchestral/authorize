@include(locate('authorize::widgets.menu'))

<div class="row-fluid">
	
	@include(locate('orchestra::layout.widgets.header'))

	<div class="navbar hidden-phone">
		<div class="navbar-inner">
			{{ Form::open(URL::current(), 'GET', array('class' => 'navbar-form')) }}
				<div class="pull-left">
					{{ Form::select('name', $lists, $selected, array('class' => 'input-xlarge')) }}&nbsp;
				</div>
				<div class="pull-left">
					<button type="submit" class="btn btn-primary">{{ __('orchestra::label.submit') }}</button>
				</div>
			{{ Form::close() }}
		</div>
	</div>

	{{ Form::open(URL::current(), 'POST') }}
		{{ Form::hidden('metric', $selected) }}
		<div class="accordion" id="acl-accordion">
		@foreach ($eloquent->roles()->get() as $role_key => $role_name)
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" 
						data-parent="#acl-accordion" href="#collapse{{ $role_key }}">
						{{ Authorize\Str::humanize($role_name) }}
					</a>
				</div>
				<div id="collapse{{ $role_key }}" class="accordion-body collapse in">
					<div class="accordion-inner">
						@foreach($eloquent->actions()->get() as $action_key => $action_name)
							<label for="acl-{{ $role_key }}-{{ $action_key }}" class="checkbox inline">
								{{ Form::checkbox("acl-{$role_key}-{$action_key}", 'yes', $eloquent->check($role_name, $action_name), array('id' => "acl-{$role_key}-{$action_key}")) }}
								{{ Authorize\Str::humanize($action_name) }}&nbsp;&nbsp;&nbsp;
							</label>
						@endforeach
					</div>
				</div>
			</div>
		@endforeach
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">{{ __('orchestra::label.submit') }}</button>
			{{ HTML::link(handles("orchestra::resources/authorize.acls/sync/{$selected}"), __('authorize::label.sync-roles'), array('class' => 'btn')) }}
		</div>
	{{ Form::close() }}
</div>