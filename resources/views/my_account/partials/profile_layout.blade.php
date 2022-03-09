<?php $photo_url = ($user->photo) ? asset(Storage::url($user->photo)) : asset('images/user-placeholder.jpg') ; ?>
<section class="pt-5 pt-lg-0">
   <div class="container">
      <div class="row"> 
         <div class="col-lg-4">
            <div class="sticky-top mt-n175  d-none d-sm-block" data-toggle="sticky" data-sticky-offset="30" data-negative-margin=".card-profile-cover">
               <div class="card card-profile border-0">
                  <div class="card-profile-cover">
                     <img alt="Image placeholder" src="{{ $photo_url }}" class="card-img-top user-avatar" >
                  </div>
                  <a href="#" class="mx-auto">
                  <img alt="Image placeholder" src="{{ $photo_url }}" class="card-profile-image avatar rounded-circle shadow hover-shadow-lg user-avatar">
                  </a>
                  <div class="card-body p-3 pt-0 text-center">
                     <h5 class="mb-0">{{ $user->full_name }}</h5>                     
                     <div>{{ $user->email }}</div>
                     <div>
                        <span class="text-muted">Joined</span> <br>
                        {{ $user->created_at->format("d/m/y") }}
                     </div>
                     <div class="actions d-flex justify-content-center mt-3 pt-3 px-5 delimiter-top">            
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-8 mt-lg-5">        
            @if($group_name == 'change-password')
               @include('my_account.partials.change_password')                  
            @elseif($group_name == 'edit-profile')
               @include('my_account.partials.edit_profile')
            @elseif($group_name == 'ratings')
               @include('my_account.partials.ratings')             
            @elseif($group_name == 'wallet')
               @include('my_account.partials.wallet')  
            @elseif($group_name == 'wallet-transactions')
               @include('my_account.partials.wallet_transactions')  
            @elseif($group_name == 'payments')
               @include('my_account.partials.payments')  
            @else
               @include('my_account.partials.profile')
            @endif
         </div>
      </div>
   </div>
</section>