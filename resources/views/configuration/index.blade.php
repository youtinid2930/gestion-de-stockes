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
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('company.settings') }}" class="list-group-item list-group-item-action">
                Informations d'entreprise
            </a>
            @endif
            <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                Paramètres du Profile
            </a>
            <a href="{{ route('depot.settings') }}" class="list-group-item list-group-item-action">
                Paramètres du dépôt
            </a>
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('facteur.settings') }}" class="list-group-item list-group-item-action">
                Paramètres du facteur
            </a>
            <a href="{{ route('bon_de_demande.settings') }}" class="list-group-item list-group-item-action">
                Paramètres du bon de demande
            </a>
            <a href="{{ route('bon_de_livraison.settings') }}" class="list-group-item list-group-item-action">
                Paramètres du bon de livraison
            </a>
            @endif
        </div>
    </div>
</div>

@endsection
