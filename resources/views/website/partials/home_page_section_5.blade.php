<!-- Slider -->
<section class="slider" id="menu-slider">
    <div class="contain">
        @if(auth()->check())
            <a href="/orders/create?Service_Category=1">
        @else
            <a href="/instant-quote?Service_Category=1">
        @endif
            <div class="patterns big">
                <svg width="100%">
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
            @if(auth()->check())
                <a href="/orders/create?Service_Category=3">
                    @else
                        <a href="/instant-quote?Service_Category=3">
                            @endif
                <div class="patterns">
                <svg width="100%" height="100%">
                    <text x="50%" y="60%" text-anchor="middle" class="translate" >
                    @lang('University Approval')
                    </text>
                </svg>
                    <div class="box">
                        <div class="title">
                            <span class="block translat" ></span>
                            <h1 >@lang('in four country')<span></span></h1>
                        </div>

                    </div>
                </div>
            </a>
            <div class="botto">
                <div>@if(auth()->check())
                        <a href="/orders/create?Service_Category=6">
                            @else
                                <a href="/instant-quote?Service_Category=6">
                                    @endif
                    <svg width="100%" height="100%">
                        <text x="50%" y="60%" text-anchor="middle" class="un_text Writing">
                        @lang('CV Writing')
                        </text>
                    </svg>
                </a>
                </div>
                <div>@if(auth()->check())
                        <a href="/orders/create?Service_Category=2">
                            @else
                                <a href="/instant-quote?Service_Category=2">
                                    @endif
                    <svg width="104%" height="100%">
                        <text x="50%" y="60%" text-anchor="middle" class="un_text">
                        @lang('Translation Service')
                        </text>
                        {{--<text x="50%" y="70%" text-anchor="middle" class="un_text">--}}
                        {{--@lang('Approval')--}}
                        {{--</text>--}}

                    </svg>
                </a></div>
            </div>
            
        </div>
    </div>
</section>
<!-- end Slider -->
