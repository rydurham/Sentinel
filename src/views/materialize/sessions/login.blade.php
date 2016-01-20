@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
Log In
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
        <form method="POST" action="{{ route('sentinel.session.store') }}" accept-charset="UTF-8">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h2>Sign In</h2>

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="text" class="validate" value="{{ Request::old('email') }}">
                    <label for="email">E-Mail</label>
                    {{ ($errors->has('email') ? $errors->first('email') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">Password</label>
                    {{ ($errors->has('password') ?  $errors->first('password') : '') }}
                </div>
            </div>

            <p>
                <input type="checkbox" id="rememberMe" name="rememberMe" />
                <label for="rememberMe">Remember Me</label>
            </p>

            <p>
                <button class="btn waves-effect waves-light red" type="submit" name="action">Go
                    <i class="mdi-content-send right"></i>
                </button>
                <a href="{{ route('sentinel.forgot.form') }}" class="btn waves-effect waves-light red lighten-2">Forgot Password</a>
            </p>

        </form>
    </div>
</div>
@stop