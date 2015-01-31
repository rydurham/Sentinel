@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'View Group')

{{-- Content --}}
@section('content')
<div class="row">
	<div class="twelve columns">
		<h4>{{ $group['name'] }} Group</h4>
	</div>
</div>
<div class="row">
	<div class="six columns">
	    <strong>Permissions:</strong>
	    <ul>
	    	@foreach ($group->getPermissions() as $key => $value)
	    		<li>{{ ucfirst($key) }}</li>
	    	@endforeach
	    </ul>
	</div>
	<div class="six columns">
		<div class="medium info btn">
			<a onClick="location.href='{{ route('sentinel.groups.edit', array($group->hash)) }}'">Edit Group</a>
		</div>
	</div> 
</div>

<div class="row">
	<h4>Group Object</h4>
	<code>{{ var_dump($group) }}</code>
</div>

@stop
