<ul class="nav nav-tabs order-navigation" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link {{ is_active_nav('', $group_name) }}" href="{{ route('user_profile', $user->id) }}" aria-selected="true">Profile</a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ is_active_nav('orders', $group_name) }}" href="{{ route('user_profile', $user->id) }}?group=orders">Orders Placed</a>
  </li>
 
  @if($user->hasRole('staff'))	
  <li class="nav-item">
    <a class="nav-link {{ is_active_nav('tasks', $group_name) }}" href="{{ route('user_profile', $user->id) }}?group=tasks">Assigned Tasks</a>
  </li>
  @endif

</ul>

