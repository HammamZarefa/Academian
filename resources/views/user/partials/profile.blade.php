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
               <a href="{{ route('user_profile', $user->id) }}?group=ratings">
               <span class="h6">{{ $ratingCount = $user->ratings_received()->get()->count()}} feedback from clients</span></a>
            </div>
         </div>
         @if(optional($user->meta)->resume)
         <div>           
            <a class="" href="{{ route('download_attachment', ['file' => optional($user->meta)->resume]) }}"><i class="fas fa-file-download"></i> Download Resume</a>
         </div>
         @endif
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
         @if($ratingCount > 0)
         <div class="pt-5 mt-5 delimiter-top">
            <!-- Title -->
            <h6 class="mb-4">Feedback from clients (Most recent 5) <a href="{{ route('user_profile', $user->id) }}?group=ratings">See All</a></h6>         
            <ul class="list-unstyled">
               @foreach($user->ratings_received()->with(['user'])->take(5)->orderBy('id', 'DESC')->get() as $rating) 
               <li class="media mb-5">
                  <a class="mr-3" href="{{ route('user_profile', $rating->user->id) }}" data-toggle="tooltip" data-placement="top" title="{{ $rating->user->full_name }}">
                  <img src="{{ user_photo($rating->user->photo) }}" class="card-profile-image avatar rounded-circle shadow hover-shadow-lg user-avatar" alt="...">
                  </a>
                  <div class="media-body">
                     <h5 class="mt-0 mb-1">{{ star_rating($rating->number)}}</h5>
                     <p>{{ $rating->comment }}</p>
                     <a href="{{ route('orders_show', $rating->order_id) }}"><small class="form-text text-muted">View order</small></a>
                  </div>
               </li>
               @endforeach
            </ul>
         </div>
         @endif
      @endif
   </div>
</div>