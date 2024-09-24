@extends('layouts.app')

@section('title', 'Créer une Facture')

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

            <form action="{{ route('factures.store', $commande->id) }}" method="POST">
                @csrf
                
                <label for="due_date">Date d'échéance</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
                
                <label for="amount_paid">Montant payé</label>
                <input type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid') }}" required>
                
                <label for="status">Statut</label>

                <label for="tax_rate">taux d'imposition (%)</label>
                <input type="number" name="tax_rate" id="tax_rate" value="{{ old('tax_rate') }}" required>

                <label for="discount">Remises</label>
                <input type="number" name="discount" id="discount" value="{{ old('discount') }}" required>
                
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                
                <button onclick="window.history.back()" class="btn">Retour</button>
            </form>
        </div>
    </div>
</div>
@endsection
