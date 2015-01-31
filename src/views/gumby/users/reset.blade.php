@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Resend Activation')

{{-- Content --}}
@section('content')

<div class="row">
    <div class="four columns colophon centered">
        <form method="POST" action="{{ route('sentinel.reset.password', [$hash, $code]) }}" accept-charset="UTF-8">
            <h4>Reset your password</h4>
            <ul >
                    
                <li class="field {{ $errors->has('newPassword') ? 'danger' : '' }}">
                    <input type="password" name="newPassword" placeholder="New Password" class="password input">
                </li>
                {{ $errors->first('newPassword',  '<p class="form_error">:message</p>') }}

                <li class="field {{ $errors->has('newPassword_confirmation') ? 'danger' : '' }}">
                    <input type="password" name="newPassword_confirmation" placeholder="Confirm New Password" class="password input">
                </li>
                {{ $errors->first('newPassword_confirmation',  '<p class="form_error">:message</p>') }}
                
                <div class="medium primary btn">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input type="submit" value="Reset Password" />
                </div>
                    
            </ul>
        </form>
    </div>
</div>
@stop
