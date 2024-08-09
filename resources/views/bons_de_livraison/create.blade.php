<!-- resources/views/bons_de_livraison/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <h2>Créer Bon de Livraison</h2>
            <form action="{{ route('bons_de_livraison.store') }}" method="POST">
                @csrf
                <label for="numero">Numéro</label>
                <input type="text" name="numero" id="numero" required>

                <label for="date_livraison">Date de Livraison</label>
                <input type="date" name="date_livraison" id="date_livraison" required>

                <label for="adresse_livraison">Adresse de Livraison</label>
                <input type="text" name="adresse_livraison" id="adresse_livraison" required>

                <label for="commande_id">Commande</label>
                <select name="commande_id" id="commande_id" required>
                    @foreach($commandes as $commande)
                        <option value="{{ $commande->id }}">{{ $commande->nom }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
    </div>
</div>
@endsection
