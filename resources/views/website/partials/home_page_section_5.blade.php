<!-- Slider -->
<section class="About-us ov-hi">
 <div class="container">
     <div class="row contain">
         <div class="col-sm-6 info" 
         data-aos="fade-up"
         data-aos-duration="1500" >
            <h1>{!! homepage('section_1_title') !!}</h1>
            <p>
                {!! homepage('section_1_content') !!}
            </p>
            <button class="main-button">
                <a href="{{route('instant_quote')}}">
                    @lang('Get Quote') <i class="fas fa-arrow-right"></i>
                </a>
            </button>
         </div>
         <div class="col-sm-6 pic"
         data-aos="fade-down"
         data-aos-duration="1500">
             <img src="{{ asset('front/img/Home_Page_1st_Image.jpg') }}" alt="">
         </div>
     </div>
     <div class="row contain contain2">
            <div class="col-sm-4 pic"
            data-aos="fade-down"
         data-aos-duration="1500">
                <img src="{{ asset('front/img/Home_Page_2nd_Image.jpg') }}" alt="">
            </div>
            <div class="col-sm-8 info">
                <h3 data-aos="fade-up" data-aos-duration="1500">{!! homepage('section_2_title') !!}</h3>
                <p class="p2" data-aos="fade-up" data-aos-duration="1700">
                    {!! homepage('section_2_title') !!}
                </p>
                <button class="main-button"  data-aos="fade-up" data-aos-duration="1900">
                    <a href="{{route('instant_quote')}}">
                        @lang('Get Quote') <i class="fas fa-arrow-right"></i>
                    </a>
                </button>
            </div>
         </div>
 </div>
</section>
<!-- end Slider -->
