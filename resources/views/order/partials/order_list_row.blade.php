<div class="card order-box shadow bg-white rounded">
   <a href="{{ route('orders_show', $order->id) }}">
      <h5>{{ $order->title }}</h5>
   </a>
   <div class="row">
      <div class="col-md-6">
         {{ $order->number }} 
      </div>
      <div class="col-md-6  text-right">
         @if($order->archived)
            <span class="badge badge-secondary">Archived</span>       
         @endif
         <span class="badge badge-brilliant-rose">
            {{ $order->service->price_type->name }}
            </span>
         <span class="badge {{ $order->status->badge }}">{{ $order->status->name }}</span>
      </div>
   </div>
   <div class="row mt-4">
      <div class="col-md-8">
         Client : <a href="{{ route('user_profile', $order->customer_id) }}">{{ $order->customer->full_name }}</a>
      </div>
      <div class="col-md-4 text-right">
         Total {{ format_money($order->total) }}
      </div>
   </div>
   <p class="order-instruction">
      <?php echo Str::words($order->instruction, 20, ' ...'); ?>         
   </p>
   <div class="row order-overview">
      <div class="col-md-6"><span class="font-weight-bold">Service Type</span>
         <br>
         {{ $order->service->name }}
      </div>
      <div class="col-md-6"><span class="font-weight-bold">Assigned To</span>
         <br>
         <?php 
            if(isset($order->assignee))
            {
               echo '<a href="'.route('user_profile', $order->staff_id).'">'.$order->assignee->full_name.'</a>';                   
            }
            ?>
      </div>
   </div>
   <div class="row order-overview">
      <div class="col-md-6"><span class="font-weight-bold">Posted</span>
         <br>
         {{ convertToLocalTime($order->created_at) }}         
      </div>
      <div class="col-md-6"><span class="font-weight-bold">Deadline</span>
         <br>
         @if($order->order_status_id != ORDER_STATUS_PENDING_PAYMENT)
         {{ convertToLocalTime($order->dead_line) }}  
         @else    
            <small class="text-danger">Applicable after payment</small>
         @endif
         <span class="font-12 text-info"><i>
            (Urgency: {{ $order->urgency->value }} {{ $order->urgency->type }})
            </i>
         </span>       
      </div>
   </div>
</div>