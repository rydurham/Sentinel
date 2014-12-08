<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Routes
    |--------------------------------------------------------------------------
    |
    | Sentinel provides default routes for each of its components, but you can
    | alter those route paths here.  Note that this only changes the URL path,
    | not the names of the routes.
    |
    */

    'routes' => array(

        'users'     => array(
            'route' => 'users',
            'enabled' => true,
        ),

        'groups'    => array(
            'route' => 'groups',
            'enabled' => true,
        ),

        'sessions'  => array(
            'route' => 'sessions',
            'enabled' => true,
        ),

        'login'     => array(
            'route' => 'login',
            'enabled' => true,
        ),

        'logout'    => array(
            'route' => 'logout',
            'enabled' => true,
        ),

        'register'  => array(
            'route' => 'register',
            'enabled' => true,
        ),

        'resend'    => array(
            'route' => 'resend',
            'enabled' => true,
        ),

        'forgot'    => array(
            'route' => 'forgot',
            'enabled' => true,
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Default Event Routes
    |--------------------------------------------------------------------------
    |
    | At certain points in the login and registration process Sentinel will
    | redirect the browser upon the completion of an event.  To change those
    | redirect locations, provide the name of a different route.
    |
    */

    'post_login'    => 'home',

    'post_logout'   => 'home',

    'post_confirmation_sent' => 'home', // Edit this to show your own 'confirmation sent!' page if you like.

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

    'welcome'           => 'Account Registration Confirmation',

    'reset_password'    => 'Password Reset Confirmation',

    'new_password'      => 'New Password Information',


    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | By default, the views provided by the package will extend their own
    | default view (views/layouts/default.blade.php), even after they have been
    | published.  This option allows you to extend a custom view instead.
    |
    */

    'layout' => 'Sentinel::layouts.default',


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

    'activation' => true,

    /*
    |--------------------------------------------------------------------------
    | Default User Groups
    |--------------------------------------------------------------------------
    |
    | When a new user is created, they will automatically be added to the
    | groups in this array.
    |
    */

    'default_user_groups' => array('Users'),

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

    'additional_user_fields' => array(
        //'field_name' => 'validation'
    ),

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

);
