<!-- Start Blog -->
<div class="blog" id="blog">
    <div>
        <h2> @lang('Blog') </h2>
    </div>
    <div class="Blog-container">
       
        <div class="blog_post">
            <div class="img_pod">
            <img  src="{{ asset('front/img/classes-modal/02.jpg') }}" alt="">
            </div>
            <div class="container_copy">
            <h3>12 January 2019</h3>
            <h1>CSS Positioning</h1>
            <p>The position property specifies the type of positioning method used for an element (static, relative, absolute, fixed, or sticky).</p>
            </div>
            <a class="btn_primary" href='#'>Read More</a>
        </div>
        
        
        <div class="blog_post">
            <div class="img_pod">
            <img  src="{{ asset('front/img/classes-modal/02.jpg') }}" alt="">
            </div>
            <div class="container_copy">
            <h3>12 January 2019</h3>
            <h1>CSS Positioning</h1>
            <p>The position property specifies the type of positioning method used for an element (static, relative, absolute, fixed, or sticky).</p>
            </div>
            <a class="btn_primary" href='#'>Read More</a>
        </div>
        
      
        <div class="blog_post">
            <div class="img_pod">
            <img  src="{{ asset('front/img/classes-modal/02.jpg') }}" alt="">
            </div>
            <div class="container_copy">
            <h3>12 January 2019</h3>
            <h1>CSS Positioning</h1>
            <p>The position property specifies the type of positioning method used for an element (static, relative, absolute, fixed, or sticky).</p>
            </div>
            <a class="btn_primary" href='#'>Read More</a>
        </div>
        
    </div>
    <div class="text-center mb-100">
        <a href="" class="btn">Read More</a>
    </div>

    <!-- Section Gallery ********************************** -->
<section class="gallery">
    <div class="title">
      <h2 style="padding: 0 20px;">Some video previews for you. <b>Click to zoom</b></h2>
    </div><!-- Title -->

    <div id="gallery-images" class="owl-carousel">
      <div class="item">
            <video autoplay=""  loop="" controls=""><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video autoplay=""  loop="" controls=""><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video autoplay=""  loop="" controls=""><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video autoplay=""  loop="" controls=""><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
      </div>
      <div class="item">
            <video autoplay=""  loop="" controls=""><source  class="sc" src="{{ asset('front/img/awesome-video2.mp4') }}"  /></video>
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
