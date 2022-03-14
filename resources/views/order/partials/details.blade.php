<div class="row">
   <div class="col-md-8">
      <div class="card order-box">
         <h5>{{ $order->title }}</h5>
         <div>
            <span class="badge badge-brilliant-rose">
                {{ $order->service->price_type->name }}
            </span>
        </div>
         <hr>
         <div class="row">
            <div class="col-md-6">
               {{ $order->number }}
            </div>
            <div class="col-md-6  text-right">
               <div>
                  @if($order->archived)
                     <span class="badge badge-secondary">@lang('Archived')</span>
                  @endif
                  <span class="badge {{ $order->status->badge }}">{{ $order->status->name }}</span>
               </div>
            </div>
         </div>
         <div class="row mt-4">
            @role('admin')
            <div class="col-md-8">
                @lang('Client') : <a href="{{ route('user_profile', $order->customer_id) }}">{{ $order->customer->full_name }}</a>
            </div>
            <div class="col-md-4 text-right">
                @lang('Total')  {{ format_money($order->total) }}
            </div>
            @endrole
            @role('staff')
            <div class="col-md-4">
                @lang('Payout Budget'): {{ format_money($order->staff_payment_amount) }}
            </div>
            @endrole
         </div>
         <p class="order-instruction">
            <?php echo $order->instruction; ?>
         </p>
         <hr>
         <div class="row order-overview">
            <div class="col-md-6"><span class="font-weight-bold">@lang('Service Type')</span>
               <br>
               {{ $order->service->name }}
               @if($order->service->price_type_id == PriceType::PerPage)
                  <div class="font-12 text-danger"><i>* ({{ $order->spacing_type}} @lang('spacing'))</i></div>
               @endif
            </div>
            <div class="col-md-6"><span class="font-weight-bold">@lang('Assigned To')</span>
               @if(isset($order->assignee))
               <br>
               <span class="text-success">
                  @if(auth()->user()->hasRole('admin'))
                     <a href="{{ route('user_profile', $order->staff_id) }}">
                        {{ $order->assignee->full_name }}
                     </a>
                  @else
                     {{ $order->assignee->full_name }}
                  @endif
               </span>
               @else
                 <br>
                    @lang('None')
               @endif
            </div>
         </div>
         <div class="row order-overview">
            <div class="col-md-6"><span class="font-weight-bold">@lang('Posted')</span>
               <br>
               {{ convertToLocalTime($order->created_at)}}
            </div>
            <div class="col-md-6"><span class="font-weight-bold">@lang('Deadline')</span>
               <br>
               @if($order->order_status_id != ORDER_STATUS_PENDING_PAYMENT)
                  {{ convertToLocalTime($order->dead_line) }}
               @else
                  <small class="text-danger">@lang('Applicable after payment')</small>
               @endif
               <span class="font-12 text-info"><i>
                  (@lang('Urgency'): {{ $order->urgency->value }} {{ $order->urgency->type }})
                  </i>
               </span>
            </div>
         </div>
         <div class="row order-overview">
            <div class="col-md-6">
               <span class="font-weight-bold">@lang('Additional Services')</span>
               <br>
               <ol class="pl-4">
                  @foreach($order->added_services()->get() as $service)
                  <li>{{ $service->name }}</li>
                  @endforeach
               </ol>
            </div>
            <div class="col-md-6">
               <div class="font-weight-bold">@lang('Quantity')</div>
               {{ $order->quantity }} {{ $order->unit_name }}
            </div>
         </div>

         <div class="row order-overview">
            <div class="col-md-6">
               <span class="font-weight-bold">@lang('Revision Requested')</span>
               <br>
               {{  $order->revisionUsed() }}
            </div>
            <div class="col-md-6">
               <div class="font-weight-bold">@lang('Attachments')</div>
               <ol class="pl-4">
                  @foreach($order->attachments as $attachment)
                  <li><a target="_blank" href="{{ route('download_attachment', 'file=' .  $attachment->name) }}">{{ $attachment->display_name }}</a></li>
                  @endforeach
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      @if($order->customer_id == auth()->user()->id && $order->order_status_id == ORDER_STATUS_PENDING_PAYMENT)
      <a class="btn btn-sm btn-warning mb-4" href="{{ route('pay_for_existing_order',$order->id) }}">
         <i class="fas fa-money-bill-wave"></i>@lang('Pay Now') </a>
      @endif

      @if(auth()->user()->hasRole('admin') && $order->order_status_id == ORDER_STATUS_PENDING_PAYMENT)
      <div>
      <a id="delete_order" class="btn btn-sm btn-danger" href="{{ route('orders_destroy', $order->id) }}">
         <i class="fas fa-trash"></i>@lang('Delete') </a>
      </div>
      @endif

      @if(!paymentIsPending($order->order_status_id))

            @if($order->order_status_id == ORDER_STATUS_COMPLETE)
               @include('order.partials.rating')
               <br>
            @endif
            @if($order->customer_id == auth()->user()->id)
               @include('order.partials.deliverables')
            @endif
            @if($order->staff_id == auth()->user()->id)
               @include('order.partials.submit_work')
               <br>
            @endif
            @if(auth()->user()->hasRole('admin'))
               @include('order.partials.assignee')
               <br>
            @endif
            @role('admin')
               @include('order.partials.manage_status')
            @endrole
            @if(auth()->user()->hasRole('staff') && settings('enable_browsing_work') == 'yes' && $order->order_status_id == ORDER_STATUS_NEW && empty($order->staff_id))
               @include('order.partials.choose_work')
            @endif

            @role('admin')
               @if($order->isAFollower(auth()->user()->id))
                  <a href="{{ route('orders_unfollow', $order->id) }}">@lang('Unfollow')</a>
               @else
                  <a href="{{ route('orders_follow', $order->id) }}">@lang('Follow')</a>
               @endif

               <div class="mt-4">
                  @if($order->archived)
                     <a href="{{ route('orders_unarchive', $order->id) }}">@lang('Unarchive')</a>
                  @else
                     <a href="{{ route('orders_archive', $order->id) }}">@lang('Archive')</a>
                  @endif
               </div>
            @endrole
      @endif
   </div>
</div>
