<!-- Start Blog -->
<div class="blogs" id="blog">
    <div class="container">
    <div>
        <h2> @lang('Blog') </h2>
    </div>
    <div class="Blog-container">
    @foreach ($posts->slice(0, 6) as $post)
        <div class="blog_post">
            <div class="img_pod">
            <img  src="{{asset(Storage::url($post->cover))}}" alt="">
            </div>
            
            <div class="container_copy">
            <h1>{{$post->title}}</h1>
            <ul>
                  <li class="d-flex align-items-center"><i class="icon-user"></i> <a href="{{route('blogshow',$post->slug)}}">{{ $post->user->first_name.' '.$post->user->last_name  }}</a></li>
                  <li class="d-flex align-items-center"><i class="icon-clock"></i> <a href="{{route('blogshow',$post->slug)}}"><time datetime="2020-01-01">{{$post->created_at->format('Y-m-d')}}</time></a></li>
                  <li class="d-flex align-items-center"><i class="icon-comment"></i> <a href="{{ URL::current()}}#disqus_thread">@lang('Comments')</a></li>
                </ul>
                <div class="entry-content">
                <p>
                  {{ Str::limit( strip_tags( $post->body ), 150 ) }}
                </p>
                <div class="text-center" style="margin-top: 10px;"> <a class="btn_primary" href="{{route('blogshow',$post->slug)}}">@lang('Read More')</a></div>
              </div>
            </div>
         
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
      <h2 style="padding: 0 20px;">Videos</h2>
    </div><!-- Title -->

    <div id="gallery-images" class="owl-carousel">
        @foreach ($videos as $video)
      <div class="item">
      <!-- <iframe width="440" height="315" src="http://www.youtube.com/embed/qpv7sEjx52Y?"></iframe>  -->
        <!-- <iframe width="440" height="315" src="{{ $video->title}}"></iframe>  {{$video->url}} -->
        <iframe class="vid"  height="315" src="{{$video->url}}" frameborder="0" allowfullscreen></iframe>
        </div>
            {{--<iframe width="900" height="506" src="{{ $video->desc}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
            @endforeach
    </div>

</section>
<!-- /Gallery Section -->
</div>
<!-- End Blog -->
{{--<iframe width="900" height="506" src="https://www.youtube.com/embed/BVxYAIQLewA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>--}}
