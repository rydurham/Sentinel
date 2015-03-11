@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
User Profile
@stop

{{-- Content --}}
@section('content')

<?php
    // Determine the edit profile route
    if (($user->email == Sentry::getUser()->email)) {
        $editAction = route('sentinel.profile.edit');
    } else {
        $editAction =  action('\\Sentinel\Controllers\UserController@edit', [$user->hash]);
    }
?>

<div class="row">
    <h2>Account Profile</h2>
</div>

<div class="row">
    <div class="col m8 s12">
        <h4>Details</h4>
        <div class="divider"></div>
        @if ($user->first_name)
            <p><strong>First Name:</strong> {{ $user->first_name }} </p>
        @endif

        @if ($user->last_name)
            <p><strong>Last Name:</strong> {{ $user->last_name }} </p>
        @endif

        <p><strong>Email:</strong> {{ $user->email }}</p>

        <div class="row">
            <div class="col s8">
                <p>
                    <em>Account created: {{ $user->created_at }}</em><br />
                    <em>Last Updated: {{ $user->updated_at }}</em>
                </p>
            </div>
            <div class="col s4">
                <p>
                    <a href="{{ $editAction }}" class="btn red lighten-1">Edit Profile</a>
                </p>
            </div>
        </div>
    </div>
    <div class="col m4 s12">
        <h4>Group Memberships</h4>
        <div class="divider"></div>
        <?php $userGroups = $user->getGroups(); ?>
        <ul>
            @if (count($userGroups) >= 1)
                @foreach ($userGroups as $group)
                    <li>{{ $group['name'] }}</li>
                @endforeach
            @else
                <li>No Group Memberships.</li>
            @endif
        </ul>

    </div>
</div>

<div class="row">
    <h4>User Object</h4>
    <div class="divider"></div>
    <code>{{ var_dump($user) }}</code>
</div>

@stop
