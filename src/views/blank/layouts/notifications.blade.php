@if ($message = Session::get('success'))
<div class="sentinel-alert-success">
  <strong>Success:</strong> {!! $message !!}
</div>
{{ Session::forget('success') }}
@endif

@if ($message = Session::get('error'))
<div class="sentinel-alert-error">
  <strong>Error:</strong> {!! $message !!}
</div>
{{ Session::forget('error') }}
@endif

@if ($message = Session::get('warning'))
<div class="sentinel-alert-warning">
  <strong>Warning:</strong> {!! $message !!}
</div>
{{ Session::forget('warning') }}
@endif

@if ($message = Session::get('info'))
<div class="sentinel-alert-info">
  <strong>FYI:</strong> {!! $message !!}
</div>
{{ Session::forget('info') }}
@endif
