<!-- Start Blog -->
<div class="blogs" id="blog">
    <div class="container">
    <div>
        <h2> @lang('Blog') </h2>
    </div>
    <div class="Blog-container">
       @foreach($posts as $post)
        <div class="blog_post">
            <div class="img_pod">
            <img  src="{{asset(Storage::url($post->cover))}}" alt="">
            </div>
            <div class="container_copy">
            <h3>{{$post->created_at->format('Y-m-d')}}</h3>
            <h1>{{$post->title}}</h1>
            <p>{{$post->body}}</p>
            </div>
            <a class="btn_primary" href="{{route('blogshow',$post->slug)}}">@lang('Read More')</a>
        </div>
        @endforeach
    </div>
    <div class="text-center mb-100">
        <a href="{{route('blog')}}" class="btn">@lang('Read More')</a>
    </div>
    </div>
    <!-- Section Gallery ********************************** -->
<section class="gallery">
    <div class="title">
      <h2 style="padding: 0 20px;">Some video previews for you. <b>Click to zoom</b></h2>
    </div><!-- Title -->

    <div id="gallery-images" class="owl-carousel">
        @foreach ($videos as $video)
      <div class="item">
      <!-- <iframe width="440" height="315" src="http://www.youtube.com/embed/qpv7sEjx52Y?"></iframe>  -->
        <!-- <iframe width="440" height="315" src="{{ $video->desc}}"></iframe>   -->
        <iframe width="440" height="315" src="https://www.youtube.com/embed/qpv7sEjx52Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
            {{--<iframe width="900" height="506" src="{{ $video->desc}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
            @endforeach
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
