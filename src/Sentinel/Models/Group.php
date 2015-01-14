<?php namespace Sentinel\Models;

use Hashids;

class Group extends \Cartalyst\Sentry\Groups\Eloquent\Group {

    /**
     * Set the "hash" attribute for this model dynamically
     */
    public function getHashAttribute()
    {
//        dd($this->attributes['id']);
        return Hashids::encode($this->id);
    }
}