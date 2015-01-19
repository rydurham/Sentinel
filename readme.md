## Sentinel: Sentry Implementation for Laravel 4

This pacakge provides an implementation of  [Sentry 2](https://github.com/cartalyst/sentry) for [Laravel 4](https://github.com/laravel/laravel/tree/develop). By default it uses [Bootstrap 3.0](http://getbootstrap.com), but you can make use of whatever UI you want.  It is intended to be a very simple way to get up and running with User access control very quickly.  For simple projects you shouldn't need to do much more than drop it in and dial in the configuration.

### Instructions
This package can be installed using Composer:

```shell
$ composer require rydurham/sentinel
```

Make sure you have configured your application's Database and Mail settings. 

Add the Service Provider to your ```app/config/app.php``` file:

```php
'providers' => array(
    ...
    'Sentinel\SentinelServiceProvider', 
    ...
)
```  

Publish the Views, Assets, Config files and migrations:
```shell
php artisan sentinel:publish
```

You can specify a "theme" option to publish the views and assets for a specific theme:  
```shell
php artisan sentinel:publish --theme="foundation"
```

Run ```php artisan sentinel:publish --list``` to see the currently available themes.

Seed the Database: 
```shell
php artisan db:seed --class="SentinelDatabaseSeeder"
```

Set a "Home" Route.  This package requires that you have a named 'home' route in your ```routes.php``` file: 
```php
// Set Home Route
 Route::get('/', array('as' => 'home', function()
{
    return View::make('home');
}));
```

### Basic Usage
Once installed and the database has been seeded, you can make immediate use of the package via these [routes](src/routes.php) :
* ```yoursite.com/login``` 
* ```yoursite.com/logout``` 
* ```yoursite.com/register``` 
* ```yoursite.com/users``` - For user management.  Only available to admins
* ```yoursite.com/groups``` - For group management. Only available to admins.

Sentinel also provides these [filters](src/filters.php) which you can use to [prevent unauthorized access](http://laravel.com/docs/routing#route-filters) to your application's routes & methods. 

* ```Sentinel\auth``` - Require users to be successfully logged in
* ```Sentinel\inGroup:Admins``` - Block access to all but members of the Admin group. If you create your own groups, you can use it as such: ```Sentinel\inGroup:[YourGroup]```. 
* ```Sentinel\hasAccess:[PermissionName]``` - Verifiy that the current user has a certain permission before proceeding.

### Advanced Usage
The recommended method for taking full advantage of this package in larger applications is to do the following:
* Turn off the default routes and manually specify routes that make more sense for your application
* Create a new User model that extends the default Sentinel User Model
* Inject the ```SentryUseRepository``` and/or the ```SentryGroupRepository``` classes into your controllers to have direct access to user and group manipulation.  You may also consider creating your own repositories that extend the repositories that come with the Sentinel. 

It is not advisable to extend the Sentinel Controller classes; you will be better off creating your own controllers from scratch. 

### Documentation & Questions
Check the [Wiki](https://github.com/rydurham/Sentinel/wiki) for more information about the package:
* Config Options
* Events & Listeners
* Seed & Migration Details
* Default Routes

Any questions about this package should be posted [on the package website](http://www.ryandurham.com/projects/sentinel/).

### Localization
Sentinel has been translated into several other languages, and new translations are always welcome! Check out the [Sentinel Page](https://crowdin.com/project/sentinel) on CrowdIn for more details.

### Tests
Tests are powered by Codeception.  Currently they must be run within a Laravel application environment.   To run the tests: 
* Pull in the require-dev dependencies via composer. 
* Navigate to the Sentinel folder
* Run ```vendor/bin/codecept run```

I would recommend turning on "Mail Pretend" in your testing mail config file.