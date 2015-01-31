@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Edit Group')

{{-- Content --}}
@section('content')
<div class="row">
    <div class="six columns centered">
    	<form method="POST" action="{{ route('sentinel.groups.update', $group->hash) }}" accept-charset="UTF-8">
            <ul >
                <h4>Edit Group</h4>

                <li class="field {{ ($errors->has('name')) ? 'danger' : '' }}">
                    <input class="text input" placeholder="Name" name="name" value="{{ $group->name }}" type="text">
                </li>
                {{ $errors->first('name', '<p class="form_error">:message</p>') }}
                
                <label for="Permissions">Permissions</label>
                <li class="field">
                    <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                    @foreach ($defaultPermissions as $permission)
                        <label class="checkbox {{ (isset($permissions[$permission]) ? 'checked' : '') }}">
                          <input type="checkbox"  name="permissions[{{ $permission }}]" value="1" {{ (isset($permissions[$permission]) ? 'checked' : '') }}>
                          <span></span> {{ ucwords($permission) }}
                        </label>
                    @endforeach
                </li>

                <div class="medium primary btn">
                    <input name="_method" value="PUT" type="hidden">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input value="Save Changes" type="submit">
                </div>

            </ul>
        </form>
    </div>
</div>

@stop