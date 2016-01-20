@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Create New User
@stop

{{-- Content --}}
@section('content')

<form method="POST" action="{{ route('sentinel.users.store') }}" accept-charset="UTF-8">

    <h2>Create New User</h2>

    <p>
    	<input class="form-control" placeholder="Username" name="username" type="text" value="{{ Request::old('username') }}">
        {{ ($errors->has('email') ? $errors->first('email') : '') }}
    </p>

    <p>
    	<input class="form-control" placeholder="E-mail" name="email" type="text" value="{{ Request::old('email') }}">
       	{{ ($errors->has('password') ?  $errors->first('password') : '') }}
   </p>

    <p>
    	<input class="form-control" placeholder="Password" name="password" value="" type="password">
        {{ ($errors->has('password_confirmation') ?  $errors->first('password_confirmation') : '') }}
    </p>

    <p>
    	<input name="activate" value="activate" type="checkbox"> Activate
    </p>

    <p>
    	<input name="_token" value="{{ csrf_token() }}" type="hidden">
    	<input class="btn btn-primary" value="Create" type="submit">
    </p>

</form>

@stop