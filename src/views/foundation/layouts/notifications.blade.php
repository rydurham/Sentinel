@if ($message = Session::get('success'))
<div class="row">
	<div data-alert class="alert-box success radius">
	  	<strong>Success:</strong> {!! $message !!}
	  	<a href="#" class="close">&times;</a>
	</div>
</div>
{{ Session::forget('success') }}
@endif

@if ($message = Session::get('error'))
<div class="row">
	<div data-alert class="alert-box error radius">
	  <strong>Error:</strong> {!! $message !!}
	  <a href="#" class="close">&times;</a>
	</div>
</div>
{{ Session::forget('error') }}
@endif

@if ($message = Session::get('warning'))
<div class="row">
	<div data-alert class="alert-box warning radius">
	  <strong>Warning:</strong> {!! $message !!}
	  <a href="#" class="close">&times;</a>
	</div>
</div>
{{ Session::forget('warning') }}
@endif

@if ($message = Session::get('info'))
<div class="row">
	<div data-alert class="alert-box info radius">
	  <strong>FYI:</strong> {!! $message !!}
	  <a href="#" class="close">&times;</a>
	</div>
</div>
{{ Session::forget('info') }}
@endif
