<!-- Testimonials -->
<section class="testimonials generic" id="menu-testimonials">
    <div class="container">
        <div class="row title">
            <div class="col-sm-12">
                <h2>@lang('Reviews')</h2>
                <p>@lang('All clients reviews are very important and really help to improve the quality of work').</p>
            </div>
        </div>
        @foreach($reviews->slice(0, 3) as $review)
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
