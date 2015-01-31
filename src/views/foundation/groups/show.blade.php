@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
View Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="small-8 columns">
		<h4>{{ $group['name'] }} Group</h4>

		<strong>Permissions:</strong>
		<ul>
			@foreach ($group->getPermissions() as $key => $value)
				<li>{{ ucfirst($key) }}</li>
			@endforeach
		</ul>
	</div>

	<div class="small-4 columns">	
		<button class="button" onClick="location.href='{{ route('sentinel.groups.edit', array($group->hash)) }}'">Edit Group</button>
	</div>

</div>

<div class="row">
	<h4>Group Object</h4>
	<div class="panel">
		<pre>{{ var_dump($group) }}</pre>
	</div>
</div>

@stop
