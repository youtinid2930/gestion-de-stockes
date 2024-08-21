@extends('layouts.app')

@section('title', 'Détails de la Facture')

@section('content')
<div class="container">
    <h1>Détails de la Facture</h1>

    <p><strong>Numéro de Facture :</strong> {{ $facture->numero_facture }}</p>
    <p><strong>Date :</strong> {{ $facture->date_facture->format('d/m/Y') }}</p>
    <p><strong>Montant Total :</strong> {{ number_format($facture->montant_total, 2) }} DH</p>
    <p><strong>Client :</strong> {{ $facture->client }}</p>
    <p><strong>Description :</strong> {{ $facture->description }}</p>

    <a href="{{ route('factures.index') }}" class="btn btn-primary">Retour à la liste</a>
</div>
@endsection
