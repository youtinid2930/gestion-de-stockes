@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <!-- Afficher le message de succès si présent -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire de paramètres de profil -->
            <form action="{{ route('profile.settings.store') }}" method="POST">
                @csrf
                
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $profile->name ?? '') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $profile->email ?? '') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="phone">Telephone</label>
                <input type="text" id="phone" name="telephone" class="form-control" value="{{ old('telephone', $profile->telephone ?? '') }}">

                <label for="address">Address</label>
                <input type="text" id="address" name="adresse" class="form-control" value="{{ old('adresse', $profile->adresse ?? '') }}">

                <button type="submit" class="btn" style="border-radius: 6px; margin-top: 2%; margin-bottom: 2%;">
                    Enregistrer
                </button>
            </form>
            <button onclick="window.history.back()" class="btn" style="margin-top: 2%; margin-bottom: 2%;">Retour</button>
        </div>
    </div>
</div>

@endsection
