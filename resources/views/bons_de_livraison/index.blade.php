<!-- resources/views/bons_de_livraison/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <div class="title">Bons de Livraison</div>
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
        <button class="btn btn-primary" 
                onclick="window.location.href='{{ route('livraison.create') }}'" 
                style="width: 200px;height:50px; padding: 10px;">
            Créer Bon de Livraison
        </button>    </div>
</div>
@endsection
