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
       <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
       <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
       @foreach(Config::get('app.available_locales') as $lang)
           @if($lang != Config::get('app.locale'))
           <style>
           #cke_body_{{$lang}} {
               display: none;
           }
       </style>
           @endif
       @endforeach
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
      <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- <script src="{{ asset('js/theme.min.js') }}"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
      <script src="{{ asset('js/summernote-image-title.js') }}"></script>
<script>
  $('.language li a').click(function(el){
    var _this = $(this);
    var len=  _this[0].href.indexOf('language/')
    var langValue = _this[0].href.slice(len+9,len+11).toLowerCase();
    localStorage.setItem('locale',langValue)

  });
</script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@if($notification = growl_notification())
<script type="text/javascript">
   $(function () {
     <?php echo $notification; ?>
   });
</script>
@endif
      <script>
          $(document).ready(function() {
              $('.summernote').summernote({
                  fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Poppins'],
                  fontNamesIgnoreCheck: ['Poppins'],
                  imageTitle: {
                      specificAltField: true,
                  },
                  // lang: 'en-US',
                  popover: {
                      image: [
                          ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                          ['float', ['floatLeft', 'floatRight', 'floatNone']],
                          ['remove', ['removeMedia']],
                          ['custom', ['imageTitle']],
                      ],
                  },
              });
          });
          // notification count
          var count = $('#count'), c ;
          c = parseInt(count.html());
          // count.html(c+1);
          // notification style
          $('.notification').on('click',function(){
              setTimeout(() => {
                  count.html(0);
                  $('.unread').each(function(){
                      $(this).removeClass('unread');
                  });
              }, 3000);
              //   $.get('MarkAllSeen', function(){});
          });
      </script>
@stack('scripts')
</body>
</html>
