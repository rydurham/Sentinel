<?php

// As seen on http://blog.elenakolevska.com/laravel-alpha-validator-that-allows-spaces/
Validator::extend('alpha_spaces', function ($attribute, $value) {
    return preg_match('/^[\pL\s]+$/u', $value);
});
