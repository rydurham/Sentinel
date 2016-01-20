@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Forgot Password
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form method="POST" action="{{ route('sentinel.reset.request') }}" accept-charset="UTF-8">

            <h2>Forgot your Password?</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="E-mail" autofocus="autofocus" name="email" type="text" value="{{ Request::old('name') }}">
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-primary" value="Send Instructions" type="submit">

        </form>
  	</div>
</div>

@stop