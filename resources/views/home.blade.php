@extends('layouts.app')

@section('content')

    <div class="form">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <h2>{{ __('You are logged in!') }}</h2>
        <p>Hey, {{ Auth::user()->name }}</p>
        <p>You are in user dashboard page.</p>
        <p>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
        </p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

@endsection
