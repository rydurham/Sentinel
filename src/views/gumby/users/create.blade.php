@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Create New User')

{{-- Content --}}
@section('content')
<div class="row">
    <h2>Create New User</h2>
</div>

<div class="row">
        <ul class="five columns">
        <form method="POST" action="{{ route('sentinel.users.store') }}" accept-charset="UTF-8">

            <li class="field {{ ($errors->has('username')) ? 'danger' : '' }}">
                <input class="text input" placeholder="Username" name="username" type="text" value="{{ Request::old('username') }}">
            </li>
            {{ $errors->first('username',  '<p class="form_error">:message</p>') }}

            <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}">
                <input class="text input" placeholder="E-mail" name="email" type="text" value="{{ Request::old('email') }}">
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

            <li class="field">
                <label class="checkbox" for="activate">
                    <input name="activate" value="activate" type="checkbox">
                    <span></span> Activate
                </label>
            </li>

            <div class="medium primary btn">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input type="submit" value="Create">
            </div>
        </form>
    </ul>


</div>

@stop