<ul class="nav nav-tabs order-navigation" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link {{ is_active_nav('', $group_name) }}" href="{{ route('orders_show', $order->id) }}" aria-selected="true">Order Information</a>
  </li>

  @if(auth()->user()->hasRole('admin') ||  in_array(auth()->user()->id, [$order->customer_id, $order->staff_id ]))
  <li class="nav-item">
    <a class="nav-link {{ is_active_nav('messages', $group_name) }}" href="{{ route('orders_show', $order->id) }}?group=messages">Messages</a>
  </li>
  @endif

  @if(auth()->user()->hasRole('admin') ||  (auth()->user()->id ==  $order->staff_id))
  <li class="nav-item">
    <a class="nav-link {{ is_active_nav('submitted-works', $group_name) }}" href="{{ route('orders_show', $order->id) }}?group=submitted-works">Submitted Works</a>
  </li>
  @endif
  
  @if(auth()->user()->hasRole('admin') || (auth()->user()->id ==  $order->customer_id ) )
   <li class="nav-item">
    <a class="nav-link {{ is_active_nav('financial', $group_name) }}" href="{{ route('orders_show', $order->id) }}?group=financial">Financial</a>
  </li>
  @endrole
</ul>

