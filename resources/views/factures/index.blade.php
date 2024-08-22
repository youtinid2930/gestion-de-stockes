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

            <!-- Affichage du terme de recherche ou de la commande (si applicable) -->
            @if(request()->has('commande_id'))
                <div class="alert alert-info">
                    Factures pour la commande : <strong>{{ request('commande_id') }}</strong>
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
                                <a href="{{ route('factures.edit', $facture->id) }}" ><i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la facture"></i></a>
                                <a href="{{ route('factures.print', $facture->id) }}"><i class="fas fa-receipt" data-toggle="tooltip" title="Imprimer la facture"></i></a>
                                <a href="{{ route('factures.show', $facture->id) }}">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('factures.destroy', $facture->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facture ?');" class="delete-button"><i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la facture"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune facture trouvée pour cette commande.</td>
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
