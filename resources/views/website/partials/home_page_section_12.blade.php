<!-- Slider -->
<section class="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title">@lang('Get in touch with us today to learn more.')</h2>
            </div>
            <div class="col-sm-6 con1">
                <img src="{{ asset('front/img/Home Page Last Image.jpg') }}" alt="">
            </div>
            <div class="col-sm-6 con2">
                <form id="request" class="row suscribe" action="{{route('sendmail')}}" method="post" accept-charset="utf-8">
                    {{ csrf_field()  }}
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="@lang('Name')" name="name">
                        <input type="email" class="form-control" placeholder="@lang('Email')" name="email">
                    </div>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="@lang('Message')" name="phone">
                        <select class="form-control" name="program">
                            <option>@lang('Select degree program')</option>
                            <option>@lang('Foundation')</option>
                            <option>@lang('Bachelor')</option>
                            <option>@lang('Master')</option>
                            <option>@lang('PHD')</option>
                        </select>
                    </div>
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-default text-center">@lang('Submit') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end Slider -->
