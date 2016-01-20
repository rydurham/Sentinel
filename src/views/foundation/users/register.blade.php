@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
<form method="POST" action="{{ route('sentinel.users.store') }}" accept-charset="UTF-8">
  <div class="row">
        <div class="small-6 large-centered columns">

            <h2>Register New Account</h2>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Username</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('username')) ? 'error' : '' }}">
                    <input placeholder="Username" name="username" type="text"  value="{{ Request::old('username') }}">
                    {{ ($errors->has('username') ? $errors->first('username', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">E-mail</label>
                </div>
                <div class="small-10 columns {{ ($errors->has('email')) ? 'error' : '' }}">
                    <input placeholder="E-mail" name="email" type="text"  value="{{ Request::old('email') }}">
                    {{ ($errors->has('email') ? $errors->first('email', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Password</label>
                </div>
                <div class="small-10 columns">
                    <input class="form-control" placeholder="Password" name="password" value="" type="password">
                    {{ ($errors->has('password') ?  $errors->first('password', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="small-2 columns">
                    <label for="right-label" class="right inline">Confirm</label>
                </div>
                <div class="small-10 columns">
                    <input class="form-control" placeholder="Confirm Password" name="password_confirmation" value="" type="password">
                    {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

             <div class="row">
                <div class="small-10 small-offset-2 columns">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="button" value="Create" type="submit">
                </div>
            </div>

        </div>
    </div>
</form>



@stop