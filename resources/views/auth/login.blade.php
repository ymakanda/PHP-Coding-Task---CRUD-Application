@extends('layouts.app')

@section('content')
<div class="container frontend-container">
    <div class="row justify-content-center">
        <div class="col-md-6 frontend-form">
            <h3>Login </h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" placeholder="Your Email *" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" placeholder="Your Password *" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Login" />
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        @if (Route::has('password.request'))
                            <a class="Register" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>  
                    <div class="col-md-6">
                        <a href="{{ route('register') }}" class="ForgetPwd">Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
