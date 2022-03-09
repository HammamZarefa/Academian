@extends('layouts.app')
@section('title', 'Confirm Password')
@section('content')
<div class="container page-container">
    <div class="row">
        <div class="offset-md-1 col-md-4 d-none d-sm-block">
         <img class="img-fluid" src="{{ asset('images/confirm_password.svg') }}" alt="Confirm Password">
        </div>

        <div class="col-md-7">
            <div class="">
                <h3>{{ __('Confirm Password') }}</h3>

                <div class="">
                    <small class="form-text text-muted">{{ __('Please confirm your password before continuing.') }}</small>
                    <br>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
