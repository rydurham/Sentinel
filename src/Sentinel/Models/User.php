<?php namespace Sentinel\Models;

use Hashids;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class User extends \Cartalyst\Sentry\Users\Eloquent\User implements UserContract {

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
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
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        // TODO: Implement getReminderEmail() method.
    }

    /**
     * Set the "hash" attribute for this model dynamically
     */
    public function getHashAttribute()
    {
        return Hashids::encode($this->id);
    }
}