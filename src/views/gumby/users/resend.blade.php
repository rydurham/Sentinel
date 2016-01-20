@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title', 'Resend Activation')

{{-- Content --}}
@section('content')

<div class="row">
    <div class="four columns colophon centered">
        <form method="POST" action="{{ route('sentinel.reactivate.send') }}" accept-charset="UTF-8">
            <h4>Resend Activation</h4>
            <ul >

                <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}">
                    <input type="text" name='email' placeholder="E-mail" class="text input" value="{{ Request::old('email') }}">
                </li>
                {{ $errors->first('email',  '<p class="form_error">:message</p>') }}

                <div class="medium primary btn">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input type="submit" value="Resend" />
                </div>

            </ul>
        </form>
  </div>
</div>
@stop
