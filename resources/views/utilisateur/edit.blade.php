@extends('layouts.app')

@section('title', 'Utilisateur')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ !empty($utilisateur->id) ? route('utilisateur.update', $utilisateur->id) : route('utilisateur.store')  }}" method="POST">
                @csrf
                @if(!empty($utilisateur->id))
                    @method('PUT')
                @endif

                <label for="nom">Nom</label>
                <input value="{{ old('name', $utilisateur->name) }}" type="text" name="name" id="nom" placeholder="Veuillez saisir le nom" autocomplete="given-name">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="prenom">Prénom</label>
                <input value="{{ old('last_name', $utilisateur->last_name) }}" type="text" name="last_name" id="prenom" placeholder="Veuillez saisir le prénom" autocomplete="family-name">
                @error('last_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="telephone">N° de téléphone</label>
                <input value="{{ old('telephone', $utilisateur->telephone) }}" type="text" name="telephone" id="telephone" placeholder="Veuillez saisir le N° de téléphone" autocomplete="tel">
                @error('telephone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="adresse">Adresse</label>
                <input value="{{ old('adresse', $utilisateur->adresse) }}" type="text" name="adresse" id="adresse" placeholder="Veuillez saisir l'adresse" autocomplete="street-address">
                @error('adresse')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="email">Email</label>
                <input value="{{ old('email', $utilisateur->email) }}" type="email" name="email" id="email" placeholder="Veuillez saisir l'adresse email" autocomplete="email">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="etat">État</label>
                <select name="etat" id="etat" autocomplete="state">
                    <option value="actif" {{ old('etat', $utilisateur->etat) == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ old('etat', $utilisateur->etat) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                </select>
                @error('etat')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="role">Rôle</label>
                <select name="role" id="role" autocomplete="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', $utilisateur->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label for="location">Lieu</label>
                <input value="{{ old('location', $utilisateur->location) }}" type="text" name="location" id="location" placeholder="Veuillez saisir le lieu" autocomplete="location">
                @error('location')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <button type="submit">Valider</button>

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
