@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Create New User
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form method="POST" action="{{ route('sentinel.users.store') }}" accept-charset="UTF-8">

            <h2>Create New User</h2>

            <div class="form-group {{ ($errors->has('username')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Username" name="username" type="text"  value="{{ Input::old('username') }}">
                {{ ($errors->has('username') ? $errors->first('username') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="E-mail" name="email" type="text"  value="{{ Input::old('email') }}">
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Password" name="password" value="" type="password">
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Confirm Password" name="password_confirmation" value="" type="password">
                {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation') : '') }}
            </div>

            <div class="form-group">
                <label class="checkbox">
                    <input name="activate" value="activate" type="checkbox"> Activate
                </label>
            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-primary" value="Create" type="submit">

        </form>
    </div>
</div>


@stop