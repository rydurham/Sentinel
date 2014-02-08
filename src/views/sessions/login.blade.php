@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'Sentinel\SessionController@store')) }}

            <h2 class="form-signin-heading">Sign In</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email', 'autofocus')) }}
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password'))}}
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>
            
            <label class="checkbox">
                {{ Form::checkbox('rememberMe', 'rememberMe') }} Remember me
            </label>
            {{ Form::submit('Sign In', array('class' => 'btn btn-primary'))}}
            <a class="btn btn-link" href="{{ route('Sentinel\forgotPasswordForm') }}">Forgot Password</a>
        {{ Form::close() }}
    </div>
</div>

@stop