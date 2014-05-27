@extends(Config::get('Sentinel::config.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Change password
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
            {{ Form::open( array('action' => array('Sentinel\UserController@change_password', $id, $code), 'id'=>'change_password', 'name'=>'regForm' )) }}

                <fieldset>

                    <label for="newPassword"></label>

                        @if( $errors->has( 'newPassword' ) )
                            {{ Form::password('newPassword', array('class' => 'error-input textbox-2', 'placeholder' => 'Password', 'autocomplete'=>'off', 'id' => 'newPassword' )) }}
                            <div id="password-errors" class="error-note-login">
                                {{ $errors->first('newPassword')  }}
                            </div>
                        @else
                            {{ Form::password('newPassword', array('class' => 'textbox-2', 'placeholder' => 'Password', 'autocomplete'=>'off', 'id' => 'newPassword' )) }}
                            <div id="password-errors" class="error-note-login" style="display: none;">
                                Password mismatch.
                            </div>
                        @endif
                    
                    <label for="newPassword_confirmation"></label>

                        @if( $errors->has( 'newPassword_confirmation' ) )
                            {{ Form::password('newPassword_confirmation', array('class' => 'error-input textbox-3', 'placeholder' => 'Password Again', 'autocomplete'=>'off', 'id' => 'newPassword_confirmation' )) }}
                        @else
                            {{ Form::password('newPassword_confirmation', array('class' => 'textbox-3', 'placeholder' => 'Password Again', 'autocomplete'=>'off', 'id' => 'newPassword_confirmation' )) }}
                        @endif


                    <a id="update-password" style="margin-right:0;" href="javascript:void 0;" class="blueButton buttons">
                        <span class="arrow"></span><span class="label">Update</span>
                    </a>
                
                </fieldset>

            {{ Form::close() }}
    </div>
</div>

@stop
