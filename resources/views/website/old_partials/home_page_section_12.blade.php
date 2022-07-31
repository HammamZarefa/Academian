<!-- Slider -->
<section class="slider" id="menu-contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h3>@lang('Academic writing services')</h3>
                <h2>@lang('For')</h2>
                <h4>@lang('all struggling students'), <br/>@lang('and all level of study') .</h4>
                <hr />
                <h4>@lang('Suscribe to the form and get all the')<br/> @lang('information that you need')</h4>
            </div>
            <div class="col-sm-6">
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
                    <div class="text-center">
                        <button type="submit" class="btn btn-default text-center"><i class="icon-info"></i>@lang('Request Information') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end Slider -->
