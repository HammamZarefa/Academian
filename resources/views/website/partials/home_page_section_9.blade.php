<!-- Testimonials -->
<section class="testimonials generic" id="menu-testimonials">
    <div class="container">
        <div class="row title">
            <div class="col-sm-12">
                <h2>@lang('Reviews')</h2>
                <p>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, distinctioptatem eligendi dolore numquam dolor quis ex velit esse').</p>
            </div>
        </div>
        @foreach($reviews as $review)
        <div class="row">
            <div class="col-sm-2">
                <div class="date">
                    <h5>{{$review->created_at->format('Y-m-d')}}</h5>
                </div>
            </div>
            <div class="col-sm-10 container_item">
                <div class="item-testimonial">
                    <h3>{{$review->profession}}</h3>
                    <h4>{{$review->name}}</h4>
                    <p>{{$review->desc}}</p>
                </div>
            </div>
        </div>
            @endforeach
    </div>
</section>
<!-- end Testimonials -->
