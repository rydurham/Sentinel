@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Resend Activation
@stop

{{-- Content --}}
@section('content')
<form method="POST" action="{{ route('sentinel.reactivate.send') }}" accept-charset="UTF-8">
    <input name="_token" value="{{ csrf_token() }}" type="hidden">
    <div class="row">
        <div class="small-6 large-centered columns">

            <h3>Resend Activation Email</h3>

             <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Email</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('email')) ? 'error' : '' }}">
                    <input placeholder="E-mail" autofocus="autofocus" name="email" type="text" value="{{ Request::old('email') }}">
                    {{ ($errors->has('email') ? $errors->first('email', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-10 small-offset-2 columns">
                    <input class="btn btn-primary" value="Resend" type="submit">
                </div>
            </div>

        </div>
    </div>
</form>
@stop
