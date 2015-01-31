@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Resend Activation
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form method="POST" action="{{ route('sentinel.reactivate.send') }}" accept-charset="UTF-8">

            <h2>Resend Activation Email</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="E-mail" autofocus="autofocus" name="email" type="text" value="{{ Input::old('name') }}">
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-primary" value="Resend" type="submit">

        </form>
    </div>
</div>

@stop
