## Sentinel: Sentry Implementation for Laravel

[![Build Status](https://travis-ci.org/rydurham/Sentinel.svg?branch=master)](https://travis-ci.org/rydurham/Sentinel)
[![Total Downloads](https://poser.pugx.org/rydurham/sentinel/d/total.svg)](https://packagist.org/packages/rydurham/sentinel)
[![License](https://poser.pugx.org/rydurham/sentinel/license.svg)](https://packagist.org/packages/rydurham/sentinel)

This package provides an implementation of  [Sentry 2](https://github.com/cartalyst/sentry) for [Laravel](https://github.com/laravel/laravel). By default it uses [Bootstrap 3.0](http://getbootstrap.com), but you can make use of whatever UI you want.  It is intended to be a very simple way to get up and running with User access control very quickly.  For simple projects you shouldn't need to do much more than drop it in and dial in the configuration.

The ```cartalyst/sentry``` auth package has been deprecated.  If you are using it in production you should upgrade to ```cartalyst/sentinel```.   This package will also eventually be deprecated.   __Do not use this package if you are starting a fresh application.__

__Important__ There are two PHP packages named "Sentinel".  This is ```rydurham/sentinel```, not ```cartalyst/sentinel```.  The key difference is that this package is intended to be an implementation of Sentry v2, whereas Cartalyst released what would have been Sentry v3 under the name ```cartalyst/sentinel```. The instructions below are specifically for ```rydurham/sentinel```,  make sure you are using the right package before proceeding.

If you are looking for a quick way to get up and running with ```cartalyst/sentinel```. [I have created a bridge package  that may be helpful](https://github.com/srlabs/centaur).  If you are starting a new Laravel project, I recommend using that package instead of this one.

__Releases__ There are several versions of this package, each intended for different versions of the Laravel framework.

| Laravel Version  | Sentinel Version  | Packagist Branch |
|---|---|---|
| 4.2.*  | 1.4.*  | ```"rydurham/sentinel": "~1.4"``` |
| 5.0.*  | 2.0.*  | ```"rydurham/sentinel": "~2.0"``` |
| 5.1.*  | 2.2.*  | ```"rydurham/sentinel": "~2.2"``` |
| 5.2.*  | 2.3.*  | ```"rydurham/sentinel": "~2.3"``` |
| 5.3.*  | 2.5.*  | ```"rydurham/sentinel": "~2.5"``` |
| 5.4.*  | 2.6.*  | ```"rydurham/sentinel": "~2.6"``` |
| 5.5.*  | 2.7.*  | ```"rydurham/sentinel": "~2.7"``` |

### Laravel 5 Instructions
**Install the Package Via Composer:**

```shell
$ composer require rydurham/sentinel
```

Make sure you have configured your application's Database and Mail settings.

This package uses ["package discovery"](https://laravel.com/docs/5.5/packages#package-discovery) to automatically register it's service provider with your application.

**Register the Middleware in your ```app/Http/Kernel.php``` file:**

```php
protected $routeMiddleware = [
    // ..
    'sentry.auth' => \Sentinel\Middleware\SentryAuth::class,
    'sentry.admin' => \Sentinel\Middleware\SentryAdminAccess::class,
    'sentry.member' => \Sentinel\Middleware\SentryMember::class,
    'sentry.guest' => \Sentinel\Middleware\SentryGuest::class,
];
```

**Publish the Views, Assets, Config files and migrations:**
```shell
php artisan sentinel:publish
```

You can specify a "theme" option to publish the views and assets for a specific theme:
```shell
php artisan sentinel:publish --theme="foundation"
```
Run ```php artisan sentinel:publish --list``` to see the currently available themes.

**Run the Migrations**
Be sure to set the appropriate DB connection details in your  ```.env``` file.

Note that you may want to remove the ```create_users_table``` and ```create_password_resets_table``` migrations that are provided with a new Laravel 5 application.

```shell
php artisan migrate
```

**Seed the Database:**
```shell
php artisan db:seed --class=SentinelDatabaseSeeder
```
More details about the default usernames and passwords can be [found here](https://github.com/rydurham/Sentinel/wiki/Seeds).

**Set a "Home" Route.**

Sentinel requires that you have a route named 'home' in your ```routes.php``` file:
```php
// app/routes.php
 Route::get('/', array('as' => 'home', function()
{
    return View::make('home');
}));
```

### Basic Usage
Once installed and seeded, you can make immediate use of the package via these routes:
* ```yoursite.com/login```
* ```yoursite.com/logout```
* ```yoursite.com/register```
* ```yoursite.com/users``` - For user management.  Only available to admins
* ```yoursite.com/groups``` - For group management. Only available to admins.

Sentinel also provides middleware which you can use to [prevent unauthorized access](http://laravel.com/docs/routing#route-filters) to your application's routes & methods.

* ```Sentinel\Middleware\SentryAuth``` - Require users to have an active session
* ```Sentinel\Middleware\SentryAdminAccess``` - Block access for everyone except users who have the 'admin' permission.
* ```Sentinel\Middleware\SentryMember``` - Limit access to members of a certain group. The group name is case sensitive.  For example:

```php
// app\Http\Controllers\ExampleController.php
public function __construct()
{
    $this->middleware('sentry.member:Admins');
}
```

* ```Sentinel\Middleware\SentryGuest``` - Redirect users who have an active session

### Advanced Usage
This package is intended for simple sites but it is possible to integrate into a larger application on a deeper level:
* Turn off the default routes (via the config) and manually specify routes that make more sense for your application
* Create a new User model that extends the default Sentinel User Model ```Sentinel\Models\User```.  Be sure to publish the Sentinel and Sentry config files (using the ```sentinel:publish``` command) and change the User Model setting in the Sentry config file to point to your new user model.
* Inject the ```SentryUserRepository``` and/or the ```SentryGroupRepository``` classes into your controllers to have direct access to user and group manipulation.  You may also consider creating custom repositories that extend the repositories that come with Sentinel.

It is not advisable to extend the Sentinel controller classes; you will be better off in the long run creating your own controllers from scratch.

#### Using Sentinel in Tests
If you find yourself in the situation where you want to do tests with user logged in, go to your ``` tests/TestCase.php `` and add this method:
```php
   /**
     * Login to sentry for Testing purpose
     * @param  $email
     * @return void
     */
    public function sentryUserBe($email='admin@admin.com')
    {
        $user = \Sentry::findUserByLogin($email);
        \Sentry::login($user);
        \Event::fire('sentinel.user.login', ['user' => $user]);
    }
```

You can then start testing your application with user logged in, as such:
```php
class ExampleTest extends TestCase
{
    /**
     * Dashboard functional test example.
     *
     * @return void
     */
    public function testDashboardPage()
    {
        $this->sentryUserBe('admin@admin.com');
        $this->visit('/dashboard')
             ->see('dashboard');
    }
}
```

### Documentation & Questions
Check the [Wiki](https://github.com/rydurham/Sentinel/wiki) for more information about the package:
* Configuration Options
* Events & Listeners
* Seed & Migration Details
* Default Routes

Any questions about this package should be posted [on the package website](http://www.ryandurham.com/projects/sentinel/).

### Localization
Sentinel has been translated into several other languages, and new translations are always welcome! Check out the [Sentinel Page](https://crowdin.com/project/sentinel) on CrowdIn for more details.
