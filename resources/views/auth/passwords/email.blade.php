@extends('layouts.app')
@section('title', 'Reset password')
@section('content')
@if(session()->get('locale')==='ar')
      <link rel="stylesheet" type="text/css" href="{{ asset('css/authentication-ar.css') }}">
      @else
      <link rel="stylesheet" type="text/css" href="{{ asset('css/authentication.css') }}">
    @endif
<div class="container page-container login">
   <div class="row justify-content-center">
      <!-- <div class="offset-md-1 col-md-4 d-none d-sm-block">
         <img class="img-fluid password-reset-page-cover-image" src="{{ asset('images/forgot_password.svg') }}">
      </div> -->
      <div class="col-sm-12">
            <h6 class="password-reset-page-title justify-content-center">{{ __('Forgot Password?') }}</h6>
            <p class="text-center">@lang('Type In Your Email To Recieve a Password Reset Link')</p>
            <div class="">
               @if (session('status'))
               <div class="alert alert-success" role="alert">
                  {{ session('status') }}
               </div>
               @endif
               <form method="POST" action="{{ route('password.email') }}">
                  @csrf
                  <div class="d-flex justify-content-center mb-4">
                     <!-- <label for="email" class="col-md-4 col-form-label">{{ __('E-Mail Address') }}</label> -->
                     <div class="col-sm-5">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="d-flex justify-content-center mb-4">
                     <div class="col-sm-5">
                        <button type="submit" class="btn btn-primary">
                        {{ __('Send Password Reset Link') }}
                        </button>
                     </div>
                  </div>
                  <div class="mt-2 have-acount text-center">
                  <a href="{{ route('login') }}">@lang('Back To Log In')</a>
               </div>
               </form>
            </div>
      </div>
   </div>
</div>
@endsection