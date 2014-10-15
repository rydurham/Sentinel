@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')

<h4>Edit 
@if ($user->email == Sentry::getUser()->email)
	Your
@else 
	{{ $user->email }}'s 
@endif 

Profile</h4>
<div class="well">
	{{ Form::open(array(
        'action' => array('Sentinel\UserController@update', $user->id), 
        'method' => 'put',
        'class' => 'form-horizontal', 
        'role' => 'form'
        )) }}
        
        <div class="form-group {{ ($errors->has('first_name')) ? 'has-error' : '' }}" for="first_name">
            {{ Form::label('edit_first_name', 'First Name', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('first_name', $user->first_name, array('class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'edit_first_name'))}}
            </div>
            {{ ($errors->has('first_name') ? $errors->first('first_name') : '') }}    			
    	</div>


        <div class="form-group {{ ($errors->has('last_name')) ? 'has-error' : '' }}" for="last_name">
            {{ Form::label('edit_last_name', 'Last Name', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('last_name', $user->last_name, array('class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'edit_last_name'))}}
            </div>
            {{ ($errors->has('last_name') ? $errors->first('last_name') : '') }}                
        </div>

        @if (Sentry::getUser()->hasAccess('admin'))
        <div class="form-group">
            {{ Form::label('edit_memberships', 'Group Memberships', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                @foreach ($allGroups as $group)
                    <label class="checkbox-inline">
                        <input type="checkbox" name="groups[{{ $group->id }}]" value='1' 
                        {{ (in_array($group->name, $userGroups) ? 'checked="checked"' : '') }} > {{ $group->name }}
                    </label>
                @endforeach
            </div>
        </div>
        @endif

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::hidden('id', $user->id) }}
                {{ Form::submit('Submit Changes', array('class' => 'btn btn-primary'))}}
            </div>
      </div>
    {{ Form::close()}}
</div>

<h4>Change Password</h4>
<div class="well">
    {{ Form::open(array(
        'action' => array('Sentinel\UserController@change', $user->id), 
        'class' => 'form-inline', 
        'role' => 'form'
        )) }}
        
        <div class="form-group {{ $errors->has('oldPassword') ? 'has-error' : '' }}">
        	{{ Form::label('oldPassword', 'Old Password', array('class' => 'sr-only')) }}
			{{ Form::password('oldPassword', array('class' => 'form-control', 'placeholder' => 'Old Password')) }}
    	</div>

        <div class="form-group {{ $errors->has('newPassword') ? 'has-error' : '' }}">
        	{{ Form::label('newPassword', 'New Password', array('class' => 'sr-only')) }}
            {{ Form::password('newPassword', array('class' => 'form-control', 'placeholder' => 'New Password')) }}
    	</div>

    	<div class="form-group {{ $errors->has('newPassword_confirmation') ? 'has-error' : '' }}">
        	{{ Form::label('newPassword_confirmation', 'Confirm New Password', array('class' => 'sr-only')) }}
            {{ Form::password('newPassword_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm New Password')) }}
    	</div>

        {{ Form::submit('Change Password', array('class' => 'btn btn-primary'))}}
	        	
      {{ ($errors->has('oldPassword') ? '<br />' . $errors->first('oldPassword') : '') }}
      {{ ($errors->has('newPassword') ?  '<br />' . $errors->first('newPassword') : '') }}
      {{ ($errors->has('newPassword_confirmation') ? '<br />' . $errors->first('newPassword_confirmation') : '') }}

      {{ Form::close() }}
  </div>

@stop
