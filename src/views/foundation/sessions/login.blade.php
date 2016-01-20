@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')

<form method="POST" action="{{ route('sentinel.session.store') }}" accept-charset="UTF-8">
    <div class="small-6 large-centered columns">
        <h3 class="form-signin-heading">Sign In</h3>

        <div class="row">
            <div class="small-2 columns">
                <label for="right-label" class="right inline">Email</label>
            </div>
            <div class="small-10 columns {{ ($errors->has('email')) ? 'error' : '' }}">
                <input placeholder="Email" autofocus="autofocus" name="email" type="text"  value="{{ Request::old('email') }}">
                {{ ($errors->has('email') ? $errors->first('email', '<small class="error">:message</small>') : '') }}
            </div>
        </div>

        <div class="row">
            <div class="small-2 columns">
                <label for="right-label" class="right inline">Password</label>
            </div>
            <div class="small-10 columns">
                <input class="form-control" placeholder="Password" name="password" value="" type="password">
                {{ ($errors->has('password') ?  $errors->first('password', '<small class="error">:message</small>') : '') }}
            </div>
        </div>

        <div class="row">
            <div class="small-10 small-offset-2 columns">
                <input name="rememberMe" value="rememberMe" type="checkbox">
                <label for="rememberMe">Remember Me</label>
            </div>
        </div>

        <div class="row">
            <div class="small-10 small-offset-2 columns">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input class="button primary" value="Sign In" type="submit">
                <a class="button secondary" href="{{ route('sentinel.forgot.form') }}">Forgot Password</a>
            </div>
        </div>

    </div>
</form>


@stop