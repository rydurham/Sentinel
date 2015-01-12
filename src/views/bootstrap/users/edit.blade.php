@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')

<div class="row">
    <div class='page-header'>
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
</div>

<?php $customFields = Config::get('Sentinel::auth.additional_user_fields'); ?>

@if (! empty($customFields))
<div class="row">
    <h4>Profile</h4>
    <div class="well">
        <form method="POST" action="{{ route('sentinel.users.update', $user->id) }}" accept-charset="UTF-8" class="form-horizontal" role="form">

            @foreach(Config::get('Sentinel::auth.additional_user_fields') as $field => $rules)
            <div class="form-group {{ ($errors->has($field)) ? 'has-error' : '' }}" for="{{ $field }}">
                <label for="{{ $field }}" class="col-sm-2 control-label">{{ ucwords(str_replace('_',' ',$field)) }}</label>
                <div class="col-sm-10">
                    <input class="form-control" name="{{ $field }}" type="text" value="{{ $user->$field }}">
                    {{ ($errors->has($field) ? $errors->first($field) : '') }}
                </div>
            </div>
            @endforeach

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input name="_method" value="PUT" type="hidden">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input name="id" value="{{ $user->id }}" type="hidden">
                    <input class="btn btn-primary" value="Submit Changes" type="submit">
                </div>
            </div>

        </form>
    </div>
</div>
@endif

@if (Sentry::getUser()->hasAccess('admin') && ($user->id != Sentry::getUser()->id))
<div class="row">
    <h4>Group Memberships</h4>
    <div class="well">
        <form method="POST" action="{{ route('sentinel.users.memberships', $user->id) }}" accept-charset="UTF-8" class="form-horizontal" role="form">

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    @foreach($groups as $group)
                        <label class="checkbox-inline">
                            <input type="checkbox" name="groups[{{ $group->name }}]" value="1" {{ ($user->inGroup($group) ? 'checked' : '') }}> {{ $group->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-primary" value="Update Memberships" type="submit">
                </div>
            </div>

        </form>
    </div>
</div>
@endif

<div class="row">
    <h4>Change Password</h4>
    <div class="well">
        <form method="POST" action="{{ route('sentinel.password.change', $user->id) }}" accept-charset="UTF-8" class="form-inline" role="form">

            @if(! Sentry::getUser()->hasAccess('admin'))
            <div class="form-group {{ $errors->has('oldPassword') ? 'has-error' : '' }}">
                <label for="oldPassword" class="sr-only">Old Password</label>
                <input class="form-control" placeholder="Old Password" name="oldPassword" value="" id="oldPassword" type="password">
            </div>
            @endif

            <div class="form-group {{ $errors->has('newPassword') ? 'has-error' : '' }}">
                <label for="newPassword" class="sr-only">New Password</label>
                <input class="form-control" placeholder="New Password" name="newPassword" value="" id="newPassword" type="password">
            </div>

            <div class="form-group {{ $errors->has('newPassword_confirmation') ? 'has-error' : '' }}">
                <label for="newPassword_confirmation" class="sr-only">Confirm New Password</label>
                <input class="form-control" placeholder="Confirm New Password" name="newPassword_confirmation" value="" id="newPassword_confirmation" type="password">
            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-primary" value="Change Password" type="submit">

            {{ ($errors->has('oldPassword') ? '<br />' . $errors->first('oldPassword') : '') }}
            {{ ($errors->has('newPassword') ?  '<br />' . $errors->first('newPassword') : '') }}
            {{ ($errors->has('newPassword_confirmation') ? '<br />' . $errors->first('newPassword_confirmation') : '') }}

        </form>

    </div>
</div>
@stop
