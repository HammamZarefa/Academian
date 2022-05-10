<!-- Pricing Table -->
<section class="table generic" id="menu-pricing">
    <div class="container">
        <div class="row title">
            <div class="col-sm-12">
                <h2>@lang('Select your price')</h2>
                <p>@lang('Explore some services through real calculation method beforemoving to payment step')
                    .</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Proofreading')</li>
                    <li class="table-price">£100,<sup>00</sup></li>
                    <li>2000 @lang('words')</li>
                    <li>@lang('Degree')</li>
                    <li>@lang('9 Days')</li>
                    <li>@lang('English') </li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="btn btn-default"
                               href="/orders/create?service=33&&Service_Category=1&&words=2000&urgency=7&&work_level=2">
                                @else
                                    <a class="btn btn-default"
                                       href="/instant-quote?service=33&&Service_Category=1&&words=2000&urgency=7&&work_level=2">
                                        @endif

                                        <i class="icon-basket"></i>@lang('Order Now')</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Assignment')</li>
                    <li class="table-price">£200,<sup>00</sup></li>
                    <li>2000 @lang('Words')</li>
                    <li>@lang('Degree')</li>
                    <li>@lang('9 Days') </li>
                    <li>@lang('English') , @lang('or Arabic') </li>

                    <li class="table-button">
                        @if(auth()->check())
                          <a class="btn btn-default" href="/orders/create?service=7&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @else
                          <a class="btn btn-default" href="/instant-quote?service=7&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @endif
                                        <i class="icon-basket">

                                        </i>@lang('Order Now')</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Presentation')</li>
                    <li class="table-price">£48,<sup>00</sup></li>
                    <li>15 @lang('Pages')</li>
                    <li>@lang('Double spaced')</li>
                    <li>@lang('Master') </li>
                    <li>@lang('English')</li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="btn btn-default" href="/orders/create?service=30&&Service_Category=1&&urgency=9&&pages=15&&spacing_type=double&&work_level=4">
                        @else
                            <a class="btn btn-default" href="/instant-quote?service=30&&Service_Category=1&&urgency=9&&pages=15&&spacing_type=double&&work_level=4">
                        @endif
                            <i class="icon-basket"></i>@lang('Order Now')</a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <ul class="table-list">
                    <li class="table-header">@lang('Editing')</li>
                    <li class="table-price">£160,<sup>00</sup></li>
                    <li>2000 @lang('Words')</li>
                    <li>@lang('Degree')</li>
                    <li>9 @lang('Days')</li>
                    <li> @lang('Arabic') </li>
                    <li class="table-button">
                        @if(auth()->check())
                            <a class="btn btn-default" href="/orders/create?service=20&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @else
                            <a class="btn btn-default" href="/instant-quote?service=20&&Service_Category=1&&words=2000&&urgency=7&&work_level=2">
                        @endif
                            <i class="icon-basket"></i>@lang('Order Now')</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end Pricing Table -->



