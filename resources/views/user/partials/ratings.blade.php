 <?php
$ratings = $user->ratings_received()->with(['user'])->orderBy('id', 'DESC')->paginate();
 ?>
 <h6 class="mb-4">Feedback from clients</h6>         
 <ul class="list-unstyled">
    @foreach($ratings as $rating) 
    <li class="media mb-5">
       <a class="mr-3" href="{{ route('user_profile', $rating->user->id) }}" data-toggle="tooltip" data-placement="top" title="{{ $rating->user->full_name }}">
       <img src="{{ user_photo($rating->user->photo) }}" class="card-profile-image avatar rounded-circle shadow hover-shadow-lg user-avatar" alt="...">
       </a>
       <div class="media-body">
          <h5 class="mt-0 mb-1">{{ star_rating($rating->number)}}</h5>
          <p>{{ $rating->comment }}</p>
          <a href="{{ route('orders_show', $rating->order_id) }}"><small class="form-text text-muted">View order</small></a>
       </div>
    </li>
    @endforeach
 </ul>

 {{ $ratings->appends(['group' => 'ratings'])->links() }}