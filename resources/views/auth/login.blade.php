@extends('layouts.app')

@section('content')
    <form class="form" method="POST" action="{{ route('login') }}">
        @csrf
        <h1 class="login-title">{{ __('Login') }}</h1>

        @error('username')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input placeholder="UserName" id="username" type="text"
            class="login-input{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
            value="{{ old('username') }}" required autofocus>

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input placeholder="Password" id="password" type="password"
            class="login-input @error('password') is-invalid @enderror" name="password" required
            autocomplete="current-password">

        <div class="row mb-3">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="login-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="login-input" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" class="login-button">
            {{ __('Login') }}
        </button>

        @if (Route::has('password.request'))
            <p class="link"><a href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            </p>
        @endif

        <p class="link">Don't have an account? <a href="{{ route('register') }}">Registration Now</a></p>

    </form>
@endsection
