@extends('website.layouts.template')
@section('title')
    Blog -
@endsection

@section('content')
    <main>
        <!-- ======= Breadcrumbs ======= -->
        <section class="blogs-list" style="padding: 20px 0">
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
                                <form action="{{ route("search") }}" method="GET"
                                      style="display: flex;align-items: center;justify-content: space-around;">
                                    <input type="text" name="query" placeholder="Search">
                                    <button type="submit"><i class="icon-search" style="font-size: 20px;"></i></button>
                                </form>
                            </div><!-- End sidebar search formn-->
                            <h3 class="sidebar-title"> @lang('Categories') </h3>
                            <div class="sidebar-item categories">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a href="{{ route('category',$category->slug) }}">{{ $category->name }}
                                                <span>({{ $category->count() }})</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <h3 class="sidebar-title">@lang('Tags') </h3>
                            <div class="sidebar-item tags">
                                <ul>
                                    @foreach ($tags as $tag)
                                        <li style="margin-bottom: 5px;"><a
                                                    href="{{ route('tag',$tag->slug) }}">{{ $tag->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="recent-blog">

                        </div>
                    </div>
                    <div class="col-sm-8">
                    @foreach($posts as $post)
                        <!-- item -->
                            <a href="{{route('blogshow',$post->slug)}}">
                                <div class="blog-item">
                                    @if($post->body_type == 0)
                                        <img src="{{ asset('storage/'.$post->cover) }}" alt="">
                                    @else
                                        {{--//Preview Pdf Here ----------------------------------------------}}
                                        <object data="{{asset('images/blog/'.$post->body)}}" type="application/pdf"
                                                width="750 px" height="700 px%">
                                            <p>Alternative text - include a link <a
                                                        href="{{asset('images/blog/'.$post->body)}}">to the PDF!</a></p>
                                        </object>
                                        {{--// End of preview pdf--}}
                                    @endif
                                    <h2>{{$post->title}}</h2>
                                    <div class="date">
                                        <span>{{$post->user->name}}</span>
                                        <span>{{ Carbon\Carbon::parse($post->created_at)->format("d F, Y") }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection