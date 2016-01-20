@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')

<form method="POST" action="{{ route('sentinel.session.store') }}" accept-charset="UTF-8">

    <h2>Sign In</h2>

    <p>
        <input class="form-control" placeholder="Email" autofocus="autofocus" name="email" type="text"  value="{{ Request::old('email') }}">
        {{ ($errors->has('email') ? $errors->first('email') : '') }}
    </p>

    <p>
        <input class="form-control" placeholder="Password" name="password" value="" type="password">
        {{ ($errors->has('password') ?  $errors->first('password') : '') }}
    </p>

    <p>
        <input name="rememberMe" value="rememberMe" type="checkbox"> Remember Me
    </p>

    <p>
        <input name="_token" value="{{ csrf_token() }}" type="hidden">
        <input value="Sign In" type="submit">
        <a href="{{ route('sentinel.forgot.form') }}">Forgot Password</a>
    </p>

</form>

@stop