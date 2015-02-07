@if ($message = Session::get('success'))
<div class="twelve columns">
  <li class="success alert"><strong>Success:</strong> {!! $message !!}</li>
</div>
{{ Session::forget('success') }}
@endif

@if ($message = Session::get('error'))
<div class="twelve columns">
  <li class="danger alert"><strong>Error:</strong> {!! $message !!}</li>
</div>
{{ Session::forget('error') }}
@endif

@if ($message = Session::get('warning'))
<div class="twelve columns">
  <li class="warning alert"><strong>Warning:</strong> {!! $message !!}</li>
</div>
{{ Session::forget('warning') }}
@endif

@if ($message = Session::get('info'))
<div class="twelve columns">
  <li class="info alert"><strong>FYI:</strong> {!! $message !!}</li>
</div>
{{ Session::forget('info') }}
@endif
