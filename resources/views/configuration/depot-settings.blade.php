@extends('layouts.app')

@section('title', 'Configuration')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ isset($depot) ? route('depot.settings.update') : route('depot.settings.store') }}" method="POST">
                @csrf
                @if (isset($depot))
                    @method('PUT')
                @endif

                <label for="depot_name">Nom du dépôt</label>
                <input type="text" id="depot_name" name="name" class="form-control" value="{{ old('name', $depot->name ?? '') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <label for="depot_address">Adresse du dépôt</label>
                <input type="text" id="depot_address" name="addresse" class="form-control" value="{{ old('address', $depot->adresse ?? '') }}" required>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" style="border-radius: 6px; margin-top: 2%; margin-bottom: 2%;">
                    {{ isset($depot) ? 'Update Settings' : 'Save Settings' }}
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
