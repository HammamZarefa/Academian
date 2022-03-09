@if(!is_null($order->rating))
<div class="card">
   <div class="card-body">
      <h5 class="card-title">Rating</h5>
      {{ star_rating($order->rating->number) }}
      <br><br>
      <div class="font-weight-bold">Comment</div>
      <p>{{ $order->rating->comment }}</p>     
   </div>
</div>
@else
   @if($order->customer_id == auth()->user()->id)
<a class="btn btn-info btn-lg btn-block text-white" href="{{ route('orders_rating', $order->id) }}">
<i class="fas fa-star"></i> Rate our service</a>
   @endif
@endif
