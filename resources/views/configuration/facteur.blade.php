@extends('layouts.app')

@section('title', 'Settings de Facteur')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ route('facteur.settings.update', $facteur->id) }}" method="POST">
                @method('PUT')
                @csrf
                
                <label for="terms_conditions">Termes et Conditions</label>
                <textarea id="terms_conditions" name="terms_conditions" class="form-control">{{ old('terms_conditions', $facteur->terms_conditions_commandes ?? '') }} </textarea>
                @error('terms_conditions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="payment_instructions">Instructions de Paiement</label>
                <textarea id="payment_instructions" name="payment_instructions" class="form-control">{{ old('payment_instructions', $facteur->payment_instructions ?? '') }} </textarea>
                @error('payment_instructions')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="bank_details">Détails Bancaires</label>
                <textarea id="bank_details" name="bank_details" class="form-control">{{ old('bank_details', $facteur->bank_details ?? '') }} </textarea>
                @error('bank_details')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="payment_terms">Conditions de Paiement</label>
                <textarea id="payment_terms" name="payment_terms" class="form-control">{{ old('payment_terms', $facteur->payment_terms ?? '') }} </textarea>
                @error('payment_terms')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" style="border-radius: 6px; margin-top: 2%; margin-bottom: 2%;">
                    {{ 'Save Settings' }}
                </button>
            </form>
            <button onclick="window.history.back()" class="btn" style="margin-top: 2%; margin-bottom: 2%;">Retour</button>
        </div>
    </div>
</div>

@endsection
