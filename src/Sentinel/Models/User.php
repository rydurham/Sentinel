<?php

namespace Sentinel\Models;

use Hashids;
use Cartalyst\Sentry\Throttling\Eloquent\Throttle;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class User extends \Cartalyst\Sentry\Users\Eloquent\User implements UserContract
{
    /**
     * The throttle object for this user, if one exists
     * @return Throttle|null
     */
    public function throttle()
    {
        return $this->hasOne('Cartalyst\Sentry\Throttling\Eloquent\Throttle', 'user_id');
    }

    /**
     * Set the Sentry User Model Hasher to be the same as the configured Sentry Hasher
     */
    public static function boot()
    {
        parent::boot();
        static::setHasher(app()->make('sentry.hasher'));
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->getPersistCode();
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->persist_code = $value;

        $this->save();
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return "persist_code";
    }

    /**
     * Use a mutator to derive the appropriate hash for this user
     *
     * @return mixed
     */
    public function getHashAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }

    /**
     * Use an accessor method to get the user's status from the throttle table
     * @return [type] [description]
     */
    public function getStatusAttribute()
    {
        $status = "Not Active";
        if ($this->isActivated()) {
            $status = "Active";
        }

        //Check for suspension
        if ($this->throttle && $this->throttle->isSuspended()) {
            $status = "Suspended";
        }

        //Check for ban
        if ($this->throttle && $this->throttle->isBanned()) {
            $status = "Banned";
        }

        return $status;
    }
}
