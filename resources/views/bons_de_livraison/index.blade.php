<!-- resources/views/bons_de_livraison/index.blade.php -->

@extends('layouts.app')

@section('title', 'Livraison')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <div class="title">Bons de Livraison</div>
            <a href="{{ route('livraison.create') }}" class="btn btn-primary">Créer Bon de Livraison</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Date de Livraison</th>
                        <th>Adresse de Livraison</th>
                        <th>Commande</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bonsDeLivraison as $bon)
                        <tr>
                            <td>{{ $bon->numero }}</td>
                            <td>{{ $bon->date_livraison->format('d/m/Y') }}</td>
                            <td>{{ $bon->adresse_livraison }}</td>
                            <td>{{ $bon->commande->nom }}</td>
                            <td>
                                <a href="{{ route('livraison.edit', $bon->id) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('livraison.destroy', $bon->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
