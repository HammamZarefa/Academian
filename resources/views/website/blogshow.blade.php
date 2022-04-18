@extends('website.layouts.template')

@section('title')
{{ $post->title }} - 
@endsection
@section('meta')

<!-- Primary Meta Tags -->
<meta name="title" content="{{ $post->title }}">
<meta name="description" content="{{ $post->meta_desc }}">
<meta name='keywords' content='{{ $post->keyword }}' />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="127.0.0.1:8000/blog/{{ $post->slug }}">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->meta_desc }}">
<meta property="og:image" content="{{ asset('storage/'.$post->cover) }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="127.0.0.1:8000/blog/{{ $post->slug }}">
<meta property="twitter:title" content="{{ $post->title }}">
<meta property="twitter:description" content="{{ $post->meta_desc }}">
<meta property="twitter:image" content="{{ asset('storage/'.$post->cover) }}">
@endsection

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>@lang('Blog') </h2>
          <ol>
            <li><a href="/">@lang('Home') </a></li>
            <li>@lang('Blog') </li>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 entries">
            <article class="entry entry-single" data-aos="fade-up">
              <div class="entry-img">
                <img src="{{ asset('storage/'.$post->cover) }}" alt="" class="img-fluid">
              </div>
              <h2 class="entry-title">
                <a href="{{route('blogshow',$post->slug)}}">{{ $post->title }}</a>
              </h2>
              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="icon-user"></i> <a href="{{route('blogshow',$post->slug)}}">{{ $post->user->first_name.' '.$post->user->last_name  }}</a></li>
                  <li class="d-flex align-items-center"><i class="icon-clock"></i> <a href="{{route('blogshow',$post->slug)}}"><time datetime="2020-01-01">{{ Carbon\Carbon::parse($post->created_at)->format("d F, Y") }}</time></a></li>
                  <li class="d-flex align-items-center"><i class="icon-comment"></i> <a href="{{ URL::current()}}#disqus_thread">@lang('Comments')</a></li>
                </ul>
              </div>

              <div class="entry-content">
                <p>
                  {!! $post->body !!}
                </p>
              </div>

              <div class="entry-footer clearfix">
                <div class="float-left">
                  <i class="icon-folder"></i>
                  <ul class="cats">
                    <li><a href="{{ route('category',$post->category->slug) }}">{{ $post->category->name }}</a></li>
                  </ul>

                  <i class="icon-tags"></i>
                  <ul class="tags">
                    @foreach ($tags as $tag)
                   <li><a href="{{ route('tag',$tag->slug) }}">{{ $tag->name }}</a></li>
                    @endforeach 
                  </ul>
                </div>

              </div>

            </article><!-- End blog entry -->

            <div class="blog-comments" data-aos="fade-up">
              <div id="disqus_thread"></div>
            </div><!-- End blog comments -->
          </div><!-- End blog entries list -->
          <div class="col-lg-4">
            <div class="sidebar" data-aos="fade-left">
              <h3 class="sidebar-title">@lang('Search')</h3>
              <div class="sidebar-item search-form">
                <form action="{{ route("search") }}" method="GET">
                  <input type="text" name="query">
                  <button type="submit"><i class="icon-search" style="font-size: 20px;"></i></button>
                </form>
              </div><!-- End sidebar search formn-->
              <h3 class="sidebar-title"> @lang('Categories')</h3>
              <div class="sidebar-item categories">
                <ul>
                  @foreach ($categories as $category)
                  <li><a href="{{ route('category',$category->slug) }}">{{ $category->name }} <span>({{ $category->count() }})</span></a></li>
                  @endforeach
                </ul>
              </div><!-- End sidebar categories-->
              <h3 class="sidebar-title">@lang('Recent Posts') </h3>
              <div class="sidebar-item recent-posts">
                @foreach ($recent as $recent)
                <div class="post-item clearfix">
                  <img src="{{ asset('storage/'.$recent->cover) }}" alt="">
                  <h4><a href="{{route('blogshow',$post->slug)}}">{{ $recent->title }}</a></h4>
                  <time datetime="2020-01-01">{{ Carbon\Carbon::parse($post->created_at)->format("d F, Y") }}</time>
                </div>
                @endforeach
              </div><!-- End sidebar recent posts-->
              <h3 class="sidebar-title">@lang('Tags') </h3>
              <div class="sidebar-item tags">
                <ul>
                  @foreach ($tags as $tag)
                   <li><a href="{{ route('tag',$tag->slug) }}">{{ $tag->name }}</a></li>
                  @endforeach 
                </ul>
              </div><!-- End sidebar tags-->
            </div><!-- End sidebar -->
          </div><!-- End blog sidebar -->
        </div>
      </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->
@endsection

