<div class="navbar">
	<div class="navbar-inner">

		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#authorizenav">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		{{ HTML::link(handles('orchestra::resources/authorize'), 'Authorize', array('class' => 'brand')) }}

		<div id="authorizenav" class="collapse nav-collapse">
		  	<ul class="nav">
		  		@if (Orchestra::acl()->can('manage-orchestra'))
				<li class="{{ URI::is('*/resources/authorize.roles*') ? 'active' : '' }}">
					{{ HTML::link(handles('orchestra::resources/authorize.roles'), 'Roles') }}
				</li>
				@endif
			</ul>
		</div>
	</div>
</div>
