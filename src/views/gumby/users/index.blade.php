@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title', 'Home')

{{-- Content --}}
@section('content')
<div class="row">
	<div class="twelve columns">
		<h4>Current Users:</h4>
	</div>
</div>
<div class="row">
  <div class="twelve columns">
	<table class="rounded striped">
		<thead>
			<th>User</th>
			<th>Status</th>
			<th>Options</th>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td><a href="{{ action('Sentinel\UserController@show', array($user->hash)) }}">{{ $user->email }}</a></td>
					<td>{{ $user->status }} </td>
					<td>
						<div class="medium info btn">
							<a onClick="location.href='{{ action('Sentinel\UserController@edit', array($user->hash)) }}'">Edit</a> 
						</div>
						@if ($user->status != 'Suspended')
							<div class="medium info btn">
								<a onClick="location.href='{{ route('sentinel.users.suspend', array($user->hash)) }}'">Suspend</a>
							</div>
						@else
							<div class="medium info btn">
								<a onClick="location.href='{{ action('Sentinel\UserController@unsuspend', array($user->hash)) }}'">Un-Suspend</a>
							</div> 
						@endif
						@if ($user->status != 'Banned')
							<div class="medium info btn">
								<a onClick="location.href='{{ action('Sentinel\UserController@ban', array($user->hash)) }}'">Ban</a> 
							</div>
						@else
							<div class="medium info btn">
								<a onClick="location.href='{{ action('Sentinel\UserController@unban', array($user->hash)) }}'">Un-Ban</a> 
							</div>
						@endif
						
						<div class="medium info btn">
							<a href="{{ action('Sentinel\UserController@destroy', array($user->hash)) }}" data-token="{{ csrf_token() }}" data-method="delete">Delete</a>
						</div>

					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
  </div>
</div>
@stop