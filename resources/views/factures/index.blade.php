@extends('layouts.app')

@section('title', 'Facture')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <h1>Liste des Factures</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Affichage du terme de recherche (si applicable) -->
            @if(request()->has('query'))
                <div class="alert alert-info">
                    Résultats pour le numéro de facture : <strong>{{ request('query') }}</strong>
                </div>
            @endif

            <table class="mtable">
                <thead>
                    <tr>
                        <th>Numéro de Facture</th>
                        <th>Date</th>
                        <th>Montant Total</th>
                        <th>Client</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($factures as $facture)
                        <tr>
                            <td>{{ $facture->numero_facture }}</td>
                            <td>{{ $facture->date_facture->format('d/m/Y') }}</td>
                            <td>{{ number_format($facture->montant_total, 2) }} DH</td>
                            <td>{{ $facture->client }}</td>
                            <td>{{ $facture->description }}</td>
                            <td>
                                <a href="{{ route('factures.edit', $facture->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="{{ route('factures.print', $facture->id) }}" class="btn btn-secondary btn-sm" target="_blank">Imprimer</a>
                                <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune facture trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mb-3">
                <a href="{{ route('factures.create') }}" class="btn btn-primary">Créer une nouvelle facture</a>
            </div>
        </div>
    </div>
</div>
@endsection
