<!-- Start Blog -->
<div class="blog" id="blog">
    <div>
        <h2> @lang('Blog') </h2>
    </div>
    <div class="Blog-container">
        <a href="">
        <div class="Blog-item" >
            <div class="blog-img">
                <img  src="{{ asset('front/img/classes-modal/02.jpg') }}" alt="">
            </div>
            <div class="Blog-body">
                <h3 class="Blog-title">@lang('Title')</h3>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit')</p>
                <ul class="utility-list">
                    <li><span class="licon icon-like"><i class="icofont-eye-alt"></i></span>@lang('views')  /</li>
                    <li><span class="licon icon-dat"><i class="icofont-clock-time"></i></span>03 @lang('jun')  2017 /</li>
                    <li><span class="licon icon-tag"><i class="icofont-label"></i></span>@lang('keyword')</li>
                </ul>
            </div>
        </div>
        </a>
        <a href="">
        <div class="Blog-item" >
            <div class="blog-img">
                <img  src="{{ asset('front/img/classes-modal/02.jpg') }}" alt="">
            </div>
            <div class="Blog-body">
                <h3 class="Blog-title">Title</h3>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit')</p>
                <ul class="utility-list">
                    <li><span class="licon icon-like"><i class="icofont-eye-alt"></i></span>@lang('views')   /</li>
                    <li><span class="licon icon-dat"><i class="icofont-clock-time"></i></span>03 @lang('jun') 2017 /</li>
                    <li><span class="licon icon-tag"><i class="icofont-label"></i></span>@lang('keyword')</li>
                </ul>
            </div>
        </div>
        </a>
        <a href="">
        <div class="Blog-item" >
            <div class="blog-img">
                <img  src="{{ asset('front/img/classes-modal/02.jpg') }}" alt="">
            </div>
            <div class="Blog-body">
                <h3 class="Blog-title">Title</h3>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit')</p>
                <ul class="utility-list">
                    <li><span class="licon icon-like"><i class="icofont-eye-alt"></i></span>@lang('views')   /</li>
                    <li><span class="licon icon-dat"><i class="icofont-clock-time"></i></span>03 @lang('jun') 2017 /</li>
                    <li><span class="licon icon-tag"><i class="icofont-label"></i></span>@lang('keyword')</li>
                </ul>
            </div>
        </div>
        </a>
    </div>
    <div class="text-center mb-100">
        <a href="" class="btn">Read More</a>
    </div>

    <!-- Section Gallery ********************************** -->
<section class="gallery">
    <div class="title">
      <h2>Some video previews for you. <b>Click to zoom</b></h2>
    </div><!-- Title -->

    <div id="gallery-images" class="owl-carousel">
      <div class="item">
            <video loop><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video loop><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video loop><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video loop><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video loop><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
    </div> 
        <div class="overlay" id="overlay"></div>
        <!-- type="video/mp4" -->
        <div id="show_videos">
        <video id="video" autoplay="" loop="" controls=""></video>
        </div>
</section>
<!-- /Gallery Section -->
</div>
<!-- End Blog -->
