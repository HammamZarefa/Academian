<!doctype html>
<html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
     <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title') - {{  get_company_name()  }}</title>
     <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
     <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
     @stack('stylesheets')
   </head>
   <body class="body d-flex flex-column h-100">
      <div id="app" class="flex-grow-1">
         @include('layouts.menu')
         <main>@yield('content')</main>
      </div>
      @include('layouts.footer')

<script type="text/javascript">
      window.currencyConfig = {!! currencyConfig() !!};
</script>
<script src="{{ asset('js/app.js') }}"></script>
@if($notification = growl_notification())
<script type="text/javascript">
   $(function () {     
     <?php echo $notification; ?>     
   });
</script>
@endif
@stack('scripts')
</body>
</html>