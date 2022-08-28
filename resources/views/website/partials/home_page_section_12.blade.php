<!-- Slider -->
<section class="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title">@lang('Get in touch with us today to learn more.')</h2>
            </div>
            <div class="col-sm-6 con1"  data-aos="fade-right" data-aos-duration="1500">
                <img src="{{ asset('front/img/Home Page Last Image.jpg') }}" alt="">
            </div>
            <div class="col-sm-6 con2">
                <form id="request" class="row suscribe" action="{{route('sendmail')}}" method="post" accept-charset="utf-8">
                    {{ csrf_field()  }}
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="@lang('Name')" name="name"
                        data-aos="fade-left" data-aos-duration="1500">
                        <input type="email" class="form-control" placeholder="@lang('Email')" name="email"
                        data-aos="fade-left" data-aos-duration="1600">
                    </div>
                    <div class="col-sm-12" style="z-index: 2;">
                        <input type="text" class="form-control" placeholder="@lang('Message')" name="message"
                        data-aos="fade-left" data-aos-duration="1700">
                        <div class="seclector select-degree" style="margin: 0 0 0 auto;margin-bottom: 0px;width: 401px;margin-bottom: 25px;"   data-aos="fade-left" data-aos-duration="1800">
                            <div class="selected-degree" style="font-weight: bold;">Select degree program</div>
                            <i class="fas fa-angle-down"></i>
                                <ul class="option">
                                <li>Select degree program</li>
                                    @foreach($work_levels as $level)
                                <li>{{$level->name}}</li>
                                        @endforeach
                                </ul>
                                <input type="hidden" value="">
                        </div>
                    </div>
                    <div class="col-sm-12 text-center"  data-aos="fade-up" data-aos-duration="1900">
                        <button type="submit" class="btn btn-default text-center">@lang('Submit') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end Slider -->
