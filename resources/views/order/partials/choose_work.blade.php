<div class="accept_work">
   <h4 class="text-center">Budget</h4>
   <hr>
   <p class="h4 text-center">{{ format_money($order->staff_payment_amount) }}</p>
   <br>
   <form action="{{ route('accept_work', $order->id) }}" method="POST" autocomplete="off">
      {{ csrf_field()  }}   
      <button type="submit" class="btn btn-success btn-lg btn-block">
      <i class="fas fa-check-circle"></i> Accept this work
      </button>
   </form>
</div>