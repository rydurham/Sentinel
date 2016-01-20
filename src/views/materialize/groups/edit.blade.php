@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
    <form method="POST" action="{{ route('sentinel.groups.update', $group->hash) }}" accept-charset="UTF-8">
        <input name="_method" value="PUT" type="hidden">
        <input name="_token" value="{{ csrf_token() }}" type="hidden">

        <h2>Edit Group</h2>

        <div class="row">
            <div class="input-field col s12">
                <input id="name" name="name" type="text" class="validate" value="{{ Request::old('name') ? Request::old('name') : $group->name }}">
                <label for="name">Name</label>
                {{ ($errors->has('name') ? $errors->first('name') : '') }}
            </div>
        </div>

        <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>

        @foreach ($defaultPermissions as $permission)
            <p>
                <input type="checkbox" id="permissions[{{ $permission }}]" name="permissions[{{ $permission }}]" value="1" {{ (isset($permissions[$permission]) ? 'checked' : '') }} />
                <label for="permissions[{{ $permission }}]">{{ ucwords($permission) }}</label>
            </p>
        @endforeach

        <p>
            <button class="btn waves-effect waves-light red" type="submit" name="action">Save Changes
                <i class="mdi-content-send right"></i>
            </button>
        </p>

</form>

@stop