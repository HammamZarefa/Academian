<!-- Teachers -->
<section class="teachers generic" id="menu-teachers">
    <div class="container">
        <div class="row title">
            <div class="col-sm-12">
                <h2>Meet the Teachers</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi
                    dolore numquam dolor quis ex velit esse.</p>
            </div>
        </div>
        <div class="row">
            @foreach($writers as $writer)
            <div class="item col-sm-3 item">
                <a href="#teacher01" data-toggle="modal">
                    <div class="class_title">
                        <h2> {{$writer->firstName.' '.$writer->lastName}} </h2>
                    </div>
                    <figure>
                        <img src="{{asset(Storage::url($writer->photo))}}" alt="">
                        {{--<figcaption><i class="icon-plus-circled"></i></figcaption>--}}
                    </figure>
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
