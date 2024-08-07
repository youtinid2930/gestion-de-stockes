@extends('layouts.app')

@section('title', 'Fournisseur')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
        <form action="{{route('fournisseur.update', $fournisseur->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label for="nom">Nom</label>
                <input value="{{ old('name', $fournisseur->name) }}" type="text" name="name" id="nom" placeholder="Veuillez saisir le nom" autocomplete="given-name">
                

                <label for="prenom">Prénom</label>
                <input value="{{ old('last_name', $fournisseur->last_name) }}" type="text" name="last_name" id="prenom" placeholder="Veuillez saisir le prénom" autocomplete="family-name">
               

                <label for="telephone">N° de téléphone</label>
                <input value="{{ old('telephone', $fournisseur->phone) }}" type="text" name="phone" id="telephone" placeholder="Veuillez saisir le N° de téléphone" autocomplete="tel">
                

                <label for="email">Email</label>
                <input value="{{ old('email', $fournisseur->email) }}" type="email" name="email" id="email" placeholder="Veuillez saisir l'adresse email" autocomplete="email">

                <label for="adresse">Adresse</label>
                <input value="{{ old('adresse', $fournisseur->address) }}" type="text" name="address" id="adresse" placeholder="Veuillez saisir l'adresse" autocomplete="street-address">

                <button type="submit">Mise a jour</button>

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
