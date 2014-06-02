<?php

/**
 * Register View Composers and their associated views
 */

View::composers(array(
    'Sentinel\Composers\SuspendComposer' => 'Sentinel::users.suspend',
));