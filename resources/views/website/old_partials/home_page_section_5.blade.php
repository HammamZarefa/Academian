<!-- Slider -->
<section class="slider" id="menu-slider">
    <div class="contain">
        @if(auth()->check())
            <a href="/orders/create?Service_Category=1">
        @else
            <a href="/instant-quote?Service_Category=1">
        @endif
            <div class="patterns big">
                <svg width="100%" height="60%">
                    <text x="50%" y="60%" text-anchor="middle">
                        @lang('Academic Writing')
                    </text>
                    <h4>@lang('Professional Services For struggling Students')</h4>
                </svg>
            </div>
        </a>
        <div class="right">
            @if(auth()->check())
                <a href="/orders/create?Service_Category=2">
                    @else
                        <a href="/instant-quote?Service_Category=2">
                            @endif
                <div class="patterns">
                <svg width="100%" height="100%">
                    <text x="50%" y="60%" text-anchor="middle" >
                    @lang('University Approval')
                    </text>
                    <h4 >@lang('Unconditional Offers From United Kingdom Universities')</h4>
                </svg>
                    
                </div>
            </a>
            <div class="botto">
                <div class="bot">@if(auth()->check())
                        <a href="/orders/create?Service_Category=6">
                            @else
                                <a href="/instant-quote?Service_Category=6">
                                    @endif
                    <svg width="100%" height="60%">
                        <text x="50%" y="60%" text-anchor="middle" class="un_text Writing">
                        @lang('CV Writing')
                        </text>
                        <h4 >@lang('Professional Service in English and Arabic')</h4>
                    </svg>
                    
                </a>
                </div>
                <div class="bot">@if(auth()->check())
                        <a href="/orders/create?Service_Category=3">
                            @else
                                <a href="/instant-quote?Service_Category=3">
                                    @endif
                    <svg width="104%" height="60%">
                        <text x="50%" y="60%" text-anchor="middle" class="un_text translate">
                        @lang('Translation Service')
                        </text>
                        <h4 >@lang('English and Arabic Documents')</h4>
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
