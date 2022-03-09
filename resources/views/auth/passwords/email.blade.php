@extends('layouts.app')
@section('title', 'Reset password')
@section('content')
<div class="container page-container">
   <div class="row justify-content-center">
      <div class="offset-md-1 col-md-4 d-none d-sm-block">
         <img class="img-fluid password-reset-page-cover-image" src="{{ asset('images/forgot_password.svg') }}">
      </div>
      <div class="col-md-7">
         <div class="">
            <h4 class="password-reset-page-title">{{ __('Reset Password') }}</h4>
            <div class="">
               @if (session('status'))
               <div class="alert alert-success" role="alert">
                  {{ session('status') }}
               </div>
               @endif
               <form method="POST" action="{{ route('password.email') }}">
                  @csrf
                  <div class="form-group row">
                     <label for="email" class="col-md-4 col-form-label">{{ __('E-Mail Address') }}</label>
                     <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="form-group row mb-0">
                     <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                        {{ __('Send Password Reset Link') }}
                        </button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection