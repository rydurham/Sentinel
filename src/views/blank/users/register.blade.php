@extends(Config::get('Sentinel::views.layout'))

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
        <input placeholder="Username" name="username" type="text">
        {{ ($errors->has('username') ? $errors->first('username') : '') }}
    </p>

    <p>
        <input placeholder="E-mail" name="email" type="text">
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

    <input name="_token" value="TU1ensQVfjSgpVMe86Dx1AJDsfNXi5gu8SBMwKo1" type="hidden">
    <input value="Register" type="submit">

</form>
@stop