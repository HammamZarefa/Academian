<!-- Slider -->
<section class="slider" id="menu-slider">
    <div class="contain">
        <a href="{{ route('instant_quote')}}" style="width: 49%;">
            <div class="patterns">
                <svg width="100%" height="100%">
                    <text x="50%" y="60%" text-anchor="middle">
                        @lang('writing Service')
                        <div class="box">
                            <div class="title">
                                <span class="block"></span>
                                <h1>@lang('Profesional')<span></span></h1>
                            </div>
                            <div class="role">
                                <div class="block"></div>
                                <p>@lang('500 Clients')</p>
                            </div>
                        </div>
                    </text>
                </svg>
            </div>
        </a>
        <div class="right">
            <a href="{{ route('instant_quote')}}">
                <div class="translation">
                    <h2>@lang('Translation Service')</h2>
                    <span>@lang('between 4 languges')</span>
                </div>
            </a>
            <div class="botto">
                <div><a href="{{ route('instant_quote')}}"><h4>@lang('CV Writing')</h4></a></div>
                <div><a href="{{ route('instant_quote')}}"><h4>@lang('University Approval')</h4></a></div>
            </div>
        </div>
    </div>
</section>
<!-- end Slider -->
