 <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-6 col-md-6">
                        <div class="illastrator_png">
                            <img src="img/banner/edu_ilastration.png" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="slider_info">
                            <h3>{!! homepage('hero_title_1') !!}</h3>
                            <a href="{{ route('instant_quote') }}" class="boxed_btn">{!! homepage('hero_button_text') !!}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- about_area_start -->
    <div class="about_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7">
                    <div class="single_about_info">
                        <h3>{!! homepage('section_1_title') !!}</h3>
                        <p>{!! homepage('section_1_content') !!}</p>
                       
                    </div>
                </div>
                <div class="col-xl-5 offset-xl-1 col-lg-5">                    
                    <div class="about_tutorials">
                        <img src="{{ asset('/images/header-img.png') }}" class="img-fluid" alt="{{ homepage('section_1_title') }}">        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_area_end -->