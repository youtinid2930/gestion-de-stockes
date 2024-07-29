@extends('layouts.app')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ !empty($fournisseur->id) ? route('fournisseur.update', $fournisseur->id) : route('fournisseur.store') }}" method="post">
                @csrf
                @method(!empty($fournisseur->id) ? 'PUT' : 'POST')

                <label for="nom">Nom</label>
                <input value="{{ $fournisseur->nom ?? '' }}" type="text" name="name" id="nom" placeholder="Veuillez saisir le nom">
                
                <input value="{{ $fournisseur->id ?? '' }}" type="hidden" name="id" id="id">
            <!--
                <label for="prenom">Prénom</label>
                <input value="{{ $fournisseur->prenom ?? '' }}" type="text" name="prenom" id="prenom" placeholder="Veuillez saisir le prénom">
            -->
                <label for="telephone">N° de téléphone</label>
                <input value="{{ $fournisseur->telephone ?? '' }}" type="text" name="phone" id="telephone" placeholder="Veuillez saisir le N° de téléphone">

                <label for="adresse">Adresse</label>
                <input value="{{ $fournisseur->adresse ?? '' }}" type="text" name="address" id="adresse" placeholder="Veuillez saisir l'adresse">

                <button type="submit">Valider</button>

                @if(session('message'))
                    <div class="alert {{ session('message')['type'] }}">
                        {{ session('message')['text'] }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
