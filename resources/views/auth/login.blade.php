@extends('layouts.custom')

@section('content')
    
<form method="POST" action="{{ route('login') }}">
    @csrf
    <center><label class='cls' >Login</label></center>
    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}:<i class="fas fa-user icon fa-1x"></i></label>

    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}:<i class="fas fa-lock icon fa-1x"></i></label>

    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

                        
    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

    <label class="form-check-label" for="remember">
        {{ __('Remember Me') }}
    </label>
                                
    <button type="submit" class="btn btn-primary">
        {{ __('Login') }}
    </button>

    @if (Route::has('password.request'))
        <center><a class="btn btn-link forgot-password" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }} <i class="fas fa-key icon fa-1x"></i>
        </a></center>
    @endif
</form>
    
</div>
@endsection
