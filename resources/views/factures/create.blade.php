@extends('layouts.app')

@section('title','Facture')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
        <h1>Créer une Nouvelle Facture</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('factures.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="numero_facture">Numéro de Facture</label>
                <input type="text" name="numero_facture" id="numero_facture" class="form-control" value="{{ old('numero_facture') }}" required>
            </div>

            <div class="form-group">
                <label for="date_facture">Date de Facture</label>
                <input type="date" name="date_facture" id="date_facture" class="form-control" value="{{ old('date_facture') }}" required>
            </div>

            <div class="form-group">
                <label for="montant_total">Montant Total (DH)</label>
                <input type="number" name="montant_total" id="montant_total" class="form-control" step="0.01" value="{{ old('montant_total') }}" required>
            </div>

            <div class="form-group">
                <label for="client">Client</label>
                <input type="text" name="client" id="client" class="form-control" value="{{ old('client') }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <input type="submit" text="Créer" class="btn btn-primary">
            <a href="{{ route('factures.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
        </div>
    </div>
</div>
@endsection
