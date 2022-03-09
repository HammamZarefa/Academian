<div class="card">
   <div class="card-body">
      <h5 class="card-title">About</h5>
      <p>{{ optional($user->meta)->bio }}</p>
      @if($user->hasRole(['staff']))  
      <!-- Badges -->
      <div class="d-lg-flex mt-4">
         <a href="#" class="d-flex align-items-center mr-lg-5 mb-3 mb-lg-0">
            <div>
               <div class="icon icon-sm bg-gradient-success rounded-circle icon-shape">
                  <i class="fas fa-user-ninja"></i>
               </div>
            </div>
            <div class="pl-3"> 
               <span class="h6">
               {{ $tag_count = $user->tags()->count() }} 
               {{ Str::plural('Skill', $tag_count) }}
               </span>
            </div>
         </a>
         <div class="d-flex align-items-center mr-lg-5 mb-3 mb-lg-0">
            <div>
               <div class="icon icon-sm bg-gradient-warning text-white rounded-circle icon-shape">
                  <i class="far fa-user-friends"></i>
               </div>
            </div>
            <div class="pl-3">
               <a href="{{ route('my_account') }}?group=ratings">
                  <span class="h6">{{ $user->ratings_received()->get()->count()}} feedback from clients</span></a>
            </div>
         </div>
      </div>
      <div class="pt-5 mt-5 delimiter-top">
         <!-- Title -->
         <h6>Skills</h6>
         <!-- Skil badges -->
         <div>
            @foreach($user->tags()->get() as $tag)
            <a href="#" class="badge badge-lg badge-soft-primary d-inline-block mr-2 mb-2">{{ $tag->name }}</a>
            @endforeach
         </div>
      </div>
      <div class="pt-5 mt-5 delimiter-top">
         <!-- Title -->
         <h6>Roles</h6>
         <!-- Skil badges -->
         <div>
            @foreach($user->getRoleNames()->toArray() as $role)
            <a href="#" class="badge badge-soft-info mr-2 mb-2">{{ ucfirst($role) }}</a>
            @endforeach
         </div>
      </div>  
      @endif
   </div>
</div>