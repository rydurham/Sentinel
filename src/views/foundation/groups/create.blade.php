@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Create Group
@stop

{{-- Content --}}
@section('content')
<form method="POST" action="{{ route('sentinel.groups.store') }}" accept-charset="UTF-8">
    <div class="row">
        <div class="small-6 large-centered columns">

            <h2>Create New Group</h2>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Name</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('name')) ? 'error' : '' }}">
                    <input placeholder="Name" name="name" type="text">
                    {{ ($errors->has('name') ? $errors->first('name', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <label for="Permissions">Permissions</label>
                <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                @foreach ($defaultPermissions as $permission)
                    <div class="small-10 small-offset-2 columns">
                        <input name="permissions[{{ $permission }}]" value="1" type="checkbox"
                        @if (Request::old('permissions[' . $permission .']'))
                            checked
                        @endif
                        > {{ ucwords($permission) }}
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="small-10 small-offset-2 columns">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-primary" value="Create New Group" type="submit">
                </div>
            </div>

        </div>
    </div>
</form>

@stop