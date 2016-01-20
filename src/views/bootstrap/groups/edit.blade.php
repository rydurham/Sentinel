@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form method="POST" action="{{ route('sentinel.groups.update', $group->hash) }}" accept-charset="UTF-8">

            <h2>Edit Group</h2>

            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Name" name="name" value="{{ Request::old('name') ? Request::old('name') : $group->name }}" type="text">
                {{ ($errors->has('name') ? $errors->first('name') : '') }}
            </div>

            <label for="Permissions">Permissions</label>
            <div class="form-group">
                <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                @foreach ($defaultPermissions as $permission)
                    <label class="checkbox-inline">
                        <input name="permissions[{{ $permission }}]" value="1" type="checkbox" {{ (isset($permissions[$permission]) ? 'checked' : '') }}>
                        {{ ucwords($permission) }}
                    </label>
                @endforeach
            </div>

            <input name="_method" value="PUT" type="hidden">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-primary" value="Save Changes" type="submit">

        </form>
    </div>
</div>

@stop