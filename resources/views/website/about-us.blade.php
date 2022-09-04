@extends('website.layouts.template')
@section('title')
Blog - 
@endsection

@section('content')
<main>

    <!-- ======= Breadcrumbs ======= -->
    <section class="gallery watch-video">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 ">
            <h2 class="title">
            <a>@lang('Home')</a>
            <span class="rig">></span>
            <a>@lang('About Us')</a>
            </h2>
          </div>
        </div>
        </div>
       
  <div class="About-us">
 <div class="container">
     <div class="row contain contain2">
            
            <div class="col-sm-8 info">
                <h3>@lang('The Best Service to Help Students with their Homework')</h3>
                <p class="p2">
                @lang('Academian.co.uk is the best essay writing service that provides high-quality essays, research papers and term papers to students all around the United Kingdom. Our professional writers offer a wide range of writing services, whether it was an essay, a research paper, a dissertation, or even a PhD thesis we got it. Recruit the most talented writers, who will work hard to meet your deadlines. Place your order and enjoy our essay help by our qualified writers.')
                </p>
                <button class="main-button">
                    <a href="{{route('instant_quote')}}">
                        @lang('Get Quote') <i class="fas fa-arrow-right"></i>
                    </a>
                </button>
            </div>
            <div class="col-sm-4 pic">
                <img src="{{ asset('front/img/Home Page 2nd Image.jpg') }}" alt="">
            </div>
         </div>
         <div class="row contain contain2">
         <div class="col-sm-4 pic">
                <img src="{{ asset('front/img/About Us Page Image 2.jpg') }}" alt="">
            </div>
            <div class="col-sm-8 info">
                <h3>@lang('Why You Should Consider Our Services?')</h3>
                <p class="p2">
                @lang('We are a service that helps clients with their studies and to stand out in the job market, we try our best to get our student clients to score straight A’s in their homework and our clients that are trying to get in the job market to smash their competitors.
                We are all about the comfort of our clients, we make sure that you are satisfied and happy with what we offer by the help of our professional team and our affordable prices .
                So if you have a trouble writing your essay or you are having a bad time trying to apply for ajob and you need a unique CV to help you get that job, our service is all you need.')
                </p>
                <button class="main-button">
                    <a href="{{route('instant_quote')}}">
                        @lang('Get Quote') <i class="fas fa-arrow-right"></i>
                    </a>
                </button>
            </div>
           
         </div>
 </div>
</div>
    
<!-- Start Blog -->
<div class="post po">
    <div class="container">
      <div class="row">
        <div class="col-sm-5 con-sw">
        <div class="swiper2">
          <div class="swiper-wrapper">
            <!-- ****** item ****** -->
             @foreach($reviews->slice(0, 3) as $review)
            <div class="swiper-slide"> 
              <div class="info">
                <i class="fas fa-user-circle fa-2x"></i>
                <div>
                  <h2>{{$review->name}}</h2>
                 <p> {{$review->created_at->format('Y-m-d')}}</p>
                </div>
              </div>
              <div class="info2">
               <h2>{{$review->profession}}</h2>
               <p> {{$review->desc}}</p>
              </div>
            </div>
             @endforeach
          </div>
          <!-- Add Scrollbar -->
          <div class="swiper-pagination"></div>
        </div>
        </div>
        <div class="col-sm-6 con-sf">
          <h2> {!! homepage('review_section_title') !!}</h2>
          <p>{!! homepage('review_section_content') !!}.</p>
          <button class="main-button">
              <a href="{{route('instant_quote')}}" class="btn">
              @lang('Get Quote')
                <i class="fas fa-arrow-right"></i>
              </a>
          </button> 
        </div>
      </div>

    </div>
</div>

</section>
  </main>
@endsection