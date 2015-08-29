<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title> 
			@section('title') 
			@show 
		</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- Normalize.css - https://github.com/necolas/normalize.css -->
		<link href="{{ asset('css/normalize.css') }}" rel="stylesheet">

		<!-- Sentinel Blank Theme CSS -->
		<link href="{{ asset('css/sentinel-blank-theme.css') }}" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	</head>

	<body>
		<div id="container">

			<!-- Navbar --> 
			<nav id="sentinel-navbar">		
				<div class="sentinel-navbar-header">
		        	<h1><a class="sentinel-nav" href="{{ URL::route('home') }}">Sentinel</a></h1>
		        </div>
		        <ul id="sentinel-navbar-right">
		           	@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
						<li {!! (Request::is('users*') ? 'class="active"' : '') !!}><a href="{{ URL::to('/users') }}">Users</a></li>
						<li {!! (Request::is('groups*') ? 'class="active"' : '') !!}><a href="{{ URL::to('/groups') }}">Groups</a></li>
					@endif
		            @if (Sentry::check())
    				<li {!! (Request::is('profile') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.profile.show') }}">{{ Sentry::getUser()->email }}</a></li>
    				<li><a href="{{ route('sentinel.logout') }}">Logout</a></li>
    				@else
    				<li {!! (Request::is('login') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.login') }}">Login</a></li>
    				<li {!! (Request::is('users/create') ? 'class="active"' : '') !!}><a href="{{ route('sentinel.register.form') }}">Register</a></li>
    				@endif
		        </ul>
			</nav>
			<!-- ./ navbar -->

			<!-- Container -->
			<div class="sentinel-content">
				<!-- Notifications -->
				@include('Sentinel::layouts/notifications')
				<!-- ./ notifications -->

				<!-- Content -->
				@yield('content')
				<!-- ./ content -->
			</div>

		</div>
		<!-- ./ container -->

		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('packages/rydurham/sentinel/js/jquery-2.1.3.min.js') }}"></script>
		<script src="{{ asset('packages/rydurham/sentinel/js/restfulizer.js') }}"></script> 
		<!-- Thanks to Zizaco for the Restfulizer script.  http://zizaco.net  -->
	</body>
</html>
