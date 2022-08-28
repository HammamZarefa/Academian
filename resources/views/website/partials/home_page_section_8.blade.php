<!-- Pricing Table -->
<section class="our-price">
    <div class="container">
        <div class="row title">
            <div class="col-sm-12">
                <h2>@lang('Our price')</h2>
                
            </div>
        </div>
        <div class="contain-prices">

            {{--<div class="item" data-aos="fade-up" data-aos-duration="1500" >--}}
                {{--<ul class="table-list">--}}
                    {{--<li class="table-header">{{$services[pricing_table('pricing_table1')->service]->name}}</li>--}}
                    {{--<li class="table-price">{!! pricing_table('pricing_table1')->price !!},<sup>00</sup></li>--}}
                    {{--<li class="table-button">--}}
                        {{--@if(auth()->check())--}}
                            {{--<a class=""--}}
                               {{--href="/orders/create?service=33&&Service_Category=1&&words=2000&urgency=7&&work_level=2">--}}
                                {{--@else--}}
                                    {{--<a class=""--}}
                                       {{--href="/instant-quote?service=33&&Service_Category=1&&words=2000&urgency=7&&work_level=2">--}}
                                        {{--@endif--}}

                                        {{--@lang('Order Now')--}}
                                    {{--</a>--}}
                            {{--</a>--}}
                    {{--</li>--}}
                    {{--<li><hr></li>--}}
                    {{--@foreach( pricing_table('pricing_table1')->keys as $keys =>$value )--}}
                    {{--<li>{{$value}} @lang($keys)</li>--}}
                    {{--<li>@lang('Degree')</li>--}}
                    {{--<li>@lang('9 Days')</li>--}}
                    {{--<li>@lang('English') </li>--}}
                        {{--@endforeach--}}

                {{--</ul>--}}
            {{--</div>--}}


            <div class="item" data-aos="fade-up" data-aos-duration="1500" >
                <ul class="table-list">
                    <li class="table-header">@lang('Proofreading')</li>
                    <li class="table-price">£100,<sup>00</sup></li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class=""
                               href="/orders/create?service=33&&Service_Category=1&&words=2000&urgency=7&&work_level=2">
                                @else
                                    <a class=""
                                       href="/instant-quote?service=33&&Service_Category=1&&words=2000&urgency=7&&work_level=2">
                                        @endif

                                   @lang('Order Now')
                                </a>
                    </li>
                    <li><hr></li>
                    <li>2000 @lang('words')</li>
                    <li>@lang('Degree')</li>
                    <li>@lang('9 Days')</li>
                    <li>@lang('English') </li>
                    
                </ul>
            </div>
            <div class="item" data-aos="fade-up" data-aos-duration="1500">
                <ul class="table-list">
                    <li class="table-header">@lang('Assignment')</li>
                    <li class="table-price">£200,<sup>00</sup></li>
                    <li class="table-button">
                        @if(auth()->check())
                          <a class="" href="/orders/create?service=7&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @else
                          <a class="" href="/instant-quote?service=7&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @endif
                                        

                                        </i>@lang('Order Now')</a></li>
                    <li><hr></li>

                    <li>2000 @lang('Words')</li>
                    <li>@lang('Degree')</li>
                    <li>@lang('9 Days') </li>
                    <li>@lang('English') , @lang('or Arabic') </li>

                    
                </ul>
            </div>
            <div class="item"  data-aos="fade-up" data-aos-duration="1500">
                <ul class="table-list">
                    <li class="table-header">@lang('Presentation')</li>
                    <li class="table-price">£48,<sup>00</sup></li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="" href="/orders/create?service=30&&Service_Category=1&&urgency=9&&pages=15&&spacing_type=double&&work_level=4">
                        @else
                            <a class="" href="/instant-quote?service=30&&Service_Category=1&&urgency=9&&pages=15&&spacing_type=double&&work_level=4">
                        @endif
                            @lang('Order Now')</a></li>
                    <li><hr></li>

                    <li>15 @lang('Pages')</li>
                    <li>@lang('Double spaced')</li>
                    <li>@lang('Master') </li>
                    <li>@lang('English')</li>
                    
                </ul>
            </div>
            <div class="item"  data-aos="fade-up" data-aos-duration="1500">
                <ul class="table-list">
                    <li class="table-header">@lang('Editing')</li>
                    <li class="table-price">£160,<sup>00</sup></li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="" href="/orders/create?service=20&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @else
                            <a class="" href="/instant-quote?service=20&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @endif
                           @lang('Order Now')</a></li>
                    <li><hr></li>

                    <li>2000 @lang('Words')</li>
                    <li>@lang('Degree')</li>
                    <li>9 @lang('Days')</li>
                    <li> @lang('Arabic') </li>
                    
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end Pricing Table -->



