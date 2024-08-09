@extends('layouts.app')

@section('title', 'Commande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ !empty($commande) ? route('commande.update', $commande->id) : route('commande.store') }}" method="POST">
                @csrf
                @if (!empty($commande))
                    @method('PUT')
                @endif

                <input value="{{ old('id', $commande->id ?? '') }}" type="hidden" name="id" id="id">
                
                <label for="id_fournisseur">Fournisseur</label>
                <select name="id_fournisseur" id="id_fournisseur">
                    @foreach ($fournisseurs as $value)
                        <option value="{{ $value->id }}" {{ old('id_fournisseur', $commande->fournisseur_id ?? '') == $value->id ? 'selected' : '' }}>
                            {{ $value->name }}
                        </option>
                    @endforeach
                </select>

                <label for="quantite">Quantité</label>
                <input value="{{ old('quantite', $commande->quantite ?? '') }}" type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la quantité">

                <label for="prix">Prix</label>
                <input value="{{ old('prix', $commande->prix ?? '') }}" type="number" name="prix" id="prix" placeholder="Veuillez saisir le prix">

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