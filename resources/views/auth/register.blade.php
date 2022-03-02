@extends('layouts.app')

@section('content')
    <form class="form" method="POST" action="{{ route('register') }}">
        @csrf
        <h1 class="login-title">{{ __('Register') }}</h1>

        <input placeholder="FullName" id="name" type="text" class="login-input @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input placeholder="Email" id="email" type="email" class="login-input @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" required autocomplete="email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input placeholder="UserName" id="username" type="text"
            class="login-input{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
            value="{{ old('username') }}" required>

        @error('username'))
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input placeholder="Phone Number" id="phone" type="text" class="login-input @error('phone') is-invalid @enderror"
            name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input placeholder="Password" id="password" type="password"
            class="login-input @error('password') is-invalid @enderror" name="password" required
            autocomplete="current-password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input placeholder="Confirm Password" id="password-confirm" type="password" class="login-input"
            name="password_confirmation" required autocomplete="new-password">

        <button type="submit" class="login-button">
            {{ __('Register') }}
        </button>

        <p class="link">Already Have an Account <a href="{{ route('login') }}">Login</a></p>

    </form>
@endsection
