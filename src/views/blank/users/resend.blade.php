@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Resend Activation
@stop

{{-- Content --}}
@section('content')

<form method="POST" action="{{ route('sentinel.reactivate.send') }}" accept-charset="UTF-8">

    <h2>Resend Activation Email</h2>

    <p>
        <input class="form-control" placeholder="E-mail" autofocus="autofocus" name="email" type="text" value="{{ Request::old('email') }}">
        {{ ($errors->has('email') ? $errors->first('email') : '') }}
    </p>

    <input name="_token" value="{{ csrf_token() }}" type="hidden">
    <input class="btn btn-primary" value="Resend" type="submit">

</form>

@stop
