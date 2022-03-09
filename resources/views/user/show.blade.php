@extends('layouts.app')
@section('title', $user->full_name)
@section('content')
@php
$route_name     = Route::currentRouteName();
$group_name     = app('request')->input('group');
$sub_group_name = app('request')->input('subgroup');
@endphp
<div class="mb-200">
  @include('user.partials.header')  
  @include('user.partials.profile_layout')
</div> 
@endsection
@push('scripts')
@yield('innerJs')

<script type="text/javascript">	
	$(function(){

		$('#delete_profile').on("click", function (e) {               
            e.preventDefault();
            runSwal($("#deleteProfileForm"));
        });

        function runSwal(form)
	    {
	      Swal.fire({
	        title: 'Are you sure?',
	        text: "You won't be able to revert this!",
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes, delete it!'
	      }).then((result) => {
	        if (result.value) {
	           form.submit();
	        }
	      });

	    }   	

	});
</script>
@endpush