<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Registration
    |--------------------------------------------------------------------------
    |
    | By default, registration is enabled.  To turn off registration, change this
    | value to false.
    |
    */

    'registration' => true,

    /*
    |--------------------------------------------------------------------------
    | Activation
    |--------------------------------------------------------------------------
    |
    | By default, new accounts must be activated via email.  Setting this to
    | false will allow users to login immediately after signing up.
    |
    */

    'require_activation' => true,

    /*
    |--------------------------------------------------------------------------
    | Allow Usernames
    |--------------------------------------------------------------------------
    |
    | By default, Sentry (and Sentinel) will only let a user log in using their
    | email address.  By setting 'allow_usernames' to true, a user can enter either
    | their username or their email address as a login credential.
    |
    */

    'allow_usernames' => true,

    /*
    |--------------------------------------------------------------------------
    | Default User Groups
    |--------------------------------------------------------------------------
    |
    | When a new user is created, they will automatically be added to the
    | groups in this array.
    |
    */

    'default_user_groups' => ['Users'],

    /*
    |--------------------------------------------------------------------------
    | Default Group Permissions
    |--------------------------------------------------------------------------
    |
    | When a new user is created, they will automatically be added to the
    | groups in this array.
    |
    */

    'default_permissions' => ['admin', 'users'],

    /*
    |--------------------------------------------------------------------------
    | Custom User Fields
    |--------------------------------------------------------------------------
    |
    | If you want to add additional fields to your user model you can specify
    | their validation needs here.  You must update your db tables and add
    | the fields to your 'create' and 'edit' views before this will work.
    |
    */

    'additional_user_fields' => [
        'first_name' => 'alpha_spaces',
        'last_name'  => 'alpha_spaces'
    ],

    /*
    |--------------------------------------------------------------------------
    | E-Mail Subject Lines
    |--------------------------------------------------------------------------
    |
    | When using the "Eloquent" authentication driver, we need to know which
    | Eloquent model should be used to retrieve your users. Of course, it
    | is often just the "User" model but you may use whatever you like.
    |
    */

    'email' => [
        'welcome'        => 'Account Registration Confirmation',
        'reset_password' => 'Password Reset Confirmation',
        'new_password'   => 'New Password Information',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Routing
    |--------------------------------------------------------------------------
    |
    | Sentinel provides default routes for its sessions, users and groups.
    | You can use them as is, or you can disable them entirely.
    |
    */

    'routes_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | URL Redirection for Method Completion
    |--------------------------------------------------------------------------
    |
    | Upon completion of their tasks, controller methods will look-up their
    | return destination here. You can specify a route, action or URL.
    | If no action is specified a JSON response will be returned.
    |
    */

    'routing' => [
        'session.store'                => ['route' => 'home'],
        'session.destroy'              => ['action' => 'Sentinel\SessionController@create'],
        'registration.complete'        => ['route' => 'home'],
        'registration.activated'       => ['route' => 'home'],
        'registration.resend'          => ['route' => 'home'],
        'registration.reset.triggered' => ['route' => 'home'],
        'registration.reset.invalid'   => ['route' => 'home'],
        'registration.reset.complete'  => ['route' => 'home'],
        'users.invalid'                => ['route' => 'home'],
        'users.store'                  => ['route' => 'sentinel.users.index'],
        'users.update'                 => ['route' => 'sentinel.users.show', 'parameters' => ['user' => 'hash']],
        'users.destroy'                => ['route' => 'sentinel.users.index'],
        'users.change.password'        => ['route' => 'sentinel.users.show', 'parameters' => ['user' => 'hash']],
        'users.change.memberships'     => ['route' => 'sentinel.users.show', 'parameters' => ['user' => 'hash']],
        'users.suspend'                => ['route' => 'sentinel.users.index'],
        'users.unsuspend'              => ['route' => 'sentinel.users.index'],
        'users.ban'                    => ['route' => 'sentinel.users.index'],
        'users.unban'                  => ['route' => 'sentinel.users.index'],
        'groups.store'                 => ['route' => 'sentinel.groups.index'],
        'groups.update'                => ['route' => 'sentinel.groups.index'],
        'groups.destroy'               => ['route' => 'sentinel.groups.index'],
        'profile.change.password'      => ['route' => 'sentinel.profile.show'],
        'profile.update'               => ['route' => 'sentinel.profile.show'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable HTML Views
    |--------------------------------------------------------------------------
    |
    | There are situations in which you may not want to display any views
    | when interacting with Sentinel.  To return JSON instead of HTML,
    | turn this setting off. This cannot be done selectively.
    |
    */

    'views_enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Master Layout
    |--------------------------------------------------------------------------
    |
    | By default Sentinel views will extend their own master layout. However,
    | you can specify a custom master layout view to use instead.
    |
    */

    'layout' => 'Sentinel::layouts.default',

];