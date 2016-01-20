@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
<form method="POST" action="{{ route('sentinel.register.user') }}" accept-charset="UTF-8">

    <h2>Register New Account</h2>

    <p>
        <input placeholder="Username" name="username" type="text"  value="{{ Request::old('username') }}">
        {{ ($errors->has('username') ? $errors->first('username') : '') }}
    </p>

    <p>
        <input placeholder="E-mail" name="email" type="text"  value="{{ Request::old('email') }}">
        {{ ($errors->has('email') ? $errors->first('email') : '') }}
    </p>

    <p>
        <input placeholder="Password" name="password" value="" type="password">
        {{ ($errors->has('password') ?  $errors->first('password') : '') }}
    </p>

    <p>
        <input placeholder="Confirm Password" name="password_confirmation" value="" type="password">
        {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation') : '') }}
    </p>

    <input name="_token" value="{{ csrf_token() }}" type="hidden">
    <input value="Register" type="submit">

</form>
@stop