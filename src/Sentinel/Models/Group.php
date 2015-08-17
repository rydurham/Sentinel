<?php

namespace Sentinel\Models;

use Hashids;

class Group extends \Cartalyst\Sentry\Groups\Eloquent\Group
{
    /**
     * Use a mutator to derive the appropriate hash for this group
     *
     * @return mixed
     */
    public function getHashAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }
}
