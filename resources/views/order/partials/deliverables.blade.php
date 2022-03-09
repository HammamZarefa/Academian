@if(in_array($order->order_status_id,[ ORDER_STATUS_NEW, ORDER_STATUS_IN_PROGRESS, ORDER_STATUS_SUBMITTED_FOR_APPROVAL, ORDER_STATUS_COMPLETE]))
<div class="card">
   <div class="card-body">
      <?php $attachment = $order->latest_submitted_work(); ?>
   @if($attachment->count() > 0)
   <div class="text-center">
      <a href="{{ route('download_attachment', 'file=' .  $attachment->name) }}" class="btn btn-light btn-lg btn-block"><i class="fas fa-download"></i> Download</a>
   </div>
   <br>
   <div>
      <div class="font-weight-bold">Message:</div>
      <p>
         {{ $attachment->message}}
      </p>

      @if($order->order_status_id == ORDER_STATUS_SUBMITTED_FOR_APPROVAL)
      <div class="text-center">
         <form action="{{ route('accept_delivered_item', $order->id) }}" method="POST">
            {{ csrf_field()  }}
            <input type="hidden" name="submitted_work_id" value="{{ $attachment->id }}">
            <button type="submit" class="btn btn-success btn-lg btn-block">
             <i class="fas fa-check-circle"></i> Accept
            </button>
         </form>
         @if(isRevisionAllowed($order))
            <a href="{{ route('revision_request_page', $order->id )}}" class="btn btn-link">
               Request for revision
            </a>      
         @endif
      </div>
      @endif
   </div>
   @else
      <p class="alert alert-info" role="alert">
         A downlodable link will apprear here when your order is ready
      </p>
   @endif
   </div>
</div>
@endif

