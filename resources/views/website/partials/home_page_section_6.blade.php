<!-- Features -->
<section class="features" id="features">
    <h2 class="title-heading">
        {!! homepage('section_3_title') !!}
    </h2>
    <div class="container">
    <div class="row">
        <h3 class="col-sm-12">
            {!! homepage('section_3_title') !!}
        </h3>
        <div class="col-sm-5 con-im">
            <img class="im1" src="{{ asset('front/img/Home_Page_3rd_Image.jpg') }}" alt=""
            data-aos="fade-down"
        data-aos-duration="1500">
            <img class="im2" src="{{ asset('front/img/Home_Page_3rd_Image-2.png') }}" alt=""
            data-aos="fade-down"
        data-aos-duration="1500">
            <p class="p2"
            data-aos="fade-up"
            data-aos-duration="1500">
                {!! homepage('section_3_sub_title') !!} </p>
            <button class="main-button"
            data-aos="fade-up"
            data-aos-duration="1500">
                <a href="{{route('instant_quote')}}" class="btn">
                @lang('Get Quote') <i class="fas fa-arrow-right"></i>
                </a>
            </button>
        </div>
        <div class="col-sm-7">
            <div class="item">
                <img src="{{ asset('front/img/shield-tick Icon (Confedintial).svg') }}" alt=""
                data-aos="fade-right" data-aos-duration="1500">
                <!-- <video src="{{ asset('front/img/vedio-icon.mp4') }}" autoplay="autoplay" loop="true"></video> -->
               <div data-aos="fade-left" data-aos-duration="1500">
                   <h2> {!! homepage('how_it_works_step_1') !!} </h2>
                   <p class="p2">{!! homepage('how_it_works_step_1_content') !!} </p>
               </div>
            </div>
            <div class="item">
                <img src="{{ asset('front/img/flash Icon (Fast Delivery).svg') }}" alt="" data-aos="fade-right" data-aos-duration="1500">
               <div data-aos="fade-left" data-aos-duration="1500">
                   <h2>  {!! homepage('how_it_works_step_2') !!} </h2>
                   <p class="p2">{!! homepage('how_it_works_step_2_content') !!}</p>
               </div>
            </div>
            <div class="item">
                <img src="{{ asset('front/img/document-text Icon (Best Writers).svg') }}" alt="" data-aos="fade-right" data-aos-duration="1500">
               <div data-aos="fade-left" data-aos-duration="1500">
                   <h2> {!! homepage('how_it_works_step_3') !!} </h2>
                   <p class="p2">{!! homepage('how_it_works_step_3_content') !!} </p>
               </div>
            </div>
            <div class="item">
                <img src="{{ asset('front/img/money-4 Icon (Affordable Prices).svg') }}" alt="" data-aos="fade-right" data-aos-duration="1500">
               <div data-aos="fade-left" data-aos-duration="1500">
                   <h2> {!! homepage('how_it_works_step_4') !!} </h2>
                   <p class="p2">{!! homepage('how_it_works_step_4_content') !!} </p>
               </div>
            </div>
        </div>
    </div>
    </div>

</section>

<!-- end Features -->
