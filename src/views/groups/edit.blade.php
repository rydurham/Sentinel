@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
	{{ Form::open(array('action' =>  array('Sentinel\GroupController@update', $group->id), 'method' => 'put')) }}
        <h2>Edit Group</h2>
    
        <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
            {{ Form::text('name', $group->name, array('class' => 'form-control', 'placeholder' => 'Name')) }}
            {{ ($errors->has('name') ? $errors->first('name') : '') }}
        </div>

        {{ Form::label('Permissions') }}

        <div class="form-group">
            <label class="checkbox-inline">
                {{ Form::checkbox('permissions[admin]', 1, array_key_exists('admin', $permissions)) }} Admin
            </label>
            <label class="checkbox-inline">
                {{ Form::checkbox('permissions[users]', 1, array_key_exists('users', $permissions)) }} User
            </label>
        </div>

        {{ Form::hidden('id', $group->id) }}
        {{ Form::submit('Save Changes', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
    </div>
</div>

@stop