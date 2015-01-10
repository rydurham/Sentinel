@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop

{{-- Content --}}
@section('content')
	<h4>Account Profile</h4>

    @if ($user->first_name)
        <p><strong>First Name:</strong> {{ $user->first_name }} </p>
    @endif
    @if ($user->last_name)
        <p><strong>Last Name:</strong> {{ $user->last_name }} </p>
    @endif

	<p><strong>Email:</strong> {{ $user->email }}</p>

	<p><em>Account created: {{ $user->created_at }}</em></p>

	<p><em>Last Updated: {{ $user->updated_at }}</em></p>

	<button onClick="location.href='{{ route('sentinel.users.edit', array($user->id)) }}'">Edit Profile</button>
		
	<h4>Group Memberships:</h4>
	<?php $userGroups = $user->getGroups(); ?>
	<p>
	    <ul>
	    	@if (count($userGroups) >= 1)
		    	@foreach ($userGroups as $group)
					<li>{{ $group['name'] }}</li>
				@endforeach
			@else 
				<li>No Group Memberships.</li>
			@endif
	    </ul>
	</p>
	
	<hr />

	<h4>User Object</h4>
	<pre>{{ var_dump($user) }}</pre>

@stop
