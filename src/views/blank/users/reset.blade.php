@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Forgot Password
@stop

{{-- Content --}}
@section('content')
<form method="POST" action="{{ route('sentinel.reset.password', [$hash, $code]) }}" accept-charset="UTF-8">

    <h2>Reset Your Password</h2>

    <p>
        <input placeholder="New Password" name="password" type="password" />
        {{ ($errors->has('password') ? $errors->first('password') : '') }}
    </p>

    <p>
        <input placeholder="Confirm Password" name="password_confirmation" type="password" />
        {{ ($errors->has('password_confirmation') ? $errors->first('password_confirmation') : '') }}
    </p>

    <input name="_token" value="{{ csrf_token() }}" type="hidden">
    <input class="btn btn-primary" value="Change Password" type="submit">

</form>
@stop