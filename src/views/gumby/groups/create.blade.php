@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Create Group')

{{-- Content --}}
@section('content')
<div class="row">
   	<div class="six columns centered">
        <form method="POST" action="{{ route('sentinel.groups.store') }}" accept-charset="UTF-8">
            <ul>
                <h4>Create New Group</h4>

                <li class="field {{ ($errors->has('name')) ? 'danger' : '' }}">
                    <input class="text-imput" placeholder="Name" name="name" type="text" value="{{ Request::old('name') }}">
                </li>
                {{ $errors->first('name', '<p class="form_error">:message</p>') }}

                <label for="Permissions">Permissions</label>
                <li class="field">
                    <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                    @foreach ($defaultPermissions as $permission)
                        <label class="checkbox" for="permissions[{{ $permission }}]" >
                            <input name="permissions[{{ $permission }}]" value="1" type="checkbox"
                            @if (Request::old('permissions[' . $permission .']'))
                              checked
                            @endif
                            > {{ ucwords($permission) }}
                            <span></span> {{ ucwords($permission) }}
                        </label>
                    @endforeach
                </li>

                <div class="medium primary btn">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input value="Create New Group" type="submit">
                </div>

            </ul>
         </form>
    </div>
</div>

@stop
