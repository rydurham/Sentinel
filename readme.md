## Sentinel: Sentry Implementation for Laravel 4

This pacakge provides an implementation of  [Sentry 2](https://github.com/cartalyst/sentry) for [Laravel 4](https://github.com/laravel/laravel/tree/develop). By default it uses [Bootstrap 3.0](http://getbootstrap.com), but you can make use of whatever UI you want. 

This package is based on my [L4withSentry](https://github.com/rydurham/L4withSentry) demo repo. 

### Instructions
1. Add this package to your composer.json file: 
        "require": {
            "laravel/framework": "4.1.*",
            "rydurham/sentinel": "1.*"
        },
2. Run Composer Update
3. Make sure you have configured your app's Database and Mail settings. 
4. Add the Service Provider to your ```app/config/app.php``` file:
```
'providers' => array(
    ...
    'Sentinel\SentinelServiceProvider',  
)
```  
5. Run the Migrations
6. Run DB Seed
7. Publish Assets
Set Home Route: 
// Set Home Route






1. Clone the repo
2. Run ```php composer.phar update```
3. Set up your datbase configuration in ```app/config/database.php```
4. Edit ```app/config/mail.php``` to work with your mail setup.
5. Run the migrations: ```php artisan migrate```
6. Seed the Database: ```php artisan db:seed```

### Seeds
The seeds in this repo will create two groups and two user accounts.

__Groups__
* Users
* Admins

__Users__
* user@user.com  *Password: sentryuser*
* admin@admin.com *Password: sentryadmin*

### To Do
* Set up testing with Travis
* Increase test coverage - currently the tests are very limited.
* Configuration options:  It may be useful to allow for configuring the route paths, Email Template details and whatnot. 
* Need to determine best practice for default home view.  
* Add More languages? 

### Thanks
* Many thanks to [@rossey](https://github.com/rossey) for pushing to make this happen, and for providing a great [starting point](https://github.com/wearebase/sentry-manager-laravel-package).   
* These two books helped immensely: [*Laravel: From Apprentice to Artisan*](https://leanpub.com/laravel) by Taylor Otwell, [*Implementing Laravel*](https://leanpub.com/implementinglaravel) by Chris Fidao
* The [Laracast videos](http://laracasts.com) are awesome - check them out if you have not already. 
      