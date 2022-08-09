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
    <link href="{{ asset('front/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   @if(session()->get('locale')==='ar')
     <!-- <link href="{{ asset('front/css/old_style-ar.css') }}" rel="stylesheet"> -->
     <link href="{{ asset('front/css/style-ar.css') }}" rel="stylesheet">
      @else
      <!-- <link href="{{ asset('front/css/old_style.css') }}" rel="stylesheet"> -->
      <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">
    @endif
    {{--<link href="{{ asset('front/css/style-ar.css') }}" rel="stylesheet">--}}

    <!-- <link href="{{ asset('front/css/style.css') }}" rel="stylesheet"> -->
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
{{--@include('cookieConsent::index')--}}
@include('website.layouts.footer')

<script src="{{ asset('js/theme.min.js') }}"></script>
<script src="{{ asset('js/new.js') }}"></script>
<script src="{{ asset('front/swiper-bundle.min.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
        var swiper1 = new Swiper('.swiper1', {
    // Optional parameters
    direction: 'horizontal',
    speed: 1000,
    // loop: true,
    breakpoints: {

      300: {  // when window width from 300px to 576px
        slidesPerView: 1,
        spaceBetween: 30
      },
      576: {  // when window width from 576px to 767px
        slidesPerView: 1,
        spaceBetween: 30
      },
      767: { // when window width from 767px to 991px
        slidesPerView: 2,
        spaceBetween: 30
      },

      991: { // when window width from 991px to 1200px
        slidesPerView: 3,
        spaceBetween: 30
      },
      1200: { // when window width from 1200px to higher
        slidesPerView: 3.7,
        spaceBetween: 30
      },
    },
    // Navigation arrows
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true
      },


  });

  var swiper2 = new Swiper('.swiper2', {
    // Optional parameters
    direction: 'vertical',
    speed: 1000,
    // loop: true,

    slidesPerView: 2.5,
    // Navigation arrows
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true
      },


  });
    </script>
{{--{!! settings('website_footer_script') !!}--}}
</body>
</html>
