@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')

<div class="row">
    <h1>
        Edit
        @if ($user->email == Sentry::getUser()->email)
            Your
        @else
            {{ $user->email }}'s
        @endif
        Account
    </h1>
</div>

<?php $customFields = Config::get('Sentinel::auth.additional_user_fields'); ?>

@if (! empty($customFields))
<div class="row">
    <div class="small-6 large-centered columns">
        <h4>Profile</h4>
        
        @foreach(Config::get('Sentinel::auth.additional_user_fields') as $field => $rules)
        <div class="row">
            <div class="small-3 columns">
                <label for="right-label" class="right inline">{{ ucwords(str_replace('_',' ',$field)) }}</label>
            </div>
            <div class="small-9 columns {{ ($errors->has($field)) ? 'has-error' : '' }}">
                <input name="{{ $field }}" type="text" value="{{ $user->$field }}">
                {{ ($errors->has($field) ? $errors->first($field, '<small class="error">:message</small>') : '') }}
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="small-9 small-offset-3 columns">
                <input name="_method" value="PUT" type="hidden">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input name="id" value="{{ $user->id }}" type="hidden">
                <input class="button" value="Submit Changes" type="submit">
            </div>
        </div>
    </div>
</div>
@endif


@if (Sentry::getUser()->hasAccess('admin') && ($user->id != Sentry::getUser()->id))
<form method="POST" action="{{ route('sentinel.users.memberships', $user->id) }}" accept-charset="UTF-8" class="form-horizontal" role="form">
    <div class="row">
        <div class="small-6 large-centered columns">
            <h4>Group Memberships</h4>
            
            <div class="row">
                <div class="small-9 small-offset-3 columns">
                    @foreach($groups as $group)
                        <label class="checkbox-inline">
                            <input type="checkbox" name="groups[{{ $group->name }}]" value="1" {{ ($user->inGroup($group) ? 'checked' : '') }}> {{ $group->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="small-9 small-offset-3 columns">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="button" value="Update Memberships" type="submit">
                </div>
            </div>

        </div>
    </div>
</form>
@endif


<form method="POST" action="{{ route('sentinel.password.change', $user->id) }}" accept-charset="UTF-8" class="form-inline" role="form">
    <div class="row">
        <div class="small-6 large-centered columns">
            <h4>Change Password</h4>    
    
            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right inline">Current</label>
                </div>
                <div class="small-9 columns">
                    <input placeholder="Old Password" name="oldPassword" value="" id="oldPassword" type="password">
                    {{ ($errors->has('oldPassword') ?  $errors->first('oldPassword', '<small class="error">:message</small>') : '') }}
                </div>
            </div>

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
                <div class="small-9 small-offset-3 columns">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="button" value="Change Password" type="submit">
                </div>
            </div>

        </div>
    </div>
{{ Form::close() }}

@stop