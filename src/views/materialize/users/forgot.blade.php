@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Forgot Password
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
        <form method="POST" action="{{ route('sentinel.reset.request') }}" accept-charset="UTF-8">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h4>Forgot your Password?</h4>

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="text" class="validate" value="{{ Request::old('email') }}">
                    <label for="email">E-Mail</label>
                    {{ ($errors->has('email') ? $errors->first('email') : '') }}
                </div>
            </div>

            <p>
                <button class="btn waves-effect waves-light red" type="submit" name="action">Send Instructions
                    <i class="mdi-content-send right"></i>
                </button>
            </p>

        </form>
    </div>
</div>

@stop