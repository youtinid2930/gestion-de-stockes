@extends('layouts.app')

@section('title', 'Company Settings')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ isset($company) ? route('company.settings.update', $company->id) : route('company.settings.store') }}" method="POST">
                @csrf
                @if (isset($company))
                    @method('PUT')
                @endif

                <label for="company_name">Nom de la société</label>
                <input type="text" id="company_name" name="name" class="form-control" value="{{ old('name', $company->name ?? '') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="company_address">Adresse de la société</label>
                <input type="text" id="company_address" name="address" class="form-control" value="{{ old('address', $company->address ?? '') }}" required>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="company_email">Email de la société</label>
                <input type="email" id="company_email" name="email" class="form-control" value="{{ old('email', $company->email ?? '') }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="company_phone">Numéro de téléphone</label>
                <input type="text" id="company_phone" name="contact" class="form-control" value="{{ old('contact', $company->contact ?? '') }}" required>
                @error('contact')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="registration_number">numéro d'enregistrement</label>
                <input type="text" id="registration_number" name="registration_number" class="form-control" value="{{ old('registration_number', $company->registration_number ?? '') }}" required>
                @error('contact')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn" style="border-radius: 6px; margin-top: 2%; margin-bottom: 2%;">
                    {{ isset($company) ? 'Update Settings' : 'Save Settings' }}
                </button>
            </form>
            <button onclick="window.history.back()" class="btn" style="margin-top: 2%; margin-bottom: 2%;">Retour</button>
        </div>
    </div>
</div>

@endsection
