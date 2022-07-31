<!-- Teachers -->
<section class="our-team" id="our-team">
    <div class="container">
        <div class="row title">
            <div class="col-sm-12">
                <h2>@lang('Meet Our Team')</h2>
            </div>
        </div>
        <div class="contain-team">
            @foreach($writers as $writer)
            <div class="item">
                        <img src="{{asset(Storage::url($writer->photo))}}" alt="">
                        {{--<figcaption><i class="icon-plus-circled"></i></figcaption>--}}
                <a href="#teacher01" data-toggle="modal">
                    <div class="class_title">
                        <h2> {{$writer->first_name.' '.$writer->last_name}} </h2>
                    </div>
                  
                    <div class="description">
                        <p>{{$writer->bio}}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- end Teachers -->
