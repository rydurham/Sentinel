@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Create Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
        <form method="POST" action="{{ route('sentinel.groups.store') }}" accept-charset="UTF-8">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h2>Create New Group</h2>

            <div class="row">
                <div class="input-field col s12">
                    <input id="name" name="name" type="text" class="validate">
                    <label for="name">Name</label>
                    {{ ($errors->has('name') ? $errors->first('name') : '') }}
                </div>
            </div>

            <?php $defaultPermissions = Config::get('Sentinel::auth.default_permissions', []); ?>


            <p>Permissions</p>
            @foreach ($defaultPermissions as $permission)
                <p>
                    <input type="checkbox" id="permissions[{{ $permission }}]" name="permissions[{{ $permission }}]" value="1" />
                    <label for="permissions[{{ $permission }}]">{{ ucwords($permission) }}</label>
                </p>
            @endforeach

            <p>
                <button class="btn waves-effect waves-light red" type="submit" name="action">Create New Group
                    <i class="mdi-content-send right"></i>
                </button>
            </p>

        </form>
    </div>
</div>
@stop