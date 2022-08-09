@extends('website.layouts.template')
@section('title')
Blog - 
@endsection

@section('content')
<main>

    <!-- ======= Breadcrumbs ======= -->
    <section class="gallery">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 ">
            <h2 class="title">
            <a>@lang('Home')</a>
            <span class="rig">></span>
            <a>@lang('Gallery')</a>
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 ">
           <div class="filter-gall">
             <h2>@lang('Filter By:')</h2>
             <div class="shapes" id="shapes">
              <span class="active">@lang('All') <i class="fas fa-times"></i></span>
              <span>@lang('Videos') <i class="fas fa-times"></i></span>
              <span>@lang('Images') <i class="fas fa-times"></i></span>
             </div>
           </div>
          </div>
        </div>
        <div class="contain">
       
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
          <a class="item">
            <iframe class="vid"  height="200" src="https://www.youtube.com/embed/BVxYAIQLewA" frameborder="0" allowfullscreen></iframe>
            <h2>@lang('Project and Production Management in the Built Environment - Sydney Opera House')</h2>
            <div class="date">@lang('16-05-2022')</div>
          </a>
        </div>
      </div>
    </section>
  </main>
@endsection