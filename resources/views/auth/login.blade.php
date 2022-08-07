@prepend('stylesheets')
@endprepend
@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container page-container login">
   <div class="row">
      <div class="col-lg-5 col-md-8">
         <div class=" zindex-100 mb-0">
            <div class="card-body" id="authentication">
               <div class="mb-5">
                  <h6 class="h3">@lang('Welcome Back!')</h6>
                  <p class="mb-0">@lang('Welcome Back, Please Enter Your Details').</p>
               </div>
               <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group @error('email') is-invalid @enderror">
                     <!-- <label class="form-control-label">{{ __('E-Mail Address') }}</label> -->
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
                     <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                     </div>
                     <div class="d-flex align-items-center justify-content-between mt-3">
                        <!-- <div>
                           <label class="form-control-label">{{ __('Password') }}</label>
                        </div> -->
                        <div class="mb-2">
                           @if (Route::has('password.request'))
                           <a class="Forgot" href="{{ route('password.request') }}">
                           Forgot Password?
                           </a>
                           @endif
                        </div>
                     </div>
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group mb-0">
                     <button type="submit" class="">
                     {{ __('Login') }}
                     <!-- <i class="fas fa-long-arrow-alt-right"></i> -->
                     </button>
                  </div>
               </form>
               <div class="mt-2 have-acount">
                  @lang('Don’t have an account yet?') 
                  <a href="{{ route('register') }}">@lang('Sing Up')</a>
               </div>
            </div>
         </div>
      </div>
      <div class="offs col-lg-5 col-md-4 d-none d-md-block">
         <img class="img-fluid mt-5 login-page-cover-image" src="{{ asset('images/Log In Illustration.png') }}">
      </div>
   </div>
</div>
@endsection
