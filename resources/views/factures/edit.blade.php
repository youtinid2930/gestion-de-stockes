@extends('layouts.app')

@section('title', 'Modifier Facture')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
           <h1>Modifier Facture</h1>

        <!-- Affichage des messages de succès ou d'erreur -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulaire de modification de facture -->
        <form action="{{ route('factures.update', $facture->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="numero_facture">Numéro de Facture</label>
                <input type="text" id="numero_facture" name="numero_facture" class="form-control" value="{{ old('numero_facture', $facture->numero_facture) }}" required>
            </div>

            <div class="form-group">
                <label for="date_facture">Date</label>
                <input type="date" id="date_facture" name="date_facture" class="form-control" value="{{ old('date_facture', $facture->date_facture->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="montant_total">Montant Total</label>
                <input type="number" id="montant_total" name="montant_total" class="form-control" value="{{ old('montant_total', $facture->montant_total) }}" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="client">Client</label>
                <input type="text" id="client" name="client" class="form-control" value="{{ old('client', $facture->client) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $facture->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('factures.index') }}" class="btn btn-secondary">Retour à la liste</a>
        </form>
    
</div>
</div>
</div>
@endsection
