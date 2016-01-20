@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')

<?php
    // Pull the custom fields from config
    $isProfileUpdate = ($user->email == Sentry::getUser()->email);
    $customFields = config('sentinel.additional_user_fields');

    // Determine the form post route
    if ($isProfileUpdate) {
        $profileFormAction = route('sentinel.profile.update');
        $passwordFormAction = route('sentinel.profile.password');
    } else {
        $profileFormAction =  route('sentinel.users.update', $user->hash);
        $passwordFormAction = route('sentinel.password.change', $user->hash);
    }
?>

<h3>Edit
@if ($isProfileUpdate)
	Your
@else
	{{ $user->email }}'s
@endif
Account</h3>
<div class="divider"></div>

<?php $customFields = config('sentinel.additional_user_fields'); ?>

@if (! empty($customFields))
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
        <form method="POST" action="{{ $profileFormAction }}" accept-charset="UTF-8" role="form">
            <input name="_method" value="PUT" type="hidden">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h4>Profile</h4>

            @foreach(config('sentinel.additional_user_fields') as $field => $rules)
                <div class="row">
                    <div class="input-field col s12">
                        <input id="{{ $field }}" name="{{ $field }}" type="text" class="validate" value="{{ Request::old($field) ? Request::old($field) : $user->$field }}">
                        <label for="{{ $field }}">{{ ucwords(str_replace('_',' ',$field)) }}</label>
                        {{ ($errors->has($field) ? $errors->first($field) : '') }}
                    </div>
                </div>
            @endforeach

            <p>
                <button class="btn waves-effect waves-light red" type="submit" name="action">Save Changes
                    <i class="mdi-content-send right"></i>
                </button>
            </p>

        </form>
    </div>
</div>
@endif

@if (Sentry::getUser()->hasAccess('admin') && ($user->hash != Sentry::getUser()->hash))
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
        <form method="POST" action="{{ route('sentinel.users.memberships', $user->hash) }}" accept-charset="UTF-8" role="form">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h4>Group Memberships</h4>

            @foreach($groups as $group)
                <p>
                    <input type="checkbox" id="groups[{{ $group->name }}]" name="groups[{{ $group->name }}]" value="1" {{ ($user->inGroup($group) ? 'checked' : '') }} />
                    <label for="groups[{{ $group->name }}]">{{ $group->name }}</label>
                </p>
            @endforeach

            <p>
                <button class="btn waves-effect waves-light red" type="submit" name="action">Update Memberships
                    <i class="mdi-content-send right"></i>
                </button>
            </p>
    </form>
</div>
@endif
<div class="row">
    <div class="col l6 offset-l3 m8 offset-m2 s12">
        <form method="POST" action="{{ $passwordFormAction }}" accept-charset="UTF-8" role="form">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <h4>Change Password</h4>

            @if(! Sentry::getUser()->hasAccess('admin'))
                <div class="row">
                    <div class="input-field col s12">
                        <input id="oldPassword" name="oldPassword" type="password" class="validate">
                        <label for="oldPassword">Old Password</label>
                        {{ ($errors->has('oldPassword') ? '<br />' . $errors->first('oldPassword') : '') }}
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="input-field col s12">
                    <input id="newPassword" name="newPassword" type="password" class="validate">
                    <label for="newPassword">New Password</label>
                    {{ ($errors->has('newPassword') ? '<br />' . $errors->first('newPassword') : '') }}
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="newPassword_confirmation" name="newPassword_confirmation" type="password" class="validate">
                    <label for="newPassword_confirmation">New Password</label>
                    {{ ($errors->has('newPassword_confirmation') ? '<br />' . $errors->first('newPassword_confirmation') : '') }}
                </div>
            </div>

            <p>
                <button class="btn waves-effect waves-light red" type="submit" name="action">Change Password
                    <i class="mdi-content-send right"></i>
                </button>
            </p>

        </form>
    </div>
</div>
@stop