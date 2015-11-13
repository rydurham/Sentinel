@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="large-6 columns">
		<h1>Current Users</h1>
	</div>
	<div class="large-6 columns right">
		<button class="button" onClick="location.href='{{ route('sentinel.users.create') }}'">Create User</button>
	</div>
</div>


<div class="row">
	<table class="full-width">
		<thead>
			<th>User</th>
			<th>Status</th>
			<th>Options</th>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td><a href="{{ action('\\Sentinel\Controllers\UserController@show', array($user->hash)) }}">{{ $user->email }}</a></td>
					<td>{{ $user->status }} </td>
					<td>
						<button class="button small" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@edit', array($user->hash)) }}'">Edit</button>
						@if ($user->status != 'Suspended')
							<button class="button small" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@suspend', array($user->hash)) }}'">Suspend</button>
						@else
							<button class="button small" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@unsuspend', array($user->hash)) }}'">Un-Suspend</button>
						@endif
						@if ($user->status != 'Banned')
							<button class="button small" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@ban', array($user->hash)) }}'">Ban</button>
						@else
							<button class="button small" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@unban', array($user->hash)) }}'">Un-Ban</button>
						@endif
						<button class="button small alert action_confirm" href="{{ action('\\Sentinel\Controllers\UserController@destroy', array($user->hash)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="row">
	{!! $users->render() !!}
</div>
@stop
