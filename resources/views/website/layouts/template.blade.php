<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@if(Session::has('seo_was_set'))
{!! SEO::generate() !!}
@endif
{{--<link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">--}}
{{--<link href="{{ asset('css/theme.min.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <link href="{{ asset('front/font/fontello.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/media-queries.css') }}" rel="stylesheet">
{!! settings('website_header_script') !!}
@include('website.google_analytics')
    <style id="loader_helper" type="text/css">
        .tp-simpleresponsive >ul >li{visibility: hidden !important;}
    </style>
</head>
<body>
@include('website.layouts.header')
<div id="app">
    @yield('content')  
</div>
@include('cookieConsent::index')
@include('website.layouts.footer') 

<script src="{{ asset('js/theme.min.js') }}"></script>
{!! settings('website_footer_script') !!}
</body>
</html>