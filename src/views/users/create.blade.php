@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Register
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'Sentinel\UserController@store')) }}

            <h2>Register New Account</h2>

                @foreach (Config::get('Sentinel::config.newfields') as $field => $lable)

                    <div class="form-group {{ ($errors->has($field)) ? 'has-error' : '' }}">
                        {{ Form::text($field, null, array('class' => 'form-control', 'placeholder' => $lable)) }}
                        {{ ($errors->has($field) ? $errors->first($field) : '') }}
                    </div>
               
               @endforeach
            
            {{ Form::submit('Register', array('class' => 'btn btn-primary')) }}
            
        {{ Form::close() }}
    </div>
</div>


@stop
