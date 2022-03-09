@extends('layouts.app')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-3">
         <h4>Settings</h4>  
         <small class="mb-2 form-text text-muted">Version : {{ settings('prowriters_version') }}</small>
         <div class="sticky-top">@include('setup.partials.menu')</div>      
      </div>
      <div class="col-md-9">
         <div id="settings">
            @yield('setting_page')
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
@yield('innerPageJS')
@endpush