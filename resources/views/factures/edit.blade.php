@extends('layouts.app')

@section('title', 'Modifier une Facture')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <h1>Modifier la Facture</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('factures.update', $facture->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- This is important for updating the resource -->
                
                <label for="due_date">Date d'échéance</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $facture->due_date) }}" required>
                
                <label for="amount_paid">Montant payé</label>
                <input type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', $facture->amount_paid) }}" required>
                
                <label for="status">Statut</label>
                <select name="status" id="status" required>
                    <option value="">--Choisir le statut--</option>
                    <option value="Payée" {{ old('status', $facture->status) == 'Payée' ? 'selected' : '' }}>Payée</option>
                    <option value="Partiellement payée" {{ old('status', $facture->status) == 'Partiellement payée' ? 'selected' : '' }}>Partiellement payée</option>
                    <option value="Échue" {{ old('status', $facture->status) == 'Échue' ? 'selected' : '' }}>Échue</option>
                </select>
                
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $facture->description) }}</textarea>
                
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                
                <button onclick="window.history.back()" class="btn">Retour</button>
            </form>
        </div>
    </div>
</div>

@endsection
