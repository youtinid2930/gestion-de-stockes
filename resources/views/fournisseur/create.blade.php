@extends('layouts.app')

@section('title', 'Fournisseur')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ route('fournisseur.store') }}" method="POST">
                @csrf

                <label for="nom">Nom</label>
                <input type="text" name="name" id="nom" placeholder="Veuillez saisir le nom" autocomplete="given-name">
                
                <input type="hidden" name="id" id="id">
                
                <label for="prenom">Prénom</label>
                <input type="text" name="last_name" id="prenom" placeholder="Veuillez saisir le prénom" autocomplete="family-name">
                
                <label for="telephone">N° de téléphone</label>
                <input type="text" name="phone" id="telephone" placeholder="Veuillez saisir le N° de téléphone" autocomplete="tel">
                
                <label for="adresse">Email</label>
                <input type="email" name="email" id="email" placeholder="Veuillez saisir l'adresse email" autocomplete="email">
                
                <label for="adresse">Adresse</label>
                <input type="text" name="address" id="adresse" placeholder="Veuillez saisir l'adresse" autocomplete="street-address">

                <button type="submit">Ajouter</button>

                @if(session('message'))
                    <div class="alert {{ session('message.type') }}">
                        {{ session('message.text') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif
            </form>
        </div>
        <button onclick="window.location.href='{{ route('fournisseur.index') }}'" style="border-radius: 6px;">Precedent</button>
    </div>
</div>
@endsection

