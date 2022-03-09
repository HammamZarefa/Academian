<?php $photo_url = ($user->photo) ? asset(Storage::url($user->photo)) : asset('images/user-placeholder.jpg') ; ?>
<section class="pt-5 pt-lg-0">
   <div class="container">
      <div class="row"> 
         <div class="col-lg-4">
            <div class="sticky-top mt-n175" data-toggle="sticky" data-sticky-offset="30" data-negative-margin=".card-profile-cover">
               <div class="card card-profile border-0">
                  <div class="card-profile-cover">
                     <img alt="Image placeholder" src="{{ $photo_url }}" class="card-img-top user-avatar" >
                  </div>
                  <div class="mx-auto">
                     <img alt="Image placeholder" src="{{ $photo_url }}" class="card-profile-image avatar rounded-circle shadow hover-shadow-lg user-avatar">
                  </div>
                  <div class="card-body p-3 pt-0 text-center">
                     <h5 class="mb-0">{{ $user->full_name }}</h5>                     
                     <div>{{ $user->email }}</div>

                     <table class="table table-sm mt-4">
                        <tr>
                           <td class="text-muted text-left">Joined</td>
                           <td class="text-left">{{ $user->created_at->format("d/m/y") }}</td>  
                        </tr>
                        <tr>
                           <td class="text-muted text-left">Country</td>
                           <td class="text-left">{{ optional($user->meta)->country }}</td>   
                        </tr>
                        <tr>
                           <td class="text-muted text-left">Referral Source</td>
                           <td class="text-left">{{ optional($user->meta)->referral_source }}</td>   
                        </tr>
                     </table>
                     <div class="actions d-flex justify-content-center mt-3 pt-3 px-5 delimiter-top">             
                        <a href="#" id="delete_profile" class="action-item text-danger">
                        <i class="far fa-trash-alt"></i> Delete

                        <form id="deleteProfileForm" method="post" action="{{ route('users_destroy', $user->id) }}"> 
                            @csrf
                            @method('DELETE')                         
                        </form>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-8 mt-lg-5">
            @if($route_name == 'users_edit')
            @include('user.partials.edit_profile') 
            @elseif($group_name == 'orders')
            @include('user.partials.orders')                  
            @elseif($group_name == 'tasks')
            @include('user.partials.tasks') 
            @elseif($group_name == 'ratings')
               @include('user.partials.ratings')
            @elseif($group_name == 'payments')
               @include('user.partials.payments')    
            @elseif($group_name == 'wallet-transactions')
               @include('user.partials.wallet_transactions')           
            @else
            @include('user.partials.profile')
            @endif
         </div>
      </div>
   </div>
</section>