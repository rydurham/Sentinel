@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Reset Password
@stop

{{-- Content --}}
@section('content')
<form method="POST" action="{{ route('sentinel.reset.password', [$hash, $code]) }}" accept-charset="UTF-8">
     <div class="row">
        <div class="small-6 large-centered columns">  

            <h3>Reset Your Password</h3>
    		
             <div class="row">
                 <div class="small-3 columns">
                     <label for="right-label" class="right inline">New</label>
                 </div>
                 <div class="small-9 columns">
                     <input class="form-control" placeholder="New Password" name="newPassword" value="" id="newPassword" type="password">
                     {{ ($errors->has('newPassword') ?  $errors->first('newPassword', '<small class="error">:message</small>') : '') }}
                 </div>
             </div>

              <div class="row">
                 <div class="small-3 columns">
                     <label for="right-label" class="right inline">Confirm</label>
                 </div>
                 <div class="small-9 columns">
                     <input class="form-control" placeholder="Confirm New Password" name="newPassword_confirmation" value="" id="newPassword_confirmation" type="password">
                     {{ ($errors->has('newPassword_confirmation') ?  $errors->first('newPassword_confirmation', '<small class="error">:message</small>') : '') }}
                 </div>
             </div>

            <div class="row">
                <div class="small-10 small-offset-2 columns">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="button" value="Reset Password" type="submit">
                </div>
            </div>
        
        </div>
    </div>
</form>
@stop
