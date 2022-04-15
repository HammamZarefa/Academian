<!-- Features -->
<section class="features generic" id="menu-features">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>@lang('Our Services')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    .</p>
            </div>
            <div id="carousel-example-generic" class="carousel slide col-sm-3" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                        <img src="{{ asset('front/img/side-banner.png') }}" alt="">
                        </div>
                        <div class="item">
                        <img src="{{ asset('front/img/side-banner.png') }}" alt="">
                        </div>
                        <div class="item">
                        <img src="{{ asset('front/img/side-banner.png') }}" alt="">
                        </div>
                    </div>
            </div>
           <div class="col-sm-9">
           <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=7&&Service_Category=1"><i class="icon-monitor"></i></a>
                @else
                    <a href="/instant-quote?service=7&&Service_Category=1"><i class="icon-monitor"></i></a>
                @endif
            <!-- ?service=20&&Service_Category=3 -->
                <h2>@lang('Assignment')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=21&&Service_Category=1"><i class="icon-users"></i></a>
                @else
                    <a href="/instant-quote?service=21&&Service_Category=1"><i class="icon-users"></i></a>
                @endif

                <h2>@lang('Essay')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=35&&Service_Category=1"><i class="icon-book-open"></i></a>
                @else
                    <a href="/instant-quote?service=35&&Service_Category=1"><i class="icon-book-open"></i></a>
                @endif
                <h2>@lang('Reports')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=23&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=23&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Reflection Reports')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=30&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=30&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Presentations')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=13&&Service_Category=1"><i class="icon-book-open"></i></a>
                @else
                    <a href="/instant-quote?service=13&&Service_Category=1"><i class="icon-book-open"></i></a>
                @endif
                <h2>@lang('Desertations')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=20&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=20&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Editing')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=41&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=41&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Projects')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse')
                    . </p>
            </article>
           </div>
        </div>
    </div>

</section>

<!-- end Features -->
