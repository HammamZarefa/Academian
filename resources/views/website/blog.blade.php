@extends('website.layouts.template')
@section('title')
  Blog -
@endsection

@section('content')
  <main>
    <!-- ======= Breadcrumbs ======= -->
    <section class="blogs-list">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 ">
            <h2 class="title">
              <a>@lang('Home')</a>
              <span class="rig">></span>
              <a>@lang('Blog')</a>
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="sidebar" id="sidebar-blog">
              <div class="sidebar-item search-form">
                <form action="{{ route("search") }}" method="GET" style="display: flex;align-items: center;justify-content: space-around;">
                  <input type="text" name="query" placeholder="Search">
                  <button type="submit"><i class="icon-search" style="font-size: 20px;"></i></button>
                </form>
              </div><!-- End sidebar search formn-->
              <h3 class="sidebar-title"> @lang('Categories') </h3>
              <div class="sidebar-item categories">
                <ul>
                  @foreach ($categories as $category)
                    <li><a href="{{ route('category',$category->slug) }}">{{ $category->name }} <span>({{ $category->count() }})</span></a></li>
                  @endforeach
                </ul>
              </div>
              <h3 class="sidebar-title">@lang('Tags') </h3>
              <div class="sidebar-item tags">
                <ul>
                  @foreach ($tags as $tag)
                    <li style="margin-bottom: 5px;"><a href="{{ route('tag',$tag->slug) }}">{{ $tag->name }}</a></li>
                  @endforeach
                </ul>
              </div>
            </div>

              <div class="recent-blog">

              </div>
          </div>
          <div class="col-sm-8">
            <!-- item -->
            <a href="">
              <div class="blog-item">
                <img src="{{ asset('front/img/Blog 1.jpg') }}" alt="">
                <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
                <div class="date">
                  <span>@lang('Firas illa')</span>
                  <span>@lang('16-05-2022')</span>
                </div>
              </div>
            </a>
            <!-- item -->
            <a href="">
              <div class="blog-item">
                <img src="{{ asset('front/img/Blog 1.jpg') }}" alt="">
                <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
                <div class="date">
                  <span>@lang('Firas illa')</span>
                  <span>@lang('16-05-2022')</span>
                </div>
              </div>
            </a>
            <!-- item -->
            <a href="">
              <div class="blog-item">
                <img src="{{ asset('front/img/Blog 1.jpg') }}" alt="">
                <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
                <div class="date">
                  <span>@lang('Firas illa')</span>
                  <span>@lang('16-05-2022')</span>
                </div>
              </div>
            </a>
            <!-- item -->
            <a href="">
              <div class="blog-item">
                <img src="{{ asset('front/img/Blog 1.jpg') }}" alt="">
                <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
                <div class="date">
                  <span>@lang('Firas illa')</span>
                  <span>@lang('16-05-2022')</span>
                </div>
              </div>
            </a>
            <!-- item -->
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection