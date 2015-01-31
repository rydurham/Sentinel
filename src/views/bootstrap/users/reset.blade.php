@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Reset Password
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form method="POST" action="{{ route('sentinel.reset.password', [$hash, $code]) }}" accept-charset="UTF-8">

            <h2>Reset Your Password</h2>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="New Password" name="password" type="password" />
                {{ ($errors->has('password') ? $errors->first('password') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Confirm Password" name="password_confirmation" type="password" />
                {{ ($errors->has('password_confirmation') ? $errors->first('password_confirmation') : '') }}
            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <input class="btn btn-primary" value="Reset Password" type="submit">

        </form>
  	</div>
</div>

@stop