<!-- Slider -->
<section class="slider" id="menu-contact">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h3>@lang('A better way to')</h3>
                <h2>@lang('Success')</h2>
                <h4>@lang('Lorem ipsum dolor sit amet'), <br/>@lang('ei vis sint persecuti') .</h4>
                <hr />
                <h4>@lang('Suscribe to the form and get all the')<br/> @lang('information that you need')</h4>
            </div>
            <div class="col-sm-6">
                <form id="request" class="row suscribe" action="request-form.php" method="post" accept-charset="utf-8">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="Name" name="name">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                    </div>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" placeholder="Message" name="phone">
                        <select class="form-control" name="program">
                            <option>@lang('Select degree program')</option>
                            <option>@lang('Degree')</option>
                            <option>@lang('Master')</option>
                            <option>@lang('PhD')</option>
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
