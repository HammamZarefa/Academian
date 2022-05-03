<!-- Features -->
<section class="features generic" id="menu-features">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>@lang('Our Services')</h2>
                <p>@lang('Academian.co.uk provides an outstanding level of academic writing for all study levels and all specialties. Professional writers help straggling students to step up forward')
                    .</p>
            </div>
            <!-- <div id="carousel-example-generic" class="carousel slide col-sm-3" data-ride="carousel">
                  
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                  
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
            </div> -->
          
           <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=7&&Service_Category=1"><i class="icon-monitor"></i></a>
                @else
                    <a href="/instant-quote?service=7&&Service_Category=1"><i class="icon-monitor"></i></a>
                @endif
            <!-- ?service=20&&Service_Category=3 -->
                <h2>@lang('Assignment')</h2>
                <p>@lang('An assignment is a task or piece of work assigned to student as part of the course. The course is assessed through written assignments and practical examinations.')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=21&&Service_Category=1"><i class="icon-users"></i></a>
                @else
                    <a href="/instant-quote?service=21&&Service_Category=1"><i class="icon-users"></i></a>
                @endif

                <h2>@lang('Essay')</h2>
                <p>@lang("An essay is a piece of writing that presents the author's own argument. Essays are frequently used to express literary criticism, political manifestos, learned arguments, observations.")
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=35&&Service_Category=1"><i class="icon-book-open"></i></a>
                @else
                    <a href="/instant-quote?service=35&&Service_Category=1"><i class="icon-book-open"></i></a>
                @endif
                <h2>@lang('Reports')</h2>
                <p>@lang('A report is created with a specific aim in mind and for a certain audience. Specific data and facts are provided, analysed, and applied to a specific issue or situation.')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=23&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=23&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Reflection Reports')</h2>
                <p>@lang("A Reflective Report is a piece of writing in which a student summarises his or her critical reflection on a particular subject. Individual Reflective Reports can be used to document each student's participation to a collaborative effort.")
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=30&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=30&&Service_Category=1"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Presentations')</h2>
                <p>@lang('A presentation is a way for a speaker to convey information to an audience. Presentations are often demos, introductions, lectures, or speeches intended to educate, convince, inspire, motivate, foster goodwill, or introduce a new idea/product.')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=13&&Service_Category=1"><i class="icon-book-open"></i></a>
                @else
                    <a href="/instant-quote?service=13&&Service_Category=1"><i class="icon-book-open"></i></a>
                @endif
                <h2>@lang('Desertations')</h2>
                <p>@lang('A dissertation is a lengthy writing on a certain subject, typically produced for the purpose of earning a university degree or credential. A treatise that advances a new point of view as a consequence of research.')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=20&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=20&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Editing')</h2>
                <p>@lang('Editing is the process of preparing written content for publication by correcting, condensing, or changing it in some way. the process of altering a text, selecting what should be deleted and what should be retained, in order to prepare it for printing.')
                    . </p>
            </article>
            <article class="item col-sm-3">
                @if(auth()->check())
                    <a href="/orders/create?service=41&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @else
                    <a href="/instant-quote?service=41&&Service_Category=2"><i class="icon-graduation-cap"></i></a>
                @endif
                <h2>@lang('Projects')</h2>
                <p>@lang('A project is an individual or team activity that students meticulously plan and research. At schools, educational institutions, and universities, a project is a research assignment assigned to a student that typically needs more effort and work.')
                    . </p>
            </article>
        
        </div>
    </div>

</section>

<!-- end Features -->
