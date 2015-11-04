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
        <form method="POST" action="{{ route('sentinel.reset.password', [$hash, $code]) }}" accept-charset="UTF-8">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h2>Reset Your Password</h2>

            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">New Password</label>
                    {{ ($errors->has('password') ? '<br />' . $errors->first('password') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                    <label for="password_confirmation">New Password</label>
                    {{ ($errors->has('password_confirmation') ? '<br />' . $errors->first('password_confirmation') : '') }}
                </div>
            </div>

            <p>
                <button class="btn waves-effect waves-light red" type="submit" name="action">Reset Password
                    <i class="mdi-content-send right"></i>
                </button>
            </p>

        </form>
    </div>
</div>
@stop