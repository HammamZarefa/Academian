@extends('layouts.app')
@section('title', $user->full_name)
@section('content')
	@php
	$route_name     = Route::currentRouteName();
	$group_name     = app('request')->input('group');
	$sub_group_name = app('request')->input('subgroup');
	@endphp
	
	<div class="mb-200">
	  @include('my_account.partials.header')  
	  @include('my_account.partials.profile_layout')
	</div> 
@endsection
@push('scripts')
@yield('innerJs')
@endpush
