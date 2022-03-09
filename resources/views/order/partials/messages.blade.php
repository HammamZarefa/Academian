<div class="comment-box">
   @if($order->order_status_id != ORDER_STATUS_COMPLETE)
   <div class="row p-3">
      <div class="offset-md-3 col-md-6">
         <form action="{{ route('post_comment') }}" method="POST" autocomplete="off">
            {{ csrf_field()  }}
            <label>Your Message</label>
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <textarea class="form-control {{ showErrorClass($errors, 'message') }}" name="message"></textarea>
            <div class="invalid-feedback d-block">{{ showError($errors, 'message') }}</div>
            <br>
            <input class="btn btn-success" type="submit" name="submit" value="Submit">
         </form>
      </div>
   </div>   
   @endif   
   @include('order.partials.comment_thread')
</div>