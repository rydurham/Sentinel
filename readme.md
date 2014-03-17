## Sentinel: Sentry Implementation for Laravel 4

This pacakge provides an implementation of  [Sentry 2](https://github.com/cartalyst/sentry) for [Laravel 4](https://github.com/laravel/laravel/tree/develop). By default it uses [Bootstrap 3.0](http://getbootstrap.com), but you can make use of whatever UI you want. 

This package is based on my [L4withSentry](https://github.com/rydurham/L4withSentry) demo repo. 

### Instructions
Add this package to your composer.json file: 

```
"require": {
    "laravel/framework": "4.1.*",
    "rydurham/sentinel": "1.*"
},
```
Run Composer Update

Make sure you have configured your app's Database and Mail settings. 

Add the Service Provider to your ```app/config/app.php``` file:

```
'providers' => array(
     ...
    'Sentinel\SentinelServiceProvider',  
    )
```  

Run the Migrations:
```
php artisan migrate --package=rydurham/sentinel
```

Seed the Database: 
```
php artisan db:seed --class="SentinelDatabaseSeeder"
```

Publish the package assets: 
```
php artisan asset:publish rydurham/sentinel
```

Set a "Home" Route.  This package requires that you have a named 'home' route in your ```routes.php``` file: 
```
// Set Home Route
 Route::get('/', array('as' => 'home', function()
{
    return View::make('home');
}));
```

__Optional:__ Publish Views
```
php artisan view:publish rydurham/sentinel
```

__Optional:__ Publish Configuration
```
php artisan config:publish rydurham/sentinel
```
The config options will allow you to change the URL paths used by the package, as well as the subject lines for the emails sent to users. 

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
* Events & Listeners
* Seed & Migration Details
* Default Routes
* Basic API Info  

Any questions about this package should be posted [on the package website](http://www.ryandurham.com/projects/sentinel/).


### To Do
* Set up testing with Travis
* Increase test coverage - currently the tests are very limited.
* Need to determine best practice for default home view.  
* Add More languages? 

### History
* __1.4.1__ Bug fixes.
* __1.4__  Added Event triggers to allow users to set up custom functionality. 
* __1.3.1__ Moved Custom Validation messages into Language file. 
* __1.3__ Added configuration option to turn Registration on or off. 
* __1.2.1__ Added Redirect::guest()
* __1.2__ Added config option for default views, fixed filter namespacing, added Italian language files. 
* __1.1__ Added Config options. Moved named routes into 'Sentinel' namespace.
* __1.0__ Initial version.  A direct port of [L4withSentry](https://github.com/rydurham/L4withSentry) into package form. 

### Thanks
* Many thanks to [@rossey](https://github.com/rossey) for pushing to make this happen, and for providing a great [starting point](https://github.com/wearebase/sentry-manager-laravel-package).   
* These two books helped immensely: [*Laravel: From Apprentice to Artisan*](https://leanpub.com/laravel) by Taylor Otwell, [*Implementing Laravel*](https://leanpub.com/implementinglaravel) by Chris Fidao
* The [Laracast videos](http://laracasts.com) are awesome - check them out if you have not already. 
                  
