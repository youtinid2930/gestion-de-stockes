@extends('layouts.custom')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}:<i class="fas fa-envelope icon fa-1x"></i></label>

        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

                        
        <button type="submit" class="btn btn-primary">
            {{ __('Send') }}
        </button>

        <a class="forgot-password" href="{{ route('login') }}">Retour</a>
                    
@endsection
