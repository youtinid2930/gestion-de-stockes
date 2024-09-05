@extends('layouts.app')

@section('title', 'Configuration')

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

            <!-- Liens vers les paramètres -->
            <a href="{{ route('company.settings') }}" class="list-group-item list-group-item-action">
                Informations d'entreprise
            </a>
            <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                Paramètres du Profile
            </a>
            <a href="{{ route('depot.settings') }}" class="list-group-item list-group-item-action">
                Paramètres du dépôt
            </a>
        </div>
    </div>
</div>

@endsection
