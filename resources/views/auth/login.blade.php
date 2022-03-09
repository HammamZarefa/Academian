@prepend('stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('css/authentication.css') }}">
@endprepend
@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="offset-md-1 col-md-4 d-none d-sm-block">
         <img class="img-fluid mt-5 login-page-cover-image" src="{{ asset('images/login.svg') }}">
      </div>
      <div class="col-md-2"></div>
      <div class="col-md-5">
         <div class="card shadow zindex-100 mb-0">
            <div class="card-body" id="authentication">
               <div class="mb-5">
                  <h6 class="h3">Sign In</h6>
                  <p class="text-muted mb-0">Sign in to your account to continue.</p>
               </div>
               <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group @error('email') is-invalid @enderror">
                     <label class="form-control-label">{{ __('E-Mail Address') }}</label>
                     <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
                        @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="form-group mb-4">
                     <div class="d-flex align-items-center justify-content-between">
                        <div>
                           <label class="form-control-label">{{ __('Password') }}</label>
                        </div>
                        <div class="mb-2">
                           @if (Route::has('password.request'))
                           <a class="small text-muted text-underline--dashed border-primary" href="{{ route('password.request') }}">
                           Lost password?
                           </a>
                           @endif
                        </div>
                     </div>
                     <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">   
                     </div>
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group mb-0">
                     <button type="submit" class="btn btn-sm btn-primary btn-icon rounded-pill">
                     {{ __('Login') }}
                     <i class="fas fa-long-arrow-alt-right"></i>
                     </button>
                  </div>
               </form>
               <hr>
               <div>Don't have an account? <a href="{{ route('register') }}">Sign up</a></div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection