@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
View Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <h2>{{ $group['name'] }} Group</h2>
</div>
<div class="row">
    <div class="col m10 s12">
        <h4>Permissions:</h4>
        <div class="divider"></div>
        <ul>
            @foreach ($group->getPermissions() as $key => $value)
                <li>{{ ucfirst($key) }}</li>
            @endforeach
        </ul>
    </div>
    <div class="col m2 s12">
        <a href="{{ route('sentinel.groups.edit', [$group->hash]) }}" class="btn red">Edit Group</a>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <h4>Group Object</h4>
        <div class="divider"></div>
        <code>{{ var_dump($group) }}</code>
    </div>
</div>

@stop
