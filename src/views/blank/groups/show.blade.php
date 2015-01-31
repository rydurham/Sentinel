@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
View Group
@stop

{{-- Content --}}
@section('content')
<h4>{{ $group['name'] }} Group</h4>
<div>
	<strong>Permissions:</strong>
    <ul>
    	@foreach ($group->getPermissions() as $key => $value)
    		<li>{{ ucfirst($key) }}</li>
    	@endforeach
    </ul>
</div>
<button class="btn btn-primary" onClick="location.href='{{ route('sentinel.groups.edit', array($group->hash)) }}'">Edit Group</button>
<hr />
<h4>Group Object</h4>
<div>
    {{ var_dump($group) }}
</div>

@stop
