@prepend('stylesheets')
@endprepend
@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="container page-container login">
   <div class="row">
      <div class="col-lg-5 col-md-8">
         <div class="zindex-100 p-4">
            <div class="card-body" id="authentication">
               <div class="mb-5">
                  <h6 class="h3">@lang('Create Account')
                     @if(isset($data['user_role']))
                     {{ $data['user_role'] }}
                     @endif
                  </h6>
               </div>
               <form method="POST" action="{{ route('register') }}" autocomplete="off">
                  @csrf
                  <div class="form-group">
                     <!-- <label for="first_name">{{ __('First Name') }}</label> -->
                     <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" placeholder="First Name">
                     @error('first_name')
                     <span class="invalid-feedback d-block" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <!-- <label for="last_name">{{ __('Last Name') }}</label> -->
                     <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name"
                     placeholder="Last Name">
                     @error('last_name')
                     <span class="invalid-feedback d-block" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group @error('email') is-invalid @enderror">
                     <!-- <label>{{ __('E-Mail Address') }}</label> -->
                     <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input placeholder="name@example.com" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ session()->get( 'email' ) ?? '' }}" {{ session()->get( 'readonly' ) ?? ''}} required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="form-group mb-4 @error('password') is-invalid @enderror">
                     <!-- <label>{{ __('Password') }}</label> -->
                     <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="******">
                     </div>
                     @error('password')
                     <span class="invalid-feedback d-block" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group mb-4">
                     <!-- <label>{{ __('Confirm Password') }}</label> -->
                     <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                           <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="******">
                     </div>
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="form-group row mb-0">
                     <button type="submit" class="">
                     {{ __('Create my account') }}
                     <!-- <i class="fas fa-long-arrow-alt-right"></i> -->
                     </button>
                  </div>
                  @if(isset($data['user_token']))
                  <input id="user_token" type="hidden" class="form-control" name="user_token" value="{{ $data['user_token'] }}">
                  @endif
               </form>
               <div class="mt-2 have-acount">
                  @lang('Have an account?') 
                  <a href="{{ route('login') }}">@lang('Log In')</a>
               </div>
            </div>
         </div>
      </div>
      <div class="offs col-lg-5 col-md-4 d-none d-md-block">
         <img class="img-fluid mt-5" src="{{ asset('images/Sign Up Illustration.png') }}" alt="Register">
      </div>
   </div>
</div>
@endsection
