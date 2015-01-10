@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Forgot Password
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
        <form method="POST" action="{{ route('sentinel.reset.password', ['id' => $userId, 'code' => $code]) }}" accept-charset="UTF-8">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h2>Reset Your Password</h2>

            <div class="row">
                <div class="input-field col s12">
                    <input id="newPassword" name="newPassword" type="password" class="validate">
                    <label for="newPassword">New Password</label>
                    {{ ($errors->has('newPassword') ? '<br />' . $errors->first('newPassword') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="newPassword_confirmation" name="newPassword_confirmation" type="password" class="validate">
                    <label for="newPassword_confirmation">New Password</label>
                    {{ ($errors->has('newPassword_confirmation') ? '<br />' . $errors->first('newPassword_confirmation') : '') }}
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