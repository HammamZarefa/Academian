<header>
    <div id="loader">
        <!-- Topbar -->
    </div>
    <!-- end Topbar -->
    <div class="navbar" role="navigation">
        <div class="container ar-con">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle">
                    <span class="sr-only">@lang('Toggle navigation')</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{ route('homepage') }}">
                    <div class="logo">
                        <img src="{{ asset('front/img/Artboard-logo.png') }}"
                             alt="{{ settings('company_name') }}">
                    <!-- <img src="{{ asset('front/img/Artboard-logo.png') }}"
                        alt="{{ settings('company_name') }}"> -->
                    </div>
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="{{route('homepage')}}">@lang('Home')</a></li>
                    <li class="dropdown" style="margin-top: 1px;margin-inline-end: 10px;">
                        <span class="dropbtn">@lang('Services')</span>
                        <div class="dropdown-content">
                            {{--@if(isset($service_categories))--}}
                                @foreach(\App\ServiceCategory::all() as $service_category)
                                    <a href="{{ route('instant_quote')}}" class="category-name">
                                        {{$service_category->name}}
                                        <div class="men-fs">
                                            @foreach($service_category->services as $service)
                                                <div>{{$service->name}}</div>
                                            @endforeach
                                        </div>
                                    </a>
                                @endforeach
                            {{--@endif--}}
                            <a href="{{ route('post.add')}}">
                                <i class="fas fa-plus"></i> @lang('Add Blog')
                            </a>
                        </div>
                    </li>
                    <div class="cover-acount"></div>
                    <li style="margin-top: 1px;">
                        <div class="acoount acoount2">
                            <a style="position: relative;
display: block;
background-color: transparent;">@lang('Online Services')</a>
                            <ul>
                                {{--<li>--}}
                                    {{--<a style="font-size: 14px;" href="{{ route('summarize')}}">--}}
                                        {{--<div>@lang('Summarize')</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a style="font-size: 14px;" href="{{ route('paraphrase')}}">--}}
                                        {{--<div>@lang('Paraphrase')</div>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a style="font-size: 14px;" href="{{ route('plagiarism')}}">--}}
                                        {{--@lang('Plagiarism')--}}
                                    {{--</a>--}}
                                {{--</li>--}}

                                @foreach(\App\OnlineService::all() as $online_service)
                                    <li>
                                    <a style="font-size: 14px;" href="{{ $online_service->route.'/'.$online_service->id}}">
                                        <div>{{ $online_service->name}}</div>
                                </li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                        <div class="cover-acount"></div>
                    </li>
                    <li><a href="{{route('about')}}">@lang('About')</a></li>
                    <li><a href="{{route('gallery')}}">@lang('Gallery')</a></li>
                    <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                    <li><a href="{{route('contact')}}">@lang('Contact')</a></li>
                    <li><a href="{{route('reviews')}}">@lang('Reviews')</a></li>
                    <li>
                        @auth
                            <div class="acoount">
                                <i class="fas fa-user-circle fa-2x" style="color:#87A2B9"></i>
                                <i class="fas fa-caret-down"></i>
                                <ul>
                                    <li>
                                        <a href="{{ route('instant_quote')}}">
                                            @lang('My Account')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            @lang('Add New Order')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}">
                                            @lang('Log Out')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="cover-acount"></div>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="login">
                                <i class="flaticon-user"></i>
                                <span>@lang('log in')</span>
                            </a>
                        @endguest
                    </li>
                </ul>
                <div class="">
                    @include('website.partials/language_switcher')
                </div>
            </div>
        </div>
    </div>
</header>