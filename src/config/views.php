<?php

return array(

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

    'enabled' => true,

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

);