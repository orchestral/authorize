@include(locate('authorize::widgets.menu'))

<div class="row-fluid">
	
	<div class="page-header">

		<div class="pull-right">
			<a href="{{ URL::current() }}/view" class="btn btn-primary">Add</a>
		</div>
		
		<?php

		$title       = Orchestra\Site::get('title');
		$description = Orchestra\Site::get('description'); ?>

		<div class="page-header">
			<h2>{{ $title ?: 'Authorize' }}
				@if ( ! empty($description))
				<small>{{ $description ?: '' }}</small>
				@endif
			</h2>
		</div>

	</div>

	{{ $table }}

</div>