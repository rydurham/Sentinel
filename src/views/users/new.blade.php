@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'Sentinel\UserController@store')) }}

            <h2>Register New Account</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'E-mail')) }}
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password')) }}
                {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation') : '') }}
            </div>
            
            {{ Form::submit('Register', array('class' => 'btn btn-primary')) }}
            
        {{ Form::close() }}
    </div>
</div>


@stop