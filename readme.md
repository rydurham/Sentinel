## Sentinel: Sentry Implementation for Laravel 4

This pacakge provides an implementation of  [Sentry 2](https://github.com/cartalyst/sentry) for [Laravel 4](https://github.com/laravel/laravel/tree/develop). By default it uses [Bootstrap 3.0](http://getbootstrap.com), but you can make use of whatever UI you want.

### Instructions
This package can be installed using Composer:

```shell
$ composer require rydurham/sentinel
```

Make sure you have configured your app's Database and Mail settings. 

Add the Service Provider to your ```app/config/app.php``` file:

```php
'providers' => array(
    ...
    'Sentinel\SentinelServiceProvider', 
    ...
)
```  

Run the Migrations:
```shell
php artisan migrate --package=rydurham/sentinel
```

Seed the Database: 
```shell
php artisan db:seed --class="SentinelDatabaseSeeder"
```

Publish the package assets: 
```shell
php artisan asset:publish rydurham/sentinel
```

Set a "Home" Route.  This package requires that you have a named 'home' route in your ```routes.php``` file: 
```php
// Set Home Route
 Route::get('/', array('as' => 'home', function()
{
    return View::make('home');
}));
```

__Optional:__ Publish Views
```shell
php artisan view:publish rydurham/sentinel
```

__Optional:__ Publish Configuration
```shell
php artisan config:publish rydurham/sentinel
```
The config file will allow you to control many aspects of Sentinels operation. [Take a look](src/config/config.php) to see what options are available.  If you want to add fields to your user table, this can be done with the config options.

### Usage: Filters and Routes
Once installed, Sentinel adds a series of [routes](src/routes.php) for User interaction.  You will need to add links to these routes in your app's layouts.
* ```yoursite.tld/login``` 
* ```yoursite.tld/logout``` 
* ```yoursite.tld/register``` 
* ```yoursite.tld/users``` - For user management.  Only available to admins
* ```yoursite.tld/groups``` - For group management. Only available to admins.

Sentinel also provides these [filters](src/filters.php) which you can use to [prevent unauthorized access](http://laravel.com/docs/routing#route-filters) to your app's routes & methods. 

* ```Sentinel\auth``` - Require users to be successfully logged in
* ```Sentinel\inGroup:Admins``` - Block access to all but members of the Admin group. If you create your own groups, you can use it as such: ```Sentinel\inGroup:[YourGroup]```. 

### Documentation & Questions
Check the [Wiki](https://github.com/rydurham/Sentinel/wiki) for more information about the package:
* Config Options
* Events & Listeners
* Seed & Migration Details
* Default Routes
* Basic API Info  
* Package Version History

Any questions about this package should be posted [on the package website](http://www.ryandurham.com/projects/sentinel/).

### Localization
Sentinel has been translated into several other languages, and new translations are always welcome! Check out the [Sentinel Page](https://crowdin.com/project/sentinel) on CrowdIn for more details.

### Tests
Tests are powered by Codeception.  Currently they must be run within a Laravel application environment.   To run the tests: 
* Pull in the require-dev dependencies via composer. 
* Navigate to the Sentinel folder
* Run ```vendor/bin/codecept run```

I would reccommend turning on "Mail Pretend" in your testing mail config file.