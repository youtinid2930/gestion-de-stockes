@extends('layouts.app')

@section('title', 'Fournisseur')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ route('fournisseur.store') }}" method="POST">
                @csrf

                <label for="nom">Nom</label>
                <input type="text" name="name" id="nom" placeholder="Veuillez saisir le nom">
                
                <input type="hidden" name="id" id="id">
                
                <label for="prenom">Prénom</label>
                <input type="text" name="last_name" id="prenom" placeholder="Veuillez saisir le prénom">
                
                <label for="telephone">N° de téléphone</label>
                <input type="text" name="phone" id="telephone" placeholder="Veuillez saisir le N° de téléphone">

                <label for="adresse">Email</label>
                <input type="text" name="email" id="email" placeholder="Veuillez saisir l'adresse email">
                
                <label for="adresse">Adresse</label>
                <input type="text" name="address" id="adresse" placeholder="Veuillez saisir l'adresse">

                <button type="submit">Ajouter</button>

                @if(session('message'))
                    <div class="alert {{ session('message.type') }}">
                        {{ session('message.text') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
