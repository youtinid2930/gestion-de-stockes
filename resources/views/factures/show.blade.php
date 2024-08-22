@extends('layouts.app')

@section('title', 'Détails de la Facture')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <h1>Détails de la Facture #{{ $facture->numero_facture }}</h1>

            <table class="mtable">
                <tbody>
                    <tr>
                        <th>Numéro de Facture</th>
                        <td>{{ $facture->numero_facture }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ $facture->date_facture->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Montant Total</th>
                        <td>{{ number_format($facture->montant_total, 2) }} DH</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $facture->description }}</td>
                    </tr>
                    @if ($fournisseur)
                        <tr>
                            <th>Fournisseur</th>
                            <td>{{ $fournisseur->name }}</td>
                        </tr>
                    @else
                        <tr>
                            <th>Fournisseur</th>
                            <td>Non disponible</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mb-3">
                <a href="{{ route('factures.index') }}" class="btn btn-primary">Retour à la liste des factures</a>
            </div>
        </div>
    </div>
</div>
@endsection
