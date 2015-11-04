<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <title>@yield('title')</title>

    <!-- CSS  -->
    <link href="{{ asset('packages/rydurham/sentinel/css/materialize.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="{{ asset('packages/rydurham/sentinel/css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>
    <nav class="red lighten-1" role="navigation">
        <div class="container">
            <div class="nav-wrapper"><a id="logo-container" href="{{ route('home') }}" class="brand-logo">Sentinel</a>
                <ul id="nav-mobile" class="right side-nav">
                    @if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                        <li {!! (Request::is('users*') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.users.index') }}">Users</a></li>
                        <li {!! (Request::is('groups*') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.groups.index') }}">Groups</a></li>
                    @endif
                    @if (Sentry::check())
                        <li {!! (Request::is('profile') ? 'class="active"' : '') !!}>
                            <a href="{{ route('sentinel.profile.show') }}">{{ Sentry::getUser()->email }}</a>
                        </li>
                        <li><a href="{{ route('sentinel.logout') }}">Logout</a></li>
                    @else
                        <li {!! (Request::is('login') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.login') }}">Login</a></li>
                        <li {!! (Request::is('users/create') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.register.form') }}">Register</a></li>
                    @endif
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <!-- Content -->
            @yield('content')
            <!-- ./ content -->
        </div>
    </div>
    <!-- ./ container -->

    <!-- Javascripts
    ================================================== -->
    <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="{{ asset('packages/rydurham/sentinel/js/materialize.min.js') }}"></script>
    <script src="{{ asset('packages/rydurham/sentinel/js/restfulizer.js') }}"></script>
    <!-- Thanks to Zizaco for the Restfulizer script.  http://zizaco.net  -->
    <script language="javascript">
        (function($){
            $(function(){
                $('.button-collapse').sideNav();

                // Show session messages if necessary
                @if ($message = Session::get('success'))
                    toast("{!! $message !!}", 5000);
                @endif
                @if ($message = Session::get('error'))
                    toast("{!! $message !!}", 5000);
                @endif
                @if ($message = Session::get('warning'))
                    toast("{!! $message !!}", 5000);
                @endif
                @if ($message = Session::get('info'))
                    toast("{!! $message !!}", 5000);
                @endif
            }); // end of document ready
        })(jQuery); // end of jQuery name space
    </script>
</body>
</html>
