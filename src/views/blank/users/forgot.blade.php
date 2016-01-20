@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Forgot Password
@stop

{{-- Content --}}
@section('content')

<form method="POST" action="{{ route('sentinel.reset.request') }}" accept-charset="UTF-8">

    <h2>Forgot your Password?</h2>

    <p>
        <input placeholder="E-mail" autofocus="autofocus" name="email" type="text" value="{{ Request::old('email') }}">
        {{ ($errors->has('email') ? $errors->first('email') : '') }}
    </p>

    <input name="_token" value="{{ csrf_token() }}" type="hidden">
    <input class="btn btn-primary" value="Send Instructions" type="submit">

</form>

@stop