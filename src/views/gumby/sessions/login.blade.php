@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Log In')

{{-- Content --}}
@section('content')

<div class="row">
    <div class="four columns colophon centered">
       <form method="POST" action="{{ route('sentinel.session.store') }}" accept-charset="UTF-8">
            <ul >
                <h4>Login</h4>

                <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}">
                    <input type="text" name='email' placeholder="E-mail" class="text input" value="{{ Request::old('email') }}">
                </li>
                {{ $errors->first('email',  '<p class="form_error">:message</p>') }}

                <li class="field {{ $errors->has('password') ? 'danger' : '' }}">
                    <input type="password" name="password" placeholder="Password" class="password input">
                </li>
                {{ $errors->first('password',  '<p class="form_error">:message</p>') }}

                <li class="field">
                    <label for="rememberMe" class="checkbox">
                      <input type="checkbox" id="rememberMe" name="rememberMe" value="1">
                      <span></span> Remember Me
                    </label>
                </li>

                <div class="medium primary btn">
                  <input name="_token" value="{{ csrf_token() }}" type="hidden">
                  <input type="submit" value="Log In" />
                </div>
                <div class="medium default btn">
                  <button type="button" onClick="window.location='{{ route('sentinel.forgot.form') }}'">Forgot Password?</button>
                </div>
            </ul>
      </form>
  </div>
</div>

@stop
