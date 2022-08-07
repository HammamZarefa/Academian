<!-- Start Blog -->
<div class="post po">
    <div class="container">
    <div class="head">
        <h2> @lang('Blog') </h2>
       <button class="main-button">
       <a href="{{route('blog')}}" class="btn">
         @lang('See More')
         <i class="fas fa-arrow-right"></i>
        </a>
       </button> 
    </div>
        <div class="swiper1">
          <div class="swiper-wrapper">
            <!-- ****** item ****** -->
            <div class="swiper-slide"> 
              <img src="{{ asset('front/img/blog-recent-posts-4.jpg') }}" alt="">  
              <h3 class="title">
              Project and Production Management in the Built Environment - Sydney Opera House
              </h3>     
              <div class="date">
                <span>Firas llan </span>
                <span>16-05-2022</span>
              </div>
            </div>
            <!-- ****** item ****** -->
            <div class="swiper-slide"> 
              <img src="{{ asset('front/img/blog-recent-posts-4.jpg') }}" alt="">  
              <h3 class="title">
              Project and Production Management in the Built Environment - Sydney Opera House
              </h3>     
              <div class="date">
                <span>Firas llan </span>
                <span>16-05-2022</span>
              </div>
            </div>
            <!-- ****** item ****** -->
            <div class="swiper-slide"> 
              <img src="{{ asset('front/img/blog-recent-posts-4.jpg') }}" alt="">  
              <h3 class="title">
              Project and Production Management in the Built Environment - Sydney Opera House
              </h3>     
              <div class="date">
                <span>Firas llan </span>
                <span>16-05-2022</span>
              </div>
            </div>
            <!-- ****** item ****** -->
            <div class="swiper-slide"> 
              <img src="{{ asset('front/img/blog-recent-posts-4.jpg') }}" alt="">  
              <h3 class="title">
              Project and Production Management in the Built Environment - Sydney Opera House
              </h3>     
              <div class="date">
                <span>Firas llan </span>
                <span>16-05-2022</span>
              </div>
            </div>
            <!-- ****** item ****** -->
          </div>
          <!-- Add Scrollbar -->
          <div class="swiper-pagination"></div>
        </div>

      <div class="row">
        <div class="col-md-5 con-sw">
        <div class="swiper2">
          <div class="swiper-wrapper">
            <!-- ****** item ****** -->
            @foreach($reviews->slice(0, 3) as $review)
            <div class="swiper-slide"> 
              <div class="info">
                <i class="fas fa-user-circle fa-2x"></i>
                <div>
                  <h2>{{$review->name}}</h2>
                  <p> {{$review->created_at->format('Y-m-d')}}</p>
                </div>
              </div>
              <div class="info2">
                <h2>{{$review->profession}}</h2>
                <p> {{$review->desc}}</p>
              </div>
            </div>
            @endforeach
          </div>
          <!-- Add Scrollbar -->
          <div class="swiper-pagination"></div>
        </div>
        </div>
        <div class="col-md-6 con-sf">
          <h2> Our Clients Words Matter To Us</h2>
          <p>Here’s what our clients think about us and about the experience they had while trying our services.</p>
          <button class="main-button">
              <a href="{{route('blog')}}" class="btn">
              @lang('Get Quote')
                <i class="fas fa-arrow-right"></i>
              </a>
          </button> 
        </div>
      </div>

    </div>
</div>
<!-- Start Blog -->
<div class="post">
    <div class="container">
    <div class="head">
        <h2> @lang('Videos') </h2>
       <button class="main-button">
       <a href="{{route('blog')}}" class="btn">
         @lang('See More')
         <i class="fas fa-arrow-right"></i>
        </a>
       </button> 
    </div>
        <div class="swiper1">
          <div class="swiper-wrapper">
            <!-- ****** item ****** -->
            @foreach ($videos as $video)
            <div class="swiper-slide"> 
            <div class="item">
            <!-- <iframe width="440" height="315" src="http://www.youtube.com/embed/qpv7sEjx52Y?"></iframe>  -->
              <!-- <iframe width="440" height="315" src="{{ $video->title}}"></iframe>  {{$video->url}} -->
              <iframe class="vid"  height="250" src="{{$video->url}}" frameborder="0" allowfullscreen></iframe>
            </div>
            {{--<iframe width="900" height="506" src="{{ $video->desc}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
            </div>
            @endforeach  
          </div>
          <!-- Add Scrollbar -->
          <div class="swiper-pagination"></div>
        </div>

    </div>
</div>
<!-- End Blog -->
{{--<iframe width="900" height="506" src="https://www.youtube.com/embed/BVxYAIQLewA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
