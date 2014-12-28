<?php

return array(

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

    'activation_required' => true,

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

);
