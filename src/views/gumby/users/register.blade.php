@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Register')

{{-- Content --}}
@section('content')
<div class="row">
    <div class="four columns colophon centered">
        <form method="POST" action="{{ route('sentinel.register.user') }}" accept-charset="UTF-8">
            <ul>

                <h4>Register</h4>

                <li class="field {{ ($errors->has('username')) ? 'danger' : '' }}">
                    <input class="text input" placeholder="Username" name="username" type="text"  value="{{ Request::old('username') }}">
                </li>
                {{ $errors->first('username',  '<p class="form_error">:message</p>') }}

                <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}">
                    <input class="text input" placeholder="E-mail" name="email" type="text"  value="{{ Request::old('email') }}">
                </li>
                {{ $errors->first('email',  '<p class="form_error">:message</p>') }}

                <li class="field {{ ($errors->has('password')) ? 'danger' : '' }}">
                    <input class="text input" placeholder="Password" name="password" value="" type="password">
                </li>
                {{ $errors->first('password',  '<p class="form_error">:message</p>') }}

                <li class="field {{ ($errors->has('password_confirmation')) ? 'danger' : '' }}">
                    <input class="text input" placeholder="password_confirmation" name="password_confirmation" value="" type="password">
                </li>
                {{ $errors->first('password_confirmation',  '<p class="form_error">:message</p>') }}

                <div class="medium primary btn">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input type="submit" value="Register">
                </div>
            </ul>
        </form>
    </ul>


</div>

@stop