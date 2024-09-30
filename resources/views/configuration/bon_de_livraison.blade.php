@extends('layouts.app')

@section('title', 'Settings de bon de livraison')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ route('bon_de_livraison.settings.update', $company->id) }}" method="POST">
                @method('PUT')
                @csrf
                
                <label for="terms_conditions">Termes et Conditions</label>
                <textarea id="terms_conditions" name="terms_conditions" class="form-control"> {{ old('terms_conditions', $company->terms_conditions_livraison ?? '') }} </textarea>
                @error('terms_conditions')
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