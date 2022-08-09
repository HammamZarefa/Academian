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
       
        <section class="About-us reviewss">
 <div class="container">
         <div class="row contain contain2">
         <div class="col-sm-4 pic">
                <img src="{{ asset('front/img/Reviews Page Image.jpg') }}" alt="">
            </div>
            <div class="col-sm-8 info">
                <h3>@lang('Why You Should Consider Our Services?')</h3>
                <p class="p2">
                @lang('We are a service that helps clients with their studies and to stand out in the job market, we try our best to get our student clients to score straight A’s in their homework and our clients that are trying to get in the job market to smash their competitors.
                We are all about the comfort of our clients, we make sure that you are satisfied and happy with what we offer by the help of our professional team and our affordable prices .
                So if you have a trouble writing your essay or you are having a bad time trying to apply for ajob and you need a unique CV to help you get that job, our service is all you need.')
                </p>
                <button class="main-button" style="width: auto;color:#fff;font-weight: bold;" id="add-review">
                        @lang('Add Your Review') 
                </button>
                <div class="form-cover"></div>
                <form action="" class="form-review">
                  <h2>@lang('Add Your Review!')</h2>
                  <p>@lang('Please let us know what you think about us.')</p>
                  <input type="text" placeholder="Profession Or Specialty" required>
                  <textarea cols="30" rows="10" placeholder="Enter your text here" required></textarea>
                  <button>@lang('Submit')</button>
                </form>
            </div>
            <div class="col-sm-12 review">
              <div class="filter">
                <span>@lang('Filter By:')</span>
                <div class="seclector">
                    <div style="font-weight: bold;">@lang('Newest First')</div>
                    <i class="fas fa-angle-down"></i>
                    <ul class="option">
                      <li>@lang('item')</li>
                      <li>@lang('item')</li>
                      <li>@lang('item')</li>
                      <li>@lang('item')</li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-12 review">
            <div class="rev">
                <div class="info">
                  <i class="fas fa-user-circle fa-3x"></i>
                  <div>
                      <h2>@lang('ADAM MASHARI')</h2>
                      <p>@lang('16-05-2022') </p>
                  </div>
                </div>
                <div class="deisc">
                  <h2> @lang('Architectural Design')</h2>
                  <p> @lang('I got the work on time with 6% plagiarism, wonderful work ')</p>
                </div>
              </div>
              <!-- item -->
              <div class="rev">
                <div class="info">
                  <i class="fas fa-user-circle fa-3x"></i>
                  <div>
                      <h2>@lang('ADAM MASHARI')</h2>
                      <p>@lang('16-05-2022') </p>
                  </div>
                </div>
                <div class="deisc">
                  <h2> @lang('Architectural Design')</h2>
                  <p> @lang('I got the work on time with 6% plagiarism, wonderful work ')</p>
                </div>
              </div>
              <!-- item -->
              <div class="rev">
                <div class="info">
                  <i class="fas fa-user-circle fa-3x"></i>
                  <div>
                      <h2>@lang('ADAM MASHARI')</h2>
                      <p>@lang('16-05-2022') </p>
                  </div>
                </div>
                <div class="deisc">
                  <h2> @lang('Architectural Design')</h2>
                  <p> @lang('I got the work on time with 6% plagiarism, wonderful work ')</p>
                </div>
              </div>
           
         </div>
 </div>
</section>
         
      </div>
    </section>
  </main>
@endsection