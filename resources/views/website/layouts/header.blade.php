<header>
    <div id="loader">
        <!-- Topbar -->
    </div>
    <section class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 social-media">
                    <a href="{{  settings('company_name') }}" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Facebook"><i class="icon-facebook"></i></a>
                    <a href="{{  settings('company_name') }}" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Twitter"><i class="icon-twitter"></i></a>
                    <a href="{{  settings('company_name') }}" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Linkedin"><i class="icon-linkedin"></i></a>
                    <a href="{{  settings('company_name') }}" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Youtube"><i class="icon-play"></i></a>
                    <a href="{{ settings('company_name') }}" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Pinterest"><i class="icon-pinterest"></i></a>
                    <a href="{{  settings('company_name') }}" data-toggle="tooltip" class="tooltips" data-placement="bottom" title="Google Plus"><i class="icon-gplus"></i></a>
                </div>
                <div class="col-sm-6 data-info">
                    <p><i class="icon-mail"></i> {{ settings('company_email')}}</p>
                    <p><i class="icon-mail"></i> support@academian.com</p>
                </div>
                <div class="col-sm-2 sm-lang">
                @include('website.partials/language_switcher')
                </div>
                <style>
                /* Small devices (landscape phones, 576px and up) */
                @media (max-width: 767.98px) {
                    .sm-lang{
                        position: absolute;
                        right: 10px;
                        top: 10px;
                    }
                }
                </style>
            </div>
        </div>
       
    </section>
    <!-- end Topbar -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">@lang('Toggle navigation')</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('homepage') }}"><img src="{{ get_company_logo() }}" height="50px"
                                                                            width="50px"
                                                                            alt="{{ settings('company_name') }}"></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    {{--<li><a class="{{ is_active_menu('homepage') }}" href="{{ route('homepage') }}">Home</a></li>--}}
                    {{--<li><a class="{{ is_active_menu('pricing') }}" href="{{ route('pricing') }}">Pricing</a></li>--}}
                    {{--<li><a class="{{ is_active_menu('how_it_works') }}" href="{{ route('how_it_works') }}">How it--}}
                            {{--works</a></li>--}}
                    {{--<li><a class="{{ is_active_menu('faq') }}" href="{{ route('faq') }}">FAQ</a></li>--}}
                    {{--<li><a class="{{ is_active_menu('contact') }}" href="{{ route('contact') }}">Contact</a></li>--}}
                    {{--@if(!settings('disable_writer_application') && settings('show_writer_application_link_website_top_menu'))--}}
                        {{--<li>--}}
                            {{--<a href="{{ route('writer_application_page') }}">{{ settings('writer_application_page_link_title') }}</a>--}}
                        {{--</li>--}}
                    {{--@endif--}}
                    {{--<li><a class="{{ is_active_menu('order_page') }}" href="{{ route('order_page') }}">Order Now</a>--}}
                    {{--</li>--}}
                    <li class="active"><a href="#menu-slider">@lang('Home')</a></li>

                    <li class="dropdown">
                        <a class="dropbtn">Services</a>
                        <div class="dropdown-content">
                            @foreach($service_categories as $service_category)
                            <a href="{{ route('instant_quote')}}">
                                {{$service_category->name}}
                                <div class="men-fs">
                                    @foreach($service_category->services as $service)
                                    <div>{{$service->name}}</div>
                                   @endforeach
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </li>
                    {{--<li class="sec-center">--}}
                        {{--<input class="dropdown" type="checkbox" id="dropdown" name="dropdown"/>--}}
                        {{--<label class="for-dropdown" for="dropdown">Services<i class="icon-down"></i></label>--}}
                        {{--<div class="section-dropdown">--}}
                            {{--@foreach($service_categories as $service_category)--}}
                            {{--<input class="dropdown-sub" type="checkbox" id="swe" name="swe"/>--}}
                            {{--<label class="for-dropdown-sub" for="swe">{{$service_category->name}}<i class="icon-plus"></i></label>--}}
                            {{--<div class="section-dropdown-sub" >--}}
                                {{--@foreach($service_category->services as $service)--}}
                                {{--<a  class="gotowizrd">{{$service->name}}</a>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                            {{--@endforeach--}}
                            {{--<input class="dropdown-sub1" type="checkbox" id="dropdown-sub2" name="dropdown-sub2"/>--}}
                            {{--<label class="for-dropdown-sub" for="dropdown-sub2">University Approval<i class="icon-plus"></i></label>--}}
                            {{--<div class="section-dropdown-sub1">--}}
                                {{--<a  class="gotowizrd">Dropdown Link</a>--}}
                                {{--<a class="gotowizrd">Dropdown Link </a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    <li><a href="#menu-contact">@lang('Contact US')</a></li>
                    <li><a href="#menu-testimonials">@lang('Reviews')</a></li>
                    <li><a href="#blog">@lang('Blog')</a></li>
                    <li>
                                @auth
                                    <a href="{{ route(get_default_route_by_user(auth()->user())) }}" class="login">
                                        <i class="flaticon-user"></i>
                                        <span>@lang('My Account')</span>
                                    </a>
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}" class="login">
                                        <i class="flaticon-user"></i>
                                        <span>@lang('log in')</span>
                                    </a>
                                @endguest
                                {{--<div class="live_chat_btn">--}}
                                {{--<a class="boxed_btn_orange" href="#">--}}
                                {{--<i class="fa fa-phone"></i>--}}
                                {{--<span>{!! Purifier::clean(settings('company_phone')) !!}</span>--}}
                                {{--</a>--}}
                                {{--</div>--}}

                        </li>
                </ul>
                <div class="help">
                    <button class=""><a href="{{ route('instant_quote')}}">@lang('Reqeust Help')</a></button>
                </div>
            <!--/.nav-collapse -->
            </div>
            {{--<div class="col-12">--}}
            {{--<div class="mobile_menu d-block d-lg-none"></div>--}}
            {{--</div>--}}
        </div>
    </div>
</header>
{{--<header>--}}
{{--<div class="navbar navbar-default" role="navigation">--}}
{{--<div class="container">--}}
{{--<div class="navbar-header">--}}
{{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">--}}
{{--<span class="sr-only">Toggle navigation</span>--}}
{{--<span class="icon-bar"></span>--}}
{{--<span class="icon-bar"></span>--}}
{{--<span class="icon-bar"></span>--}}
{{--</button>--}}
{{--<a class="navbar-brand" href="#"><img src="{{ asset('storage/'.$general->logo) }}" height="50px" width="50px" alt="{{$general->title}}"></a>--}}
{{--</div>--}}
{{--<div class="navbar-collapse collapse">--}}
{{--<ul class="nav navbar-nav navbar-right">--}}
{{--<li class="active"><a href="#menu-slider">Home</a></li>--}}
{{--<li class="drop"><a href="#menu-features">Services</a>--}}
{{--<div class="menu" data-animation="tada">--}}
{{--<a class="gotowizrd">ACADIMIC WRITING</a>--}}
{{--<a href="#menu-slider">University Approval</a>--}}
{{--</div>--}}
{{--</li>--}}
{{--<li><a href="#menu-teachers">Contact US</a></li>--}}
{{--<li><a href="#menu-testimonials">Reviews</a></li>--}}
{{--<li><a href="#blog">Blog</a></li>--}}
{{--<li><a href="#information">Bussniss Information</a></li>--}}
{{--<!--<li><a href="#menu-pricing">Pricing</a></li>-->--}}
{{--<!--<li><a href="http://themeforest.net/user/CoralixThemes/portfolio" class="external">External</a></li>-->--}}
{{--</ul>--}}
{{--<div class="help">--}}
{{--<button class="gotowizrd">Reqeust Help</button>--}}
{{--</div>--}}
{{--</div><!--/.nav-collapse -->--}}

{{--</div>--}}
{{--</div>--}}
{{--</header>--}}
