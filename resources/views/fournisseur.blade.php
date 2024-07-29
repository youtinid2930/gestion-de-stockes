@extends('layouts.app')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ !empty($fournisseur) ? route('fournisseur.update', $fournisseur->id) : route('fournisseur.store') }}" method="POST">
                @csrf
                @if (!empty($fournisseur))
                    @method('PUT')
                @endif

                <label for="nom">Nom</label>
                <input value="{{ old('nom', $fournisseur->nom ?? '') }}" type="text" name="name" id="nom" placeholder="Veuillez saisir le nom">
                
                <input value="{{ old('id', $fournisseur->id ?? '') }}" type="hidden" name="id" id="id">
                
                <label for="prenom">Prénom</label>
                <input value="{{ old('prenom', $fournisseur->prenom ?? '') }}" type="text" name="last_name" id="prenom" placeholder="Veuillez saisir le prénom">
                
                <label for="telephone">N° de téléphone</label>
                <input value="{{ old('telephone', $fournisseur->telephone ?? '') }}" type="text" name="phone" id="telephone" placeholder="Veuillez saisir le N° de téléphone">
                
                <label for="adresse">Adresse</label>
                <input value="{{ old('adresse', $fournisseur->adresse ?? '') }}" type="text" name="address" id="adresse" placeholder="Veuillez saisir l'adresse">

                <label for="adresse">Email</label>
                <input value="{{ old('email', $fournisseur->email ?? '') }}" type="text" name="email" id="adresse" placeholder="Veuillez saisir l'adresse email">

                <button type="submit">Valider</button>

                @if(session('message'))
                    <div class="alert {{ session('message.type') }}">
                        {{ session('message.text') }}
                    </div>
                @endif
            </form>
        </div>
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                @foreach ($fournisseurs as $value)
                    <tr>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->last_name }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->email }}</td>
                        <td><a href="{{ route('fournisseur.edit', $value->id) }}"><i class='bx bx-edit-alt'></i></a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
