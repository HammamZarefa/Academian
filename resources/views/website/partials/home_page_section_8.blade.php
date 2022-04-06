<!-- Pricing Table -->
<section class="table generic" id="menu-pricing">
    <div class="container">
        <div class="row title">
            <div class="col-sm-12">
                <h2>@lang('Select your price')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    .</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Essay')</li>
                    <li class="table-price">$555.00,<sup>00</sup></li>
                    <li>500 @lang('words')</li>
                    <li>@lang('Degree')</li>
                    <li>@lang('7 Days')</li>
                    <li>@lang('English') </li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="btn btn-default"
                               href="/orders/create?service=21&&Service_Category=1&&words=500&urgency=7&&work_level=6">
                                @else
                                    <a class="btn btn-default"
                                       href="/instant-quote?service=21&&Service_Category=1&&words=500&urgency=7&&work_level=6">
                                        @endif

                                        <i class="icon-basket"></i>@lang('Order Now')</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Assignment')</li>
                    <li class="table-price">$48,<sup>00</sup></li>
                    <li>400 @lang('Words')</li>
                    <li>@lang('Masters')</li>
                    <li>@lang('7 Days') </li>
                    <li>@lang('English') ,@lang('French'), @lang('or Arabic') </li>

                    <li class="table-button">
                        @if(auth()->check())
                          <a class="btn btn-default" href="/orders/create?service=7&&Service_Category=1&&words=400&&urgency=7&&work_level=5">
                        @else
                          <a class="btn btn-default" href="/instant-quote?service=7&&Service_Category=1&&words=400&&urgency=7&&work_level=5">
                        @endif
                                        <i class="icon-basket">

                                        </i>@lang('Order Now')</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Presentation')</li>
                    <li class="table-price">$22,<sup>20</sup></li>
                    <li>10 @lang('Pages')</li>
                    <li>@lang('Double spaced')</li>
                    <li>@lang('Master') </li>
                    <li>@lang('English')</li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="btn btn-default" href="/orders/create?service=30&&Service_Category=1&&pages=10&&spacing_type=double&&work_level=5">
                        @else
                            <a class="btn btn-default" href="/instant-quote?service=30&&Service_Category=1&&pages=10&&spacing_type=double&&work_level=5">
                        @endif
                            <i class="icon-basket"></i>@lang('Order Now')</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Resume Writing')</li>
                    <li class="table-price">$12,<sup>18</sup></li>
                    <li>@lang('Resume Writing')</li>
                    <li>@lang('English')</li>
                    <li>@lang('Ph.D')</li>
                    <li>7 @lang('Days') </li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="btn btn-default" href="/orders/create?service=47&&Service_Category=6&&urgency=7&&work_level=4">
                        @else
                            <a class="btn btn-default" href="/instant-quote?service=47&&Service_Category=6&&urgency=7&&work_level=4">
                        @endif
                            <i class="icon-basket"></i>@lang('Order Now')</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end Pricing Table -->



