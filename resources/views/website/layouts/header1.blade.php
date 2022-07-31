<header>
    <div id="loader">
        <!-- Topbar -->
    </div>
    <!-- end Topbar -->
    <div class="navbar" role="navigation">
        <div class="container ar-con">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" >
                    <span class="sr-only">@lang('Toggle navigation')</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{ route('homepage') }}">  
                    <div class="logo">
                         <img src="{{ get_company_logo() }}" 
                        alt="{{ settings('company_name') }}">
                        <!-- <img src="{{ asset('front/img/Artboard-logo.png') }}" 
                        alt="{{ settings('company_name') }}"> -->     
                    </div>  
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="#menu-slider">@lang('Home')</a></li>
                    <li class="dropdown">
                        <span class="dropbtn">@lang('Services')</span>
                        <div class="dropdown-content">
                            @if(isset($service_categories))
                            @foreach($service_categories as $service_category)
                            <a href="{{ route('instant_quote')}}" class="category-name">
                                {{$service_category->name}}
                                <div class="men-fs">
                                    @foreach($service_category->services as $service)
                                    <div>{{$service->name}}</div>
                                   @endforeach
                                </div>
                            </a>
                            @endforeach
                                @endif
                                <a href="{{ route('post.add')}}">
                                <i class="fas fa-plus"></i>  @lang('Add Blog')
                                </a>
                        </div>
                    </li>
                    <div class="cover-acount"></div>
                    <li><a href="#">@lang('About US')</a></li>
                    <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                    <li><a href="#menu-contact">@lang('Contact US')</a></li>
                    <li><a href="#menu-testimonials">@lang('Reviews')</a></li>
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
                                            <a href="{{ route('instant_quote')}}">
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