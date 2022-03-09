<div class="card mb-3 bg-white w-100">
   <div class="row no-gutters">
      <div class="col-md-2">
         <?php $photo_url = ($user->photo) ? asset(Storage::url($user->photo)) : asset('images/user-placeholder.jpg') ; ?>
         <div class="mt-md-4 mt-sm-4 text-center"><img src="{{ $photo_url }}" class="avatar rounded-circle"></div>
      </div>
      <div class="col-md-10">
         <div class="card-body">
            <a href="{{ route('user_profile', $user->id) }}" ><h5>{{ $user->full_name }}</h5></a>
            <p class="card-text text-sm text-muted mb-0">Email: {{ $user->email }}</p>
         </div>
      </div>
   </div>
</div>