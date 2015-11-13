@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Groups')

{{-- Content --}}
@section('content')
<div class="row">
	<div class="six columns">
		<h4>Available Groups</h4>
	</div>
	<div class="six columns text-right">
		<div class="medium primary btn">
			<a onClick="location.href='{{ route('sentinel.groups.create') }}'">New Group</a>
		</div>
	</div>
</div>
<div class="row">
  	<div class="twelve columns">
		<table class="rounded striped">
			<thead>
				<th>Name</th>
				<th>Permissions</th>
				<th>Options</th>
			</thead>
			<tbody>
			@foreach ($groups as $group)
				<tr>
					<td><a href="{{ route('sentinel.groups.show', $group->hash) }}"></td>
					<td>
						<?php
							$permissions = $group->getPermissions();
							$keys = array_keys($permissions);
							$last_key = end($keys);
						?>
						@foreach ($permissions as $key => $value)
	    					{{ ucfirst($key) . ($key == $last_key ? '' : ', ') }}
	    				@endforeach
					</td>
					<td>
						<div class="medium info btn">
							<a onClick="location.href='{{ route('sentinel.groups.edit', [$group->hash]) }}'">Edit</a>
						</div>
					 	<div class="medium info btn">
					 		<a class="action_confirm {{ $group->name == 'Admins' ? 'disabled' : '' }}"  data-token="{{ csrf_token() }}" data-method="delete" href="{{ route('sentinel.groups.destroy', [$group->hash]) }}">Delete</a>
					 	</div>
					 </td>
				</tr>
			@endforeach
			</tbody>
		</table>
   	</div>
</div>
<div class="row">
	{!! $groups->render() !!}
</div>
<!--
	The delete button uses Resftulizer.js to restfully submit with "Delete".  The "action_confirm" class triggers an optional confirm dialog.
	Also, I have hardcoded adding the "disabled" class to the Admin group - deleting your own admin access causes problems.
-->
@stop

