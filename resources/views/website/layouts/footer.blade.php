<footer class="footer">
    <div class="container">
        <div class="row">
           {{-- @foreach($reviews->slice(0, 3) as $review) --}}
            @foreach(\App\ServiceCategory::all()->slice(0, 1) as $service_category)
           <div class="col-sm-6">
               <h2> {{$service_category->name}}</h2>
               <ul class="link">
               @foreach($service_category->services as $service)
                  <li><a href="{{ route('instant_quote').'?service='.$service->id}}" style="color:#06243e">{{$service->name}}</a></li>
               @endforeach
               </ul>
           </div>
           @endforeach
           @foreach(\App\ServiceCategory::all()->slice(1, 3) as $service_category)
           <div class="col-sm-2 col-4 other">
               <h2> {{$service_category->name}}</h2>
               <ul class="link">
               @foreach($service_category->services as $service)
                  <li><a href="{{ route('instant_quote').'?service='.$service->id}}" style="color:#06243e">{{$service->name}}</a></li>
               @endforeach
               </ul>
           </div>
           @endforeach
            <div class="col-sm-4 pay">
                <h4 class="footer_left">@lang('Pay With:')</h4>
                <div class="pay-icon">
                    <a href=""><img src="{{ asset('front/img/cards/card-01.png') }}" alt="card"></a> 
                    <a href=""> <img src="{{ asset('front/img/cards/card-05.png') }}" alt="card"></a> 
                    <a href=""> <img src="{{ asset('front/img/cards/card-06.png') }}" alt="card"></a> 
                </div>
              
            </div>
            <div class="col-sm-4 social-mediav text-end"> 
                    <a href="https://www.facebook.com/Academianuk" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Facebook" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="https://twitter.com/academianuk" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Twitter" target="_blank"><i class="icon-twitter" ></i></a>
                    <a href="http://linkedin.com/academianuk" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Linkedin" target="_blank"><i class="icon-linkedin"></i></a>
                    <a href="https://www.pinterest.com/academianuk/" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                    <a href="https://www.youtube.com/channel/UCuVlEc-VubMayqP9IhtLOBw" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Youtube" target="_blank"><i class="icon-play"></i></a>
                    <a href="http://academianuk.tumblr.com/" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Tumblr" target="_blank"><i class="icon-tumblr"></i></a>
                    <a href="https://academianuk.blogspot.com/" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Blogger" target="_blank"><i class="icon-blogspot"></i></a>
                    <a href="https://www.tiktok.com/academianuk" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Tiktok" target="_blank"><i class="icon-tiktok"></i></a>
                    <a href="https://www.instagram.com/academianuk" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                </div>
            <div class="col-sm-4 Support">
               <a href="">@lang('Customer Support')</a>
               <a href="">@lang('Privacy Policy')</a>
            </div>
        </div>
    </div>
</footer>
<div id='siteLoader'>
<div class="loader"></div>
</div>

<!-- ======================= JQuery libs =========================== -->
<!-- jQuery -->
<script src="{{ asset('front/js/jquery-1.9.1.min.js') }}"></script>

<!-- <script src="{{ asset('front/js/bootstrap.min.js') }}"></script> -->

<!--Scroll To-->
<!-- <script src="{{ asset('front/js/nav/jquery.scrollTo.js') }}"></script> -->
<!-- <script src="{{ asset('front/js/nav/jquery.nav.js') }}"></script> -->

<!-- Responsive Video -->
<!-- <script src="{{ asset('front/js/jquery.fitvids.min.js')}}"></script> -->
<!-- <script src="{{ asset('front/js/jquery.placeholder.min.js') }}"></script> -->

<!-- Fixed menu -->
<!-- <script src="{{ asset('front/js/jquery-scrolltofixed.js') }}"></script> -->

<!-- Video -->
<!-- <script src="{{ asset('front/js/jquery.mb.YTPlayer.js') }}"></script> -->

<!-- Custom -->
<script src="{{ asset('front/js/script.js') }}"></script>
<!-- <script src="{{ asset('js/theme.min.js') }}"></script> -->