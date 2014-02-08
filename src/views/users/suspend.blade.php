@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Suspend User
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => array('Sentinel\UserController@suspend', $id), 'method' => 'post')) }}
 
            <h2>Suspend User</h2>

            <div class="form-group {{ ($errors->has('minutes')) ? 'has-error' : '' }}">
                {{ Form::text('minutes', null, array('class' => 'form-control', 'placeholder' => 'Minutes', 'autofocus')) }}
                {{ ($errors->has('minutes') ? $errors->first('minutes') : '') }}
            </div>    	   

            {{ Form::hidden('id', $id) }}

            {{ Form::submit('Suspend User', array('class' => 'btn btn-primary')) }}
            
        {{ Form::close() }}
    </div>
</div>

@stop